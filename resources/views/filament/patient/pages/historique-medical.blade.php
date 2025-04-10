<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Période de filtrage --}}
        <div class="flex justify-end">
            <div class="w-40">
                <x-filament::input.wrapper>
                    <x-filament::input.select wire:model.live="selectedPeriod">
                        <option value="7">7 derniers jours</option>
                        <option value="30">30 derniers jours</option>
                        <option value="90">3 derniers mois</option>
                        <option value="365">1 année</option>
                    </x-filament::input.select>
                </x-filament::input.wrapper>
            </div>
        </div>

        {{-- Statistiques --}}
        <x-filament-widgets::widgets
            :columns="3"
            :data="$this->getWidgetData()"
            :widgets="$this->getWidgets()"
        />

        {{-- Tableau des dernières mesures --}}
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Dernières mesures de glycémie</h3>
            <x-filament-tables::table>
    <x-slot name="header">
        <x-filament-tables::header-cell>
            Date
        </x-filament-tables::header-cell>
        <x-filament-tables::header-cell>
            Heure
        </x-filament-tables::header-cell>
        <x-filament-tables::header-cell>
            Valeur
        </x-filament-tables::header-cell>
        <x-filament-tables::header-cell>
            Moment
        </x-filament-tables::header-cell>
    </x-slot>

    @foreach($glycemies as $glycemie)
        <x-filament-tables::row>
            <x-filament-tables::cell>
                {{ $glycemie->date_mesure->format('d/m/Y') }}
            </x-filament-tables::cell>
            <x-filament-tables::cell>
                {{ $glycemie->heure_mesure }}
            </x-filament-tables::cell>
            <x-filament-tables::cell>
                {{ $glycemie->valeur }} mmol/L
            </x-filament-tables::cell>
            <x-filament-tables::cell>
                {{ ucfirst($glycemie->moment) }}
            </x-filament-tables::cell>
        </x-filament-tables::row>
    @endforeach
</x-filament-tables::table>
        </div>
    </div>
</x-filament-panels::page>
