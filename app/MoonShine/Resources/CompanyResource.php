<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Company;
use Illuminate\Support\Facades\Storage;
use MoonShine\ActionButtons\ActionButton;
use MoonShine\Attributes\Icon;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Relationships\HasMany;
use MoonShine\Fields\Select;
use MoonShine\Fields\Text;

// #[Icon('heroicons.clipboard-document-check')]
class CompanyResource extends ModelResource
{
    protected string $model = Company::class;

    protected string $title = 'Компании';

    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable(),
                Text::make('Наименование', 'name')->required(),
                Text::make('Внутреннее описание', 'description')->hideOnIndex(),
                Text::make('Директор компании', 'director')->required(),
                Text::make('ИНН', 'inn')->required(),
                Text::make('КПП', 'kpp')->required()->hideOnIndex(),
                Text::make('ОРГН', 'ogrn')->required()->hideOnIndex(),
                Text::make('Телефон', 'phone')->required()->hideOnIndex(),
                Text::make('Почта', 'email')->required()->hideOnIndex(),
                Select::make('Тип', 'type')
                    ->options([
                        'individual' => 'Индивидуальный предприниматель',
                        'ooo' => 'Общество с ограниченной ответственностью',
                    ])
                    ->required(),
                HasMany::make('Обучающиеся', 'students', 'name', new StudentResource)
                    ->hideOnIndex(),
            ]),
        ];
    }

    public function search(): array
    {
        return ['id', 'name', 'description', 'director', 'inn', 'kpp', 'ogrn', 'phone', 'email'];
    }

    public function rules(Model $item): array
    {
        return [];
    }

    public function buttons(): array
    {
        return [
            ActionButton::make(
                'Сформировать договор',
                fn($item) => '/document-company/generate/' . $item->id,
            )
                ->canSee(fn($item) => !$this->hasDocument($item)),

            ActionButton::make(
                'Открыть договор',
                fn($item) => '/document-company/view/' . $item->id,
            )
                ->canSee(fn($item) => $this->hasDocument($item))
                ->blank(),
        ];
    }

    private function hasDocument($company)
    {
        $filePath = "documents/companies/{$company->id}.docx";

        return Storage::disk('public')->exists($filePath);
    }
}
