@extends('layouts.app')

@section('content')

<div class="container">

<!-- サマリー -->
<div class="summary-box">

  <div class="summary-item">
    <p class="label">目標体重</p>
    <p class="value">{{ $target->target_weight ?? '未設定' }}kg</p>
  </div>

  <div class="summary-item">
    <p class="label">目標まで</p>
    <p class="value">{{ $diff !== null ? number_format($diff, 1) : '未設定' }}kg</p>
  </div>

  <div class="summary-item">
    <p class="label">最新体重</p>
    <p class="value">{{ $latestLog->weight ?? '未設定' }}kg</p>
  </div>

</div>
  <!-- 検索 -->
<div class="search-row">

  <!-- 左（検索エリア） -->
  <div class="search-left">
    <form method="GET" action="/weight_logs/search" class="search-form">
      <input type="date" name="from" value="{{ request('from') }}">
      <span>~</span>
      <input type="date" name="to" value="{{ request('to') }}">

      <button class="btn-search">検索</button>

      @if(request('from') || request('to'))
        <a href="/weight_logs" class="btn-reset">リセット</a>
      @endif

    </form>
  </div>

  <!-- 右（データ追加） -->
  <div class="search-right">
    <button type="button" id="openModal" class="btn-add">データ追加</button>
  </div>

</div>

  <!-- 検索結果 -->
  @if(request('from') && request('to'))
    <p class="search-result">
      {{ \Carbon\Carbon::parse(request('from'))->format('Y年n月j日') }}
      〜
      {{ \Carbon\Carbon::parse(request('to'))->format('Y年n月j日') }}
      の検索結果 {{ $count }}件
    </p>
  @endif

  <!-- テーブル -->
  <div class="table-wrapper">
    <table class="table">
      <thead>
        <tr>
          <th>日付</th>
          <th>体重</th>
          <th>食事摂取カロリー</th>
          <th>運動時間</th>
          <th></th>
        </tr>
      </thead>

      <tbody>
        @foreach($weightLogs as $log)
        <tr>
          <td>{{ \Carbon\Carbon::parse($log->date)->format('Y/n/j') }}</td>
          <td>{{ $log->weight }}kg</td>
          <td>{{ $log->calories ? $log->calories . 'kcal' : '-' }}</td>
          <td>{{ \Carbon\Carbon::parse($log->exercise_time)->format('H:i') }}</td>

          <!-- 🔥 修正済みボタン -->
          <td>
            <button
              type="button"
              class="edit-btn"
              data-id="{{ $log->id }}"
              data-date="{{ $log->date }}"
              data-weight="{{ $log->weight }}"
              data-calories="{{ $log->calories }}"
              data-time="{{ $log->exercise_time }}"
              data-content="{{ $log->exercise_content }}"
            >
              ✏️
            </button>
          </td>

        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <!-- ページネーション -->
  <div class="pagination-wrapper">
   {{ $weightLogs->links('pagination::bootstrap-4') }}
  </div>

</div>

<!-- ========================= -->
<!-- 追加モーダル -->
<!-- ========================= -->
<div id="createmodal" class="modal hidden">
  <div class="modal-content">

    <h2>Weight Logを追加</h2>

<form method="POST" action="/weight_logs">
  @csrf

  <label>日付<span class="required">必須</span></label>
  <input type="date" name="date" value="{{ old('date') }}">
  @error('date')
    <p class="error">{{ $message }}</p>
  @enderror

  <label>体重<span class="required">必須</span></label>
  <input type="text" name="weight" value="{{ old('weight') }}">
  @error('weight')
    <p class="error">{{ $message }}</p>
  @enderror

  <label>カロリー<span class="required">必須</span></label>
  <input type="text" name="calories" value="{{ old('calories') }}">
  @error('calories')
    <p class="error">{{ $message }}</p>
  @enderror

  <label>運動時間<span class="required">必須</span></label>
  <input type="time" name="exercise_time" value="{{ old('exercise_time') }}">
  @error('exercise_time')
    <p class="error">{{ $message }}</p>
  @enderror

  <label>運動内容</label>
  <textarea name="exercise_content">{{ old('exercise_content') }}</textarea>
  @error('exercise_content')
    <p class="error">{{ $message }}</p>
  @enderror

  <div class="modal-buttons">
    <button type="button" id="closeModal">戻る</button>
    <button type="submit">登録</button>
  </div>
</form>
  </div>
</div>

<!-- ========================= -->
<!-- 更新モーダル -->
<!-- ========================= -->
<div id="editModal" class="modal hidden">
  <div class="modal-content">

    <h2>Weight Logを更新</h2>

    <!-- 更新フォーム -->
    <form id="editForm" method="POST">
      @csrf
      @method('PUT')

      <label>日付</label>
      <input type="date" id="editDate" name="date">

      <label>体重</label>
      <input type="text" id="editWeight" name="weight">

      <label>カロリー</label>
      <input type="text" id="editCalories" name="calories">

      <label>運動時間</label>
      <input type="time" id="editTime" name="exercise_time">

      <label>運動内容</label>
      <textarea id="editContent" name="exercise_content"></textarea>

      <!-- ボタンエリア -->
      <div class="modal-buttons">
        <button type="button" id="closeEditModal">戻る</button>
        <button type="submit">更新</button>

        <!-- ゴミ箱 -->
        <button type="button" class="btn-delete" onclick="deleteLog()">
          🗑
        </button>
      </div>

    </form>

    <!-- 削除フォーム（裏で使う） -->
    <form id="deleteForm" method="POST">
      @csrf
      @method('DELETE')
    </form>

  </div>
</div>
<!-- ========================= -->
<!-- JS -->
<!-- ========================= -->
<script>
// ===== 追加モーダル =====
const createModal = document.getElementById('createmodal');

document.getElementById('openModal').onclick = () => {
  createModal.classList.remove('hidden');
};

document.getElementById('closeModal').onclick = () => {
  createModal.classList.add('hidden');
};

// ===== 編集モーダル =====
const editModal = document.getElementById('editModal');
const editForm = document.getElementById('editForm');

document.querySelectorAll('.edit-btn').forEach(btn => {
  btn.addEventListener('click', () => {

    const id = btn.dataset.id;

    editModal.classList.remove('hidden');

    document.getElementById('editDate').value =
  btn.dataset.date
    .split(' ')[0]
    .replaceAll('/', '-');

    document.getElementById('editWeight').value = btn.dataset.weight;
    document.getElementById('editCalories').value = btn.dataset.calories;
    const rawTime = btn.dataset.time;

const formattedTime = rawTime.slice(0,5); // "10:10:00" → "10:10"

document.getElementById('editTime').value = formattedTime;
    document.getElementById('editContent').value = btn.dataset.content;

    editForm.action = `/weight_logs/${id}`;
  });
});

document.getElementById('closeEditModal').onclick = () => {
  editModal.classList.add('hidden');
};

@if ($errors->any())
  document.getElementById('createmodal').classList.remove('hidden');
@endif

function deleteLog() {
  const id = editForm.action.split('/').pop();
  const deleteForm = document.getElementById('deleteForm');

  deleteForm.action = `/weight_logs/${id}`;
  deleteForm.submit();
}
</script>

@endsection