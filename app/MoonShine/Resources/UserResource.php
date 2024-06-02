<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use MoonShine\Resources\ModelResource;
use Illuminate\Validation\Rule;
use MoonShine\Attributes\Icon;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Heading;
use MoonShine\Decorations\Tab;
use MoonShine\Decorations\Tabs;
use MoonShine\Fields\Date;
use MoonShine\Fields\Email;
use MoonShine\Fields\Field;
use MoonShine\Fields\ID;
use MoonShine\Fields\Image;
use MoonShine\Fields\Password;
use MoonShine\Fields\PasswordRepeat;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Select;
use MoonShine\Fields\Text;
use MoonShine\Models\MoonshineUserRole;
use MoonShine\Resources\MoonShineUserRoleResource;

// #[Icon('heroicons.outline.users')]
class UserResource extends ModelResource
{
    protected string $model = User::class;

    protected string $title = 'Сотрудники';

    public function fields(): array
    {
        return [
            Block::make([
                Tabs::make([
                    Tab::make('Основное', [
                        ID::make()
                            ->sortable()
                            ->showOnExport(),

                        Select::make(
                            'Роль',
                            'role',
                        )
                            ->options([
                                'admin' => 'Администратор',
                                'manager' => 'Менеджер',
                                'educator' => 'Преподаватель',
                            ]),

                        Text::make('Имя', 'name')
                            ->required()
                            ->showOnExport(),

                        Text::make('Контакты', 'contacts')
                            ->required()
                            ->showOnExport(),


                        Image::make('Фотография', 'avatar')
                            ->changePreview(function ($value, Field $field) {
                                return view('moonshine::ui.image', [
                                    'value' => strpos($value, 'http') === 0 ? $value : Storage::url($value)
                                ]);
                            })
                            ->showOnExport()
                            ->disk(config('moonshine.disk', 'public'))
                            ->dir('moonshine_users')
                            ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif']),

                        Email::make('Почта', 'email')
                            ->sortable()
                            ->showOnExport()
                            ->required(),
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

    public function rules($item): array
    {
        return [
            'name' => 'required',
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
