<x-layouts::app.sidebar :title="$title ?? null">
    <flux:main>
        <div class="max-w-xl mx-auto">
            <h1 class="text-2xl font-bold mb-6">Factuur aanpassen</h1>
            <form method="POST" action="{{ route('facaturen.update', $factuur->FacatuurId) }}">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label>Kaarthouder</label>
                    <input type="text" name="kaarthouder" value="{{ $factuur->Kaarthouder }}"
                        class="border w-full p-2 rounded" required>
                </div>
                <div class="mb-4">
                    <label>Kaartnummer</label>
                    <input type="text" name="kaartnummer" value="{{ $factuur->Kaartnummer }}" maxlength="18"
                        class="border w-full p-2 rounded" required>
                </div>
                <div class="mb-4">
                    <label>Vervaldatum</label>
                    <input type="month" name="vervaldatum" value="{{ substr($factuur->Vervaldatum, 0, 7) }}"
                        min="{{ now()->format('Y-m') }}" class="border w-full p-2 rounded" required>
                </div>
                <div class="mb-4">
                    <label>CVV</label>
                    <input type="text" name="cvv" value="{{ $factuur->CVV }}" maxlength="4"
                        class="border w-full p-2 rounded" required>
                </div>
                <div class="mb-4">
                    <label>Status</label>
                    <select name="isactief" class="border w-full p-2 rounded">
                        <option value="1" @if($factuur->IsActief == 1) selected @endif>Actief</option>
                        <option value="0" @if($factuur->IsActief == 0) selected @endif>Inactief</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label>Opmerking</label>
                    <textarea name="opmerking" class="border w-full p-2 rounded">{{ $factuur->Opmerking }}</textarea>
                </div>
                <button class="bg-blue-600 text-white px-4 py-2 rounded">
                    Opslaan
                </button>
            </form>
        </div>
    </flux:main>
</x-layouts::app.sidebar>