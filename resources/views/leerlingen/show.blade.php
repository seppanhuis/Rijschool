<x-layouts::app :title="$title">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl p-4 sm:p-6 lg:p-8">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight text-zinc-900 dark:text-white">{{ $title }}</h1>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Volledige detailweergave van de geselecteerde leerling.</p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('leerlingen.edit', $leerling->LeerlingId) }}" class="inline-flex items-center justify-center rounded-xl bg-zinc-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-zinc-800 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-200" wire:navigate>
                    Wijzig leerling
                </a>
                <a href="{{ route('leerlingen.index') }}" class="inline-flex items-center justify-center rounded-xl border border-zinc-300 px-4 py-2 text-sm font-medium text-zinc-700 transition hover:bg-zinc-100 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800" wire:navigate>
                    Terug naar overzicht
                </a>
            </div>
        </div>

        <div class="grid gap-4 lg:grid-cols-3">
            <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900 lg:col-span-2">
                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Naam</p>
                        <p class="mt-1 text-lg font-semibold text-zinc-900 dark:text-white">{{ $leerling->Voornaam }} {{ $leerling->Achternaam }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">E-mail</p>
                        <p class="mt-1 text-lg font-semibold text-zinc-900 dark:text-white">{{ $leerling->Email }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Telefoon</p>
                        <p class="mt-1 text-lg font-semibold text-zinc-900 dark:text-white">{{ $leerling->Telefoon }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Geboortedatum</p>
                        <p class="mt-1 text-lg font-semibold text-zinc-900 dark:text-white">{{ \Illuminate\Support\Carbon::parse($leerling->Geboortedatum)->format('d-m-Y') }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Adres</p>
                        <p class="mt-1 text-lg font-semibold text-zinc-900 dark:text-white">{{ $leerling->Adres }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Postcode en woonplaats</p>
                        <p class="mt-1 text-lg font-semibold text-zinc-900 dark:text-white">{{ $leerling->Postcode }} {{ $leerling->Woonplaats }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Instructeur</p>
                        <p class="mt-1 text-lg font-semibold text-zinc-900 dark:text-white">{{ $leerling->InstructeurNaam }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Lespakket</p>
                        <p class="mt-1 text-lg font-semibold text-zinc-900 dark:text-white">{{ $leerling->LespakketNaam }}</p>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                    <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Status</p>
                    <p class="mt-2 text-lg font-semibold text-zinc-900 dark:text-white">{{ (int) $leerling->IsActief === 1 ? 'Actief' : 'Inactief' }}</p>
                </div>

                <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                    <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Les tegoed</p>
                    <p class="mt-2 text-lg font-semibold text-zinc-900 dark:text-white">{{ $leerling->LesTegoed }}</p>
                </div>

                <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                    <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Opmerking</p>
                    <p class="mt-2 text-sm leading-6 text-zinc-600 dark:text-zinc-300">{{ $leerling->Opmerking ?? 'Geen opmerking vastgelegd.' }}</p>
                </div>

                <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                    <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Aangemaakt</p>
                    <p class="mt-2 text-sm font-semibold text-zinc-900 dark:text-white">{{ \Illuminate\Support\Carbon::parse($leerling->DatumAangemaakt)->format('d-m-Y H:i') }}</p>
                    <p class="mt-4 text-sm font-medium text-zinc-500 dark:text-zinc-400">Gewijzigd</p>
                    <p class="mt-2 text-sm font-semibold text-zinc-900 dark:text-white">{{ \Illuminate\Support\Carbon::parse($leerling->DatumGewijzigd)->format('d-m-Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>
