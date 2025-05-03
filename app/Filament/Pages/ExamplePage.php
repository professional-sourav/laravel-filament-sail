<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Support\Enums\MaxWidth;

class ExamplePage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.example-page';

    protected static ?string $title = 'My Example Page';

    public $defaultAction = 'onboarding';

    public static function canAccess(): bool
    {
        return auth()->user()->canManageExamplePage();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Create')
                ->label('Create Example')
                ->url(static::getUrl(['action' => 'create']))
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->requiresConfirmation()
                ->action(fn () => $this->notify('success', 'Example created successfully!')),
        ];
    }

    public function onboardingAction(): Action
    {
        return Action::make('onboarding')
            ->modalHeading('Welcome')
            ->visible(fn (): bool => true);
    }

    public function getMaxContentWidth(): MaxWidth
    {
        return MaxWidth::Full;
    }
}
