<x-layouts::app :title="$title">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl p-4 sm:p-6 lg:p-8">
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
                                    <form action="{{ route('leerlingen.destroy', $leerling->LeerlingId) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je deze leerling wilt verwijderen?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center rounded-lg bg-rose-600 px-3 py-1.5 text-sm font-medium text-white transition hover:bg-rose-500">
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
    </div>
</x-layouts::app>
