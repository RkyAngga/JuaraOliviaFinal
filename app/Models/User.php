<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Http\Controllers\MasyarakatController;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama_lengkap',
        'username',
        'email',
        'password',
        'nomor_telepon',
        'role',
        'nik',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            if ($user->role === 'masyarakat') {
                app(MasyarakatController::class)->createMasyarakatRecord($user);
            }
        });

        static::updating(function ($user) {
            \Illuminate\Support\Facades\Log::info('User updating', [
                'user_id' => $user->id,
                'changes' => $user->getDirty(),
                'original' => $user->getOriginal()
            ]);
        });

        static::updated(function ($user) {
            \Illuminate\Support\Facades\Log::info('User updated', [
                'user_id' => $user->id,
                'changes' => $user->getChanges()
            ]);
        });
    }

    /**
     * Get the masyarakat record associated with the user.
     */
    public function masyarakat(): HasOne
    {
        return $this->hasOne(Masyarakat::class, 'user_id');
    }

    public function dinas()
    {
        return $this->hasOne(Dinas::class, 'user_id');
    }

    public function dinasPusat()
    {
        return $this->belongsToMany(Dinas::class, 'pemerintah_pusat_dinas', 'user_id', 'dinas_id')
            ->withPivot(['username', 'nomor_telepon', 'email', 'wilayah', 'latitude', 'longitude'])
            ->withTimestamps();
    }
}
