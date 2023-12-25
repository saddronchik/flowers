<?php

namespace App\Models;

use App\DTOs\BuyersDTO;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class Buyer
 * @package App\Models
 *
 * @property int $id
 * @property string $email
 * @property string $code
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 *
 *
 * @method static Builder|User query()
 */
class Buyer extends Authenticatable
{
    use HasFactory,HasApiTokens,Notifiable;
    const STATUS_ACTIVE = 'Active';
    const STATUS_REFUSED = 'Refused';

    protected $fillable = ['email','code','status'];

    public static function registerBuyers(BuyersDTO $buyersDTO):self
    {
        return self::query()->create([
            'email' => $buyersDTO->email,
            'code' => bcrypt($buyersDTO->code),
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    public function createAuthToken(string $salt): string
    {
        return $this->createToken($salt)->plainTextToken;
    }
}
