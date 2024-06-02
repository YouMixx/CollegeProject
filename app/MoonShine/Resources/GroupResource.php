<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Group;
use MoonShine\Attributes\Icon;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Relationships\HasMany;
use MoonShine\Fields\Select;
use MoonShine\Fields\Text;

// #[Icon('heroicons.list-bullet')]
class GroupResource extends ModelResource
{
    protected string $model = Group::class;

    protected string $title = 'Группы';

    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable(),
                Text::make('Внутренний номер', 'uuID'),
                BelongsTo::make('Преподаватель', 'educator', 'name', new UserResource),
                BelongsTo::make('Курс', 'course', 'name', new CourseResource),
                Select::make('Статус', 'status')
                    ->options([
                        'recruitment' => 'Набор',
                        'completed' => 'Завершен',
                        'progress' => 'В процессе',
                    ]),
                HasMany::make('Обучающиеся', 'students', 'fio', new StudentResource)
                    ->hideOnIndex(),
            ]),
        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }
}
