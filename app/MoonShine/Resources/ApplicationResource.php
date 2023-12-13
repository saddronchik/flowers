<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Application;
use MoonShine\Fields\TinyMce;
use MoonShine\Resources\MoonShineUserResource;
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

    protected string $title = 'Список заявок на покупку цветов';

    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable(),
                Select::make('Город','city')
                    ->options([
                        'Алматы'=>'Алматы',
                        'Астана'=>'Астана',
                        'Караганда'=>'Караганда'
                    ])
                    ->required(),
                Text::make('Адрес','address')->required(),
                Number::make('Бюджет','budget')->required(),
                Number::make('Whatsapp','phone_whatsapp')->required(),
                TinyMce::make('Комментарий','comments')->required(),
                Select::make('Статус','status')
                    ->options([
                        Application::STATUS_ACTIVE=>'Активна',
                        Application::STATUS_DELETE=>'Удалена',
                        Application::STATUS_BY_STORE=>'Куплена в магазине',
                        Application::STATUS_BY_OTHER_STORE=>'Куплена в другом месте'
                    ])
                    ->required(),
                BelongsTo::make('Автор', 'moonshineUser',
                    resource: new MoonShineUserResource())->required(),

//                BelongsTo::make('Автор','moonshineUser', new MoonShineUserResource())
//                    ->required()
//                    ->addLink('ссылка на автора', function() {
//                        if(!$this->getItem()) {
//                            return route('moonshine.moonShineUsers.index');
//                        }
//                        return route('moonshine.moonShineUsers.show',$this->getItem()->moonshine_user_id);
//                    }),
            ]),
        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }
}