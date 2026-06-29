<x-layouts::app.sidebar :title="$title ?? null">

    <flux:main>
        <div class="max-w-xl mx-auto">
            <h1 class="text-2xl font-bold mb-6">
                Factuur maken
            </h1>
            <form method="POST" action="{{ route('facaturen.store') }}">
                @csrf
                <div class="mb-4">
                    <label>
                        Lespakket ID
                    </label>
                    <input name="lespakket_id" class="border w-full p-2 rounded" required>
                </div>
                <div class="mb-4">

                    <label>
                        Kaarthouder
                    </label>

                    <input name="kaarthouder" class="border w-full p-2 rounded" required>
                </div>
                <div class="mb-4">

                    <label>
                        Kaartnummer
                    </label>

                    <input name="kaartnummer" maxlength="18" class="border w-full p-2 rounded" required>

                </div>




                <div class="mb-4">

                    <label>
                        Vervaldatum
                    </label>

                    <input type="month" name="vervaldatum" class="border w-full p-2 rounded" required>

                </div>




                <div class="mb-4">

                    <label>
                        CVV
                    </label>

                    <input name="cvv" maxlength="4" class="border w-full p-2 rounded" required>

                </div>



                <div class="mb-4">

                    <label>
                        Opmerking
                    </label>

                    <textarea name="opmerking" class="border w-full p-2 rounded">
</textarea>

                </div>



                <button class="bg-green-600 text-white px-4 py-2 rounded">

                    Opslaan

                </button>



            </form>


        </div>


    </flux:main>

</x-layouts::app.sidebar>