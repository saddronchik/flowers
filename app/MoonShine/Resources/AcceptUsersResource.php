<?php

declare(strict_types = 1);

namespace App\MoonShine\Resources;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Fields\Field;
use MoonShine\Fields\Relationships\HasMany;
use MoonShine\Fields\Relationships\HasOne;
use MoonShine\Fields\Select;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use Illuminate\Contracts\Database\Eloquent\Builder;

class AcceptUsersResource extends ModelResource
{
    protected string $model = User::class;

    protected string $title = 'Продавцы откликнувшиеся на заявку';
    public function query(): Builder
    {
        return parent::query()->has('applications');
    }
    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable(),
                Text::make(trans('buttons.full_name'), 'full_name')->required(),
                Text::make(trans('buttons.store_name'), 'store_name')->required(),
                Text::make(trans('buttons.phone'), 'phone')->required(),
                Text::make(trans('buttons.login'), 'login')
                    ->hideOnIndex()
                    ->required(),
                Select::make(trans('buttons.city'), 'city')
                    ->options([
                        'Алматы' => 'Алматы',
                        'Астана' => 'Астана',
                        'Караганда' => 'Караганда'
                    ])
                    ->required(),

                Select::make(trans('buttons.status'), 'status')
                    ->options([
                        User::STATUS_MODERATION => 'На модерации',
                        User::STATUS_ACTIVE => 'Активен',
                        User::STATUS_REFUSED => 'Отказано',
                    ])->default('Status')
                    ->required(),

                Text::make(trans('buttons.count_applications'))
                    ->changeFill(fn(User $user, Field $field)=>$user->applications()->count())
                    ->hideOnDetail()
                    ->hideOnCreate()
                    ->hideOnUpdate(),

                HasMany::make(trans('buttons.applications'), 'applications', resource: new ApplicationResource())
                    ->async()
                    ->creatable()
                    ->hideOnIndex(),
            ]),
        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }
}


