<x-layouts::app :title="$title">
    <div
        x-data="{
            showDeleteModal: @js((bool) session('delete_error')),
            deleteAction: '',
            deleteName: '',
            deleteError: @js(session('delete_error')),
            openDeleteModal(action, name) {
                this.deleteAction = action;
                this.deleteName = name;
                this.deleteError = null;
                this.showDeleteModal = true;
            },
            closeDeleteModal() {
                this.showDeleteModal = false;
                this.deleteError = null;
            }
        }"
        class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl p-4 sm:p-6 lg:p-8"
    >
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight text-zinc-900 dark:text-white">{{ $title }}</h1>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Overzicht van alle testleerlingen met hun instructeur en lespakket.</p>
            </div>

            <a href="{{ route('leerlingen.create') }}" class="inline-flex items-center justify-center rounded-xl bg-zinc-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-zinc-800 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-200" wire:navigate>
                Nieuwe leerling
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 dark:border-emerald-900/60 dark:bg-emerald-950/40 dark:text-emerald-200">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800 dark:border-rose-900/60 dark:bg-rose-950/40 dark:text-rose-200">
                {{ session('error') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-800">
                    <thead class="bg-zinc-50 dark:bg-zinc-950/40">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-medium text-zinc-600 dark:text-zinc-300">Naam</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-zinc-600 dark:text-zinc-300">Instructeur</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-zinc-600 dark:text-zinc-300">Lespakket</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-zinc-600 dark:text-zinc-300">Tegoed</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-zinc-600 dark:text-zinc-300">Status</th>
                            <th class="px-4 py-3 text-center text-sm font-medium text-zinc-600 dark:text-zinc-300">Detail</th>
                            <th class="px-4 py-3 text-center text-sm font-medium text-zinc-600 dark:text-zinc-300">Wijzig</th>
                            <th class="px-4 py-3 text-center text-sm font-medium text-zinc-600 dark:text-zinc-300">Verwijder</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        @forelse ($leerlingen as $leerling)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                <td class="px-4 py-3 text-sm text-zinc-900 dark:text-zinc-100">
                                    <div class="font-medium">{{ $leerling->Voornaam }} {{ $leerling->Achternaam }}</div>
                                    <div class="text-xs text-zinc-500 dark:text-zinc-400">{{ $leerling->Email }}</div>
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-300">{{ $leerling->InstructeurNaam }}</td>
                                <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-300">{{ $leerling->LespakketNaam }}</td>
                                <td class="px-4 py-3 text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ $leerling->LesTegoed }}</td>
                                <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-300">
                                    <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium {{ (int) $leerling->IsActief === 1 ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-200' : 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300' }}">
                                        {{ (int) $leerling->IsActief === 1 ? 'Actief' : 'Inactief' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('leerlingen.show', $leerling->LeerlingId) }}" class="inline-flex items-center rounded-lg bg-zinc-200 px-3 py-1.5 text-sm font-medium text-zinc-900 transition hover:bg-zinc-300 dark:bg-zinc-800 dark:text-zinc-100 dark:hover:bg-zinc-700" wire:navigate>
                                        Bekijk
                                    </a>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('leerlingen.edit', $leerling->LeerlingId) }}" class="inline-flex items-center rounded-lg bg-emerald-600 px-3 py-1.5 text-sm font-medium text-white transition hover:bg-emerald-500" wire:navigate>
                                        Wijzig
                                    </a>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <form action="{{ route('leerlingen.destroy', $leerling->LeerlingId) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="button"
                                            @click="openDeleteModal(@js(route('leerlingen.destroy', $leerling->LeerlingId)), @js($leerling->Voornaam . ' ' . $leerling->Achternaam))"
                                            class="inline-flex items-center rounded-lg bg-rose-600 px-3 py-1.5 text-sm font-medium text-white transition hover:bg-rose-500"
                                        >
                                            Verwijder
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-8 text-center text-sm text-zinc-500 dark:text-zinc-400">Geen leerlingen beschikbaar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div
            x-cloak
            x-show="showDeleteModal"
            x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center bg-zinc-950/60 px-4 py-6"
            @keydown.escape.window="closeDeleteModal()"
            style="display: none;"
        >
            <div class="w-full max-w-2xl overflow-hidden rounded-3xl border border-zinc-200 bg-white shadow-2xl dark:border-zinc-800 dark:bg-zinc-900">
                <div class="flex items-start justify-between gap-4 border-b border-zinc-200 px-6 py-5 dark:border-zinc-800">
                    <div>
                        <p class="text-sm font-medium uppercase tracking-[0.2em] text-rose-600 dark:text-rose-400">Leerling verwijderen</p>
                        <h2 class="mt-2 text-2xl font-semibold tracking-tight text-zinc-900 dark:text-white" x-text="deleteError ? 'Verwijderen mislukt' : 'Verwijderen bevestigen'"></h2>
                    </div>

                    <button type="button" @click="closeDeleteModal()" class="rounded-full p-2 text-zinc-500 transition hover:bg-zinc-100 hover:text-zinc-900 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-white" aria-label="Sluiten">
                        <span class="text-xl leading-none">&times;</span>
                    </button>
                </div>

                <div class="px-6 py-6">
                    <template x-if="deleteError">
                        <div class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800 dark:border-rose-900/60 dark:bg-rose-950/40 dark:text-rose-200">
                            <div class="font-semibold">Waarom dit niet kan</div>
                            <div class="mt-1" x-text="deleteError"></div>
                        </div>
                    </template>

                    <div class="rounded-2xl bg-zinc-50 p-5 dark:bg-zinc-950/50" x-show="!deleteError">
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">Je staat op het punt om deze leerling te verwijderen:</p>
                        <p class="mt-2 text-2xl font-semibold text-zinc-900 dark:text-white" x-text="deleteName"></p>
                        <p class="mt-3 text-sm leading-6 text-zinc-600 dark:text-zinc-300">
                            Deze actie kan niet ongedaan worden gemaakt. Bij een foutmelding blijft dit venster open zodat je direct ziet wat er misging.
                        </p>
                    </div>

                    <div class="rounded-2xl bg-zinc-50 p-5 dark:bg-zinc-950/50" x-show="deleteError">
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">De leerling die niet verwijderd kon worden:</p>
                        <p class="mt-2 text-2xl font-semibold text-zinc-900 dark:text-white" x-text="deleteName"></p>
                        <p class="mt-3 text-sm leading-6 text-zinc-600 dark:text-zinc-300">
                            Je kunt dit venster alleen sluiten. Als je de oorzaak wilt oplossen, moet je eerst de gekoppelde gegevens aanpassen.
                        </p>
                    </div>

                    <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                        <button type="button" @click="closeDeleteModal()" class="inline-flex items-center justify-center rounded-xl border border-zinc-300 px-5 py-2.5 text-sm font-medium text-zinc-700 transition hover:bg-zinc-100 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800">
                            Annuleren
                        </button>

                        <form method="POST" :action="deleteAction" class="inline" x-show="!deleteError">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-rose-600 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-rose-500">
                                Ja, verwijder leerling
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>
