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

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Naam</th>
                        <th>Omschrijving</th>
                        <th>Aantal Lessen</th>
                        <th>Prijs</th>
                        <th>Actie</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($lespakketten as $pakket)
                    <tr>
                        <td>{{ $pakket->Naam }}</td>
                        <td>{{ $pakket->Omschrijving }}</td>
                        <td>{{ $pakket->AantalLessen }}</td>
                        <td>€ {{ number_format($pakket->Prijs, 2, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('facaturen.create', $pakket->LespakketId) }}"
                               class="btn btn-primary">
                                Betaal
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            Geen lespakketten gevonden.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

        </div>

    </flux:main>

</x-layouts::app.sidebar>