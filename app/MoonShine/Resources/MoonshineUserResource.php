<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\MoonshineUser;
use Illuminate\Validation\Rule;
use MoonShine\Attributes\Icon;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Heading;
use MoonShine\Decorations\Tab;
use MoonShine\Decorations\Tabs;
use MoonShine\Fields\Date;
use MoonShine\Fields\Email;
use MoonShine\Fields\ID;
use MoonShine\Fields\Image;
use MoonShine\Fields\Password;
use MoonShine\Fields\PasswordRepeat;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Relationships\BelongsToMany;
use MoonShine\Fields\Relationships\HasMany;
use MoonShine\Fields\Text;
use MoonShine\Models\MoonshineUserRole;
use MoonShine\Resources\ModelResource;
use MoonShine\Resources\MoonShineUserRoleResource;

#[Icon('heroicons.outline.users')]
class MoonshineUserResource extends ModelResource
{
    public string $model = MoonshineUser::class;

    public string $column = 'name';

    public array $with = ['moonshineUserRole'];

    public function title(): string
    {
        return __('moonshine::ui.resource.admins_title');
    }

    public function fields(): array
    {
        return [
            Block::make([
                Tabs::make([
                    Tab::make('Main', [
                        ID::make()
                            ->sortable()
                            ->showOnExport(),

                        BelongsTo::make(
                            __('moonshine::ui.resource.role'),
                            'moonshineUserRole',
                            static fn (MoonshineUserRole $model) => $model->name,
                            new MoonShineUserRoleResource(),
                        ),

                        Text::make(__('moonshine::ui.resource.name'), 'name')
                            ->required()
                            ->showOnExport(),

                        Image::make(__('moonshine::ui.resource.avatar'), 'avatar')
                            ->showOnExport()
                            ->disk(config('moonshine.disk', 'public'))
                            ->dir('moonshine_users')
                            ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif']),

                        Date::make(__('moonshine::ui.resource.created_at'), 'created_at')
                            ->format("d.m.Y")
                            ->default(now()->toDateTimeString())
                            ->sortable()
                            ->hideOnForm()
                            ->showOnExport(),

                        Email::make(__('moonshine::ui.resource.email'), 'email')
                            ->sortable()
                            ->showOnExport()
                            ->required(),

//                        HasMany::make('Количество', 'applicationUser',
//                            fn($user)=> $user->id,
//                            resource: new ApplicationResource()),

                        HasMany::make('Заявки','applications', resource: new ApplicationResource())
                            ->async()
                            ->creatable()
//                    ->hideOnDetail()
                            ->hideOnIndex(),
                    ]),

                    Tab::make(__('moonshine::ui.resource.password'), [
                        Heading::make('Change password'),

                        Password::make(__('moonshine::ui.resource.password'), 'password')
                            ->customAttributes(['autocomplete' => 'new-password'])
                            ->hideOnIndex()
                            ->eye(),

                        PasswordRepeat::make(__('moonshine::ui.resource.repeat_password'), 'password_repeat')
                            ->customAttributes(['autocomplete' => 'confirm-password'])
                            ->hideOnIndex()
                            ->eye(),
                    ]),
                ]),
            ]),
        ];
    }

    /**
     * @return array{name: string, moonshine_user_role_id: string, email: mixed[], password: string}
     */
    public function rules($item): array
    {
        return [
            'name' => 'required',
            'moonshine_user_role_id' => 'required',
            'email' => [
                'sometimes',
                'bail',
                'required',
                'email',
                Rule::unique('moonshine_users')->ignoreModel($item),
            ],
            'password' => $item->exists
                ? 'sometimes|nullable|min:6|required_with:password_repeat|same:password_repeat'
                : 'required|min:6|required_with:password_repeat|same:password_repeat',
        ];
    }

    public function search(): array
    {
        return ['id', 'name'];
    }
}
