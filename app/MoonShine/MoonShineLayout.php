<?php

declare(strict_types=1);

namespace App\MoonShine;

use MoonShine\Components\Layout\{Content, Flash, Footer, Header, LayoutBlock, LayoutBuilder, Menu, Search, Sidebar};
use MoonShine\Contracts\MoonShineLayoutContract;

final class MoonShineLayout implements MoonShineLayoutContract
{
    public static function build(): LayoutBuilder
    {
        return LayoutBuilder::make([
            Sidebar::make([
                Menu::make()->customAttributes(['class' => 'mt-2']),
            ]),
            LayoutBlock::make([
                Flash::make(),
                Header::make([
                    Search::make(),
                ]),
                Content::make(),
                Footer::make()->copyright(fn (): string => <<<'HTML'
                        &copy; 2023-2024 Made with ❤️ by
                        <a href="https://t.me/youmixx"
                            class="font-semibold text-primary hover:text-secondary"
                            target="_blank"
                        >
                            YouMixx
                        </a>
                    HTML),
            ])->customAttributes(['class' => 'layout-page']),
        ]);
    }
}
