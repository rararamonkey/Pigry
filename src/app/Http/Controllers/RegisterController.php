<?php
namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\WeightRequest;
use App\Models\User;
use App\Models\WeightTarget;
use App\Models\WeightLog;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Step2Request;

class RegisterController extends Controller
{
    // STEP1画面
    public function index()
    {
        return view('register.step1');
    }

    // STEP1 → セッション保存
    public function confirm(RegisterRequest $request)
    {
        session([
            'register' => $request->only(['name', 'email', 'password'])
        ]);

        return redirect('/register/step2');
    }
    
    // STEP2画面
    public function step2()
    {
     if (!session('register')) {
        return redirect('/register/step1');
    }

    return view('register.step2');
    }

    //  保存処理（超重要）
    public function store(Step2Request $request)
{
     // セッション取得
    $data = session('register');
    if (!$data) {
        return redirect('/register/step1');
    }

    // ① ユーザー作成（安全版）
try {
    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
    ]);
} catch (\Exception $e) {
    return redirect('/register/step1')
        ->withErrors(['email' => 'メールアドレスは既に使用されています']);
}

Auth::login($user);
$request->session()->regenerate();

    // ② 目標体重
    WeightTarget::create([
        'user_id' => $user->id,
        'target_weight' => $request->target_weight,
    ]);

    // ③ 体重ログ（初回）
        WeightLog::create([
            'user_id' => $user->id,
            'date' => now()->format('Y-m-d'),
            'weight' => $request->weight,
        ]);
        session()->forget('register');
        
        return redirect('/weight_logs');
}
}
