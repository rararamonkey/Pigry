@extends('layouts.app')

@section('content')

<div class="goal-container">
  <h2 class="goal-title">目標体重設定</h2>

  <form method="POST" action="{{ url('/weight_logs/goal_setting') }}">
    @csrf

    <div class="goal-form-group">
      <label>目標体重</label>

      <div class="goal-input-row">
        <input type="text" name="target_weight" value="{{ old('target_weight', $target->target_weight ?? '') }}">
        <span>kg</span>
      </div>

      @error('target_weight')
        <p class="error">{{ $message }}</p>
      @enderror
    </div>

    <div class="goal-buttons">
      <a href="/weight_logs" class="btn-back">戻る</a>
      <button type="submit" class="btn-submit">更新</button>
    </div>

  </form>
</div>

@endsection