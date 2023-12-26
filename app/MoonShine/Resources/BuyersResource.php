<?php

namespace App\MoonShine\Resources;

use App\Models\Buyer;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Relationships\HasMany;
use MoonShine\Fields\Select;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;

class BuyersResource extends ModelResource
{
    protected string $model = Buyer::class;

    protected string $title = 'Список покупателей';

    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable(),
                Text::make('Email','email')->required(),
                Select::make('Статус','status')
                    ->options([
                        Buyer::STATUS_ACTIVE=>'Активен',
                        Buyer::STATUS_REFUSED=>'Отказано',
                    ])->default('Status')
                    ->required(),

                HasMany::make('Заявки','applications', resource: new ApplicationResource())
                    ->async()
                    ->creatable()
//                    ->hideOnDetail()
                    ->hideOnIndex(),
            ])
        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }
}
