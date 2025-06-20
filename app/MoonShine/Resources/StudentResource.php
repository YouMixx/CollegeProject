<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Student;
use Illuminate\Support\Facades\Storage;
use MoonShine\ActionButtons\ActionButton;
use MoonShine\Attributes\Icon;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Text;

// #[Icon('heroicons.academic-cap')]
class StudentResource extends ModelResource
{
    protected string $model = Student::class;

    protected string $title = 'Студенты';

    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable(),
                Text::make('ФИО', 'name')
                    ->required()
                    ->showOnExport(),
                Text::make('Контакты', 'contacts')->required(),
                BelongsTo::make('Компания', 'company', 'name', new CompanyResource)->required(),
                BelongsTo::make('Группа', 'group', 'uuID', new GroupResource)->required(),
            ]),
        ];
    }

    public function search(): array
    {
        return ['id', 'name', 'contacts'];
    }

    public function rules(Model $item): array
    {
        return [];
    }

    public function buttons(): array
    {
        return [
            ActionButton::make(
                'Сформировать сертификат',
                fn ($item) => '/certificate/generate/' . $item->id,
            )
                ->canSee(fn ($item) => !$this->hasDocument($item)),

            ActionButton::make(
                'Открыть сертификат',
                fn ($item) => '/certificate/view/' . $item->id,
            )
                ->canSee(fn ($item) => $this->hasDocument($item))
                ->blank(),

            ActionButton::make(
                'Скачать сертификат',
                fn ($item) => '/certificate/download/' . $item->id,
            )
                ->canSee(fn ($item) => $this->hasDocument($item)),
        ];
    }

    private function hasDocument($student)
    {
        $filePath = "documents/certificates/{$student->id}.pdf";

        return Storage::disk('public')->exists($filePath);
    }
}
