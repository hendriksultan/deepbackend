<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Login as BaseLogin;
use Filament\Forms\Form;
use Afatmustafa\FilamentTurnstile\Forms\Components\Turnstile;

class CustomLogin extends BaseLogin
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),

                // Widget Turnstile (Ditengahkan dengan sempurna)
                Turnstile::make('turnstile')
                    ->hiddenLabel() 
                    ->theme('light')
                    ->extraFieldWrapperAttributes([
                        'class' => 'flex justify-center w-full mt-2'
                    ]),
            ])
            ->statePath('data');
    }
}