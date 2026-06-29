<x-layouts::app.sidebar :title="$title ?? null">
    <flux:main>
        <div class="max-w-6xl mx-auto">
            <h1 class="text-2xl font-bold mb-6">{{ $title }}</h1>
            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            <table class="min-w-full border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-4 py-2">Kaarthouder</th>
                        <th class="border px-4 py-2">Kaartnummer</th>
                        <th class="border px-4 py-2">Vervaldatum</th>
                        <th class="border px-4 py-2">Actief</th>
                        <th class="border px-4 py-2">Acties</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($facaturen as $factuur)
                        <tr>
                            <td class="border px-4 py-2">{{ $factuur->Kaarthouder }}</td>
                            <td class="border px-4 py-2">{{ $factuur->Kaartnummer }}</td>
                            <td class="border px-4 py-2">{{ $factuur->Vervaldatum }}</td>
                            <td class="border px-4 py-2">
                                @if($factuur->IsActief == 1)
                                    <span class="text-green-600">Actief</span>
                                @else
                                    <span class="text-red-600">Inactief</span>
                                @endif
                            </td>
                            <td class="border px-4 py-2 flex gap-2">
                                <a href="{{ route('facaturen.edit', $factuur->FacatuurId) }}"
                                    class="bg-blue-500 text-white px-3 py-1 rounded">
                                    Bewerken
                                </a>
                                <form method="POST" action="{{ route('facaturen.destroy', $factuur->FacatuurId) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">
                                        Verwijderen
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-2">
                                Geen facturen gevonden.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </flux:main>
</x-layouts::app.sidebar>