<x-layouts::app :title="$title">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl p-4 sm:p-6 lg:p-8">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-zinc-900 dark:text-white">{{ $title }}</h1>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Voeg een nieuwe testleerling toe met instructeur en lespakket.</p>
        </div>

        @if ($errors->any())
            <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800 dark:border-rose-900/60 dark:bg-rose-950/40 dark:text-rose-200">
                <ul class="list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('leerlingen.store') }}" class="max-w-4xl rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            @csrf

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label for="voornaam" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Voornaam</label>
                    <input type="text" id="voornaam" name="voornaam" value="{{ old('voornaam') }}" required class="block w-full rounded-xl border-zinc-300 bg-white px-4 py-2.5 text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100">
                </div>

                <div>
                    <label for="achternaam" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Achternaam</label>
                    <input type="text" id="achternaam" name="achternaam" value="{{ old('achternaam') }}" required class="block w-full rounded-xl border-zinc-300 bg-white px-4 py-2.5 text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100">
                </div>

                <div>
                    <label for="geboortedatum" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Geboortedatum</label>
                    <input type="date" id="geboortedatum" name="geboortedatum" value="{{ old('geboortedatum') }}" required class="block w-full rounded-xl border-zinc-300 bg-white px-4 py-2.5 text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100">
                </div>

                <div>
                    <label for="telefoon" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Telefoon</label>
                    <input type="text" id="telefoon" name="telefoon" value="{{ old('telefoon') }}" required class="block w-full rounded-xl border-zinc-300 bg-white px-4 py-2.5 text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100">
                </div>

                <div>
                    <label for="email" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">E-mail</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required class="block w-full rounded-xl border-zinc-300 bg-white px-4 py-2.5 text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100">
                </div>

                <div>
                    <label for="adres" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Adres</label>
                    <input type="text" id="adres" name="adres" value="{{ old('adres') }}" required class="block w-full rounded-xl border-zinc-300 bg-white px-4 py-2.5 text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100">
                </div>

                <div>
                    <label for="postcode" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Postcode</label>
                    <input type="text" id="postcode" name="postcode" value="{{ old('postcode') }}" required class="block w-full rounded-xl border-zinc-300 bg-white px-4 py-2.5 text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100">
                </div>

                <div>
                    <label for="woonplaats" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Woonplaats</label>
                    <input type="text" id="woonplaats" name="woonplaats" value="{{ old('woonplaats') }}" required class="block w-full rounded-xl border-zinc-300 bg-white px-4 py-2.5 text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100">
                </div>

                <div>
                    <label for="instructeur_id" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Instructeur</label>
                    <select id="instructeur_id" name="instructeur_id" required class="block w-full rounded-xl border-zinc-300 bg-white px-4 py-2.5 text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100">
                        <option value="">Kies een instructeur</option>
                        @foreach ($instructeurs as $instructeur)
                            <option value="{{ $instructeur->InstructeurId }}" @selected((string) old('instructeur_id') === (string) $instructeur->InstructeurId)>
                                {{ $instructeur->VolledigeNaam }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="lespakket_id" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Lespakket</label>
                    <select id="lespakket_id" name="lespakket_id" required class="block w-full rounded-xl border-zinc-300 bg-white px-4 py-2.5 text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100">
                        <option value="">Kies een lespakket</option>
                        @foreach ($lespakketten as $lespakket)
                            <option value="{{ $lespakket->LespakketId }}" @selected((string) old('lespakket_id') === (string) $lespakket->LespakketId)>
                                {{ $lespakket->Naam }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="les_tegoed" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Les tegoed</label>
                    <input type="number" min="0" step="1" id="les_tegoed" name="les_tegoed" value="{{ old('les_tegoed', 0) }}" required class="block w-full rounded-xl border-zinc-300 bg-white px-4 py-2.5 text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100">
                </div>

                <div class="flex items-center gap-3 rounded-xl border border-zinc-200 px-4 py-3 dark:border-zinc-800">
                    <input type="hidden" name="is_actief" value="0">
                    <input type="checkbox" id="is_actief" name="is_actief" value="1" @checked((string) old('is_actief', '1') === '1') class="h-4 w-4 rounded border-zinc-300 text-zinc-900 focus:ring-zinc-900">
                    <label for="is_actief" class="text-sm font-medium text-zinc-700 dark:text-zinc-200">Actief</label>
                </div>

                <div class="md:col-span-2">
                    <label for="opmerking" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Opmerking</label>
                    <textarea id="opmerking" name="opmerking" rows="4" maxlength="255" class="block w-full rounded-xl border-zinc-300 bg-white px-4 py-2.5 text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100">{{ old('opmerking') }}</textarea>
                </div>
            </div>

            <div class="mt-6 flex flex-wrap gap-3">
                <button type="submit" class="inline-flex items-center rounded-xl bg-zinc-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-zinc-800 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-200">
                    Opslaan
                </button>
                <a href="{{ route('leerlingen.index') }}" class="inline-flex items-center rounded-xl border border-zinc-300 px-4 py-2 text-sm font-medium text-zinc-700 transition hover:bg-zinc-100 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800" wire:navigate>
                    Annuleren
                </a>
            </div>
        </form>
    </div>
</x-layouts::app>
