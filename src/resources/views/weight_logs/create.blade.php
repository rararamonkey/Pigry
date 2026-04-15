<form method="POST" action="/weight_logs">
    @csrf

    <div>
        <label>日付</label>
        <input type="text" id="datePicker" name="date">
    </div>

    <div>
        <label>体重</label>
        <input type="number" step="0.1" name="weight">
    </div>

    <div>
        <label>摂取カロリー</label>
        <input type="text" name="calories"> kcal
    </div>

    <div>
        <label>運動時間</label>
        <input type="text" id="timePicker" name="exercise_time">
    </div>

    <div>
        <label>運動内容</label>
        <textarea name="exercise_content"></textarea>
    </div>

    <button type="submit">保存</button>
</form>