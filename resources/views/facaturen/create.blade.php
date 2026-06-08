<x-layouts::app.sidebar :title="$title ?? null">

    <flux:main>

        <div class="max-w-4xl mx-auto">

            <h1 class="text-2xl font-bold mb-6">
                {{ $title }}
            </h1>

            <div class="bg-white border rounded p-6 mb-6">
                <h3 class="text-xl font-semibold mb-4">
                    {{ $lespakket->Naam }}
                </h3>

                <p><strong>Omschrijving:</strong> {{ $lespakket->Omschrijving }}</p>
                <p><strong>Aantal lessen:</strong> {{ $lespakket->AantalLessen }}</p>
                <p><strong>Prijs:</strong> € {{ number_format($lespakket->Prijs, 2, ',', '.') }}</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-4 rounded mb-6">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('facaturen.store') }}" method="POST">
                @csrf

                <input type="hidden"
                       name="lespakket_id"
                       value="{{ $lespakket->LespakketId }}">

                {{-- KAARTHOUDER --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">Naam kaarthouder</label>

                    <input type="text"
                           name="kaarthouder"
                           class="w-full border rounded px-3 py-2"
                           required>
                </div>

                {{-- KAARTNUMMER (exact 18 cijfers) --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">Kaartnummer (18 cijfers) aan elkaar</label>

                    <input type="text"
                           name="kaartnummer"
                           class="w-full border rounded px-3 py-2"
                           {{-- inputmode="numeric" --}}
                           maxlength="18"
                           {{-- pattern="\d{18}" --}}
                           title="Kaartnummer moet exact 18 cijfers zijn"
                           required>
                </div>

                {{-- VERVALDATUM (echte date input) --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">Vervaldatum</label>

                    <input type="month"
                           name="vervaldatum"
                           class="w-full border rounded px-3 py-2"
                           min="{{ now()->addMonth()->format('Y-m') }}"
                           required>
                </div>

                {{-- CVV (3 of 4 cijfers) --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">CVV</label>

                    <input type="text"
                           name="cvv"
                           class="w-full border rounded px-3 py-2"
                           inputmode="numeric"
                           maxlength="4"
                           pattern="\d{3,4}"
                           title="CVV moet 3 of 4 cijfers zijn"
                           required>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('facaturen.index') }}"
                       class="px-4 py-2 bg-gray-500 text-white rounded">
                        Terug
                    </a>

                    <button type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded">
                        Betalen
                    </button>
                </div>

            </form>

        </div>

    </flux:main>

</x-layouts::app.sidebar>