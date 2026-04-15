<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\WeightTarget;

class WeightTarget extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'target_weight',
    ];

    // 🔗 Userとのリレーション（あると便利）
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function index(Request $request)
{
    $query = WeightLog::where('user_id', Auth::id());

    if ($request->from) {
        $query->where('date', '>=', $request->from);
    }

    if ($request->to) {
        $query->where('date', '<=', $request->to);
    }

    $weightLogs = $query
        ->orderBy('date', 'desc')
        ->get();

    // 👇ここに追加（この位置が正解）
    $target = WeightTarget::where('user_id', Auth::id())->first();

    return view('weight_logs.index', compact('weightLogs', 'target'));
}
}