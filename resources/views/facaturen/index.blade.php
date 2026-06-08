<x-layouts::app.sidebar :title="$title ?? null">

    <flux:main>

        <div class="container">
            <h1>{{ $title }}</h1>
            

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
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
                                    Betaal
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