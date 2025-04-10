<?php

namespace App\Filament\Patient\Pages;

use App\Models\Glycemie;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\Facades\Auth;

class SaisieGlycemie extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.patient.pages.saisie-glycemie';
    protected static ?string $navigationLabel = 'Saisie glycémie';
    protected static ?string $title = 'Enregistrer une mesure';
    protected static ?string $slug = 'saisie-glycemie';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('valeur')
                    ->label('Valeur (mmol/L)')
                    ->numeric()
                    ->required()
                    ->step(0.1),

                DatePicker::make('date_mesure')
                    ->label('Date de mesure')
                    ->required()
                    ->default(now()),

                TextInput::make('heure_mesure')
                    ->label('Heure de mesure')
                    ->type('time')
                    ->required()
                    ->default(now()->format('H:i')),

                Select::make('moment')
                    ->label('Moment de la mesure')
                    ->options([
                        'matin' => 'Matin',
                        'midi' => 'Avant déjeuner',
                        'soir' => 'Avant dîner',
                        'nuit' => 'Nuit',
                    ])
                    ->required(),

                Textarea::make('commentaire')
                    ->label('Commentaire (facultatif)')
                    ->columnSpanFull(),
            ])
            ->statePath('data')
            ->columns(2);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        Glycemie::create([
            'patient_id' => Auth::id(),
            'valeur' => $data['valeur'],
            'date_mesure' => $data['date_mesure'],
            'heure_mesure' => $data['heure_mesure'],
            'moment' => $data['moment'],
            'commentaire' => $data['commentaire'] ?? null,
        ]);

        $this->form->fill();
        $this->notify('success', 'Mesure enregistrée avec succès!');
    }
}
