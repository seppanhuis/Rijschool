<x-layouts::app.sidebar :title="$title ?? null">

    <flux:main>

        <div class="max-w-4xl mx-auto">

            <h1 class="text-2xl font-bold mb-6">
                {{ $title }}
            </h1>

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <table class="min-w-full border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-4 py-2 text-left">Naam</th>
                        <th class="border px-4 py-2 text-left">Omschrijving</th>
                        <th class="border px-4 py-2 text-left">Aantal Lessen</th>
                        <th class="border px-4 py-2 text-left">Prijs</th>
                        <th class="border px-4 py-2 text-left">Actie</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($lespakketten as $pakket)
                        <tr class="border-t">
                            <td class="border px-4 py-2">{{ $pakket->Naam }}</td>
                            <td class="border px-4 py-2">{{ $pakket->Omschrijving }}</td>
                            <td class="border px-4 py-2">{{ $pakket->AantalLessen }}</td>
                            <td class="border px-4 py-2">
                                € {{ number_format($pakket->Prijs, 2, ',', '.') }}
                            </td>
                            <td class="border px-4 py-2">
                                <a href="{{ route('facaturen.create', $pakket->LespakketId) }}"
                                    class="px-3 py-1 bg-blue-500 text-white rounded">
                                    koop
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-2">
                                Geen lespakketten gevonden.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

    </flux:main>

</x-layouts::app.sidebar>