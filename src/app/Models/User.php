<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\WeightTarget;
use App\Models\WeightLog;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * 一括代入OK項目
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * 表示させない項目（セキュリティ）
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * 型変換
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     *  目標体重（1対1）
     */
    public function weightTarget()
    {
        return $this->hasOne(WeightTarget::class);
    }

    /**
     *  体重ログ（1対多）
     */
    public function weightLogs()
    {
        return $this->hasMany(WeightLog::class);
    }
}