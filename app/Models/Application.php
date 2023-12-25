<?php

namespace App\Models;

use App\DTOs\ApplicationDTO;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;


class Application extends Model
{
    /**
     * Class Application
     * @package App\Models
     *
     * @property int $id
     * @property string $user_id
     * @property string $city
     * @property string $address
     * @property string $budget
     * @property string $phone_whatsapp
     * @property string $comments
     * @property string $status
     * @property Carbon $created_at
     * @property Carbon $updated_at
     * @property Carbon $deleted_at
     *
     * @property Collection $calculationsRequests
     * @property Collection $favoriteCatalogMyautoge
     *
     * @method static Builder|User query()
     */
    use HasFactory;

    const STATUS_ACTIVE = 'Active';
    const STATUS_DELETE = 'Deleted';
    const STATUS_BY_STORE = 'By_in_store';
    const STATUS_BY_OTHER_STORE = 'By_other_store';

    protected $fillable=[
        'user_id',
        'city',
        'address',
        'budget',
        'phone_whatsapp',
        'comments',
        'status',
        'buyer_id'
    ];

    protected $with = ['moonshineUser','user'];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function moonshineUser(): BelongsTo
    {
        return $this->belongsTo(MoonshineUser::class);
    }

    public function createApplication(ApplicationDTO $applicationDTO):self
    {
        return self::query()->create([
            'user_id' => $applicationDTO->user_id,
            'city' => $applicationDTO->city,
            'address' => $applicationDTO->address,
            'budget' => $applicationDTO->budget,
            'phone_whatsapp' => $applicationDTO->phone_whatsapp,
            'comments' => $applicationDTO->comments,
            'status' => self::STATUS_ACTIVE
        ]);

    }
}
