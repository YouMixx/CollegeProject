<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Course;

use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Number;
use MoonShine\Fields\Text;

class CourseResource extends ModelResource
{
    protected string $model = Course::class;

    protected string $title = 'Курсы';

    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable(),
                Text::make('Название', 'name')
                    ->required()
                    ->showOnExport(),
                Text::make('Описание', 'description')->required(),
                Number::make('Длительность (академ. час)', 'duration')->required(),
            ]),
        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }
}
