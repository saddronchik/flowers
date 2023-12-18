<?php

declare(strict_types=1);

namespace App\Providers;

use App\MoonShine\Resources\ApplicationResource;
use App\MoonShine\Resources\MoonshineUserResource;
use App\MoonShine\Resources\UsersResource;
use MoonShine\Providers\MoonShineApplicationServiceProvider;
use MoonShine\MoonShine;
use MoonShine\Menu\MenuGroup;
use MoonShine\Menu\MenuItem;
//use MoonShine\Resources\MoonShineUserResource;
use MoonShine\Resources\MoonShineUserRoleResource;

class MoonShineServiceProvider extends MoonShineApplicationServiceProvider
{
    protected function resources(): array
    {
        return [];
    }

    protected function pages(): array
    {
        return [];
    }

    protected function menu(): array
    {
        return [

            MenuGroup::make('Сбор информации',[
                MenuItem::make('Заявки цветов',new ApplicationResource()),
                MenuItem::make('Продавцы',new UsersResource()),
            ]),
            MenuGroup::make(static fn() => __('moonshine::ui.resource.system'), [
                MenuItem::make('Пользователи',new MoonshineUserResource()),
//               MenuItem::make(
//                   static fn() => __('Пользователи'),
//                   new MoonShineUserResource()
//               ),
               MenuItem::make(
                   static fn() => __('moonshine::ui.resource.role_title'),
                   new MoonShineUserRoleResource()
               ),
            ]),

//            MenuItem::make('Documentation', 'https://moonshine-laravel.com')
//               ->badge(fn() => 'Check'),
        ];
    }

    /**
     * @return array{css: string, colors: array, darkColors: array}
     */
    protected function theme(): array
    {
        return [];
    }
}
