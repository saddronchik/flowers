<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Application;
use MoonShine\Fields\TinyMce;

use MoonShine\Fields\Number;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Select;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;

class ApplicationResource extends ModelResource
{
    protected string $model = Application::class;

    protected string $title = 'Список заявок';

    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable(),
                BelongsTo::make(trans('buttons.user'), 'user',
                    fn($user)=> $user->id.' | '.$user->store_name,
                    resource: new UsersResource())
                    ->asyncSearch()
                    ->required(),
                Select::make(trans('buttons.city'),'city')
                    ->options([
                        'Алматы'=>'Алматы',
                        'Астана'=>'Астана',
                        'Караганда'=>'Караганда'
                    ])
                    ->required(),
                Text::make(trans('buttons.address'),'address')->required(),
                Number::make(trans('buttons.budget'),'budget')->required(),
                Text::make(trans('buttons.phone_whatsapp'),'phone_whatsapp')->required(),
                Text::make(trans('buttons.comments'),'comments')
                    ->hideOnIndex()
                    ->required(),
                Select::make(trans('buttons.status'),'status')
                    ->options([
                        Application::STATUS_ACTIVE=>'Активна',
                        Application::STATUS_DELETE=>'Удалена',
                        Application::STATUS_BY_STORE=>'Куплена в магазине',
                        Application::STATUS_BY_OTHER_STORE=>'Куплена в другом месте'
                    ])
                    ->required(),
                BelongsTo::make(trans('buttons.buyer'), 'buyer',
                    fn($buyer)=> $buyer->id.' | '.$buyer->email,
                    resource: new BuyersResource())->required(),
            ]),
        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }
}
