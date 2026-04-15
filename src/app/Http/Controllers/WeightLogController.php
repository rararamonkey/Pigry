<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WeightLog;
use App\Models\WeightTarget;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\GoalRequest;
use App\Http\Requests\WeightRequest;

class WeightLogController extends Controller
{
    // 一覧
    public function index()
{
    $weightLogs = WeightLog::where('user_id', auth()->id())
        ->orderBy('date', 'desc')
        ->paginate(8);

    $target = WeightTarget::where('user_id', auth()->id())->first();

    $latestLog = WeightLog::where('user_id', auth()->id())
        ->latest()
        ->first();

    $diff = null;
    if ($target && $latestLog) {
        $diff = $latestLog->weight - $target->target_weight;
    }

    $count = $weightLogs->count();

    return view('weight_logs.index', [
        'weightLogs' => $weightLogs,
        'target' => $target,
        'latestLog' => $latestLog,
        'diff' => $diff,
        'count' => $count,
    ]);
}

    // 登録画面（モーダル用なら空でもOK）
    public function create()
    {
        return view('weight_logs.create');
    }

    // 登録処理
    public function store(WeightRequest $request)
    {
        WeightLog::create([
            'user_id' => Auth::id(),
            'date' => $request->date,
            'weight' => $request->weight,
            'calories' => $request->calories,
            'exercise_time' => $request->exercise_time,
            'exercise_content' => $request->exercise_content,
        ]);

        return redirect('/weight_logs');
    }

    //  検索
    public function search(Request $request)
{
    $query = WeightLog::where('user_id', Auth::id());

    if ($request->from) {
        $query->whereDate('date', '>=', $request->from);
    }

    if ($request->to) {
        $query->whereDate('date', '<=', $request->to);
    }

    $logs = $query->paginate(8);

    $target = WeightTarget::where('user_id', Auth::id())->first();

    $latestLog = WeightLog::where('user_id', Auth::id())->latest()->first();

    $diff = null;
    if ($target && $latestLog) {
        $diff = $latestLog->weight - $target->target_weight;
    }

    $count = $logs->count(); // ← これ追加！！

    return view('weight_logs.index', [
        'weightLogs' => $logs,
        'target' => $target,
        'latestLog' => $latestLog,
        'diff' => $diff,
        'count' => $count,
    ]);
}

    // 更新
    public function update(WeightRequest $request, $id)
{
    $log = WeightLog::findOrFail($id);

    $log->update($request->all());

    return redirect('/weight_logs');
}

    // 削除
    public function destroy($id)
    {
        $log = WeightLog::findOrFail($id);
        $log->delete();

        return redirect('/weight_logs');
    }

    // 目標体重画面
    public function goalSetting()
    {
        $target = WeightTarget::where('user_id', Auth::id())->first();

        return view('weight_logs.goal_setting', compact('target'));
    }

    // 目標体重更新
    public function updateTarget(GoalRequest $request)
    {
        $request->validate([
            'target_weight' => 'required|numeric',
        ]);

        WeightTarget::updateOrCreate(
            ['user_id' => Auth::id()],
            ['target_weight' => $request->target_weight]
        );

        return redirect('/weight_logs');
    }
}