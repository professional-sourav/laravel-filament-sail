<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class ExamplePage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.example-page';

    protected static ?string $title = 'My Example Page';

    public static function canAccess(): bool
    {
        return auth()->user()->canManageExamplePage();
    }
}
