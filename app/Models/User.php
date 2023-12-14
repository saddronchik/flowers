<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\DTOs\UserDTO;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 * @package App\Models
 *
 * @property int $id
 * @property string $full_name
 * @property string $password
 * @property string $phone
 * @property string $fcm_token
 * @property string $city
 * @property string $store_name
 * @property string $login
 * @property string $email
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 *
 * @property Collection $calculationsRequests
 * @property Collection $favoriteCatalogMyautoge
 *
 * @method static Builder|User query()
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'city',
        'store_name',
        'phone',
        'fcm_token',
        'login',
        'email',
        'email_verified_at',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public static function registerUser(UserDTO $userDTO):self
    {
        return self::query()->create([
            'full_name' => $userDTO->full_name,
            'store_name' => $userDTO->store_name,
            'phone' => $userDTO->phone,
            'login' => $userDTO->login,
            'email' => $userDTO->email,
            'password' => bcrypt($userDTO->password),
            'fcm_token' => $userDTO->fcm_token,
            'city' => $userDTO->city
        ]);
    }

    public function changePassword(string $newPassword): void
    {
        $this->update([
            'password' => bcrypt($newPassword),
        ]);
    }

    public function updateFcmToken(string $fcmToken): void
    {
        $this->fcm_token = $fcmToken;
        $this->save();
    }

    public function createAuthToken(string $salt): string
    {
        return $this->createToken($salt)->plainTextToken;
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
