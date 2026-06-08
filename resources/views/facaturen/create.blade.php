@extends('layouts.app')

@section('content')

<div class="container">

```
<h1>{{ $title }}</h1>

<div class="card mb-4">
    <div class="card-body">

        <h3>{{ $lespakket->Naam }}</h3>

        <p>
            <strong>Omschrijving:</strong>
            {{ $lespakket->Omschrijving }}
        </p>

        <p>
            <strong>Aantal lessen:</strong>
            {{ $lespakket->AantalLessen }}
        </p>

        <p>
            <strong>Prijs:</strong>
            € {{ number_format($lespakket->Prijs, 2, ',', '.') }}
        </p>

    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('facaturen.store') }}"
      method="POST">

    @csrf

    <input type="hidden"
           name="lespakket_id"
           value="{{ $lespakket->LespakketId }}">

    <div class="mb-3">
        <label class="form-label">
            Naam kaarthouder
        </label>

        <input type="text"
               name="kaarthouder"
               class="form-control"
               value="{{ old('kaarthouder') }}"
               required>
    </div>

    <div class="mb-3">
        <label class="form-label">
            Creditcardnummer
        </label>

        <input type="text"
               name="kaartnummer"
               class="form-control"
               placeholder="1234 5678 9012 3456"
               value="{{ old('kaartnummer') }}"
               required>
    </div>

    <div class="row">

        <div class="col-md-6 mb-3">
            <label class="form-label">
                Vervaldatum
            </label>

            <input type="text"
                   name="vervaldatum"
                   class="form-control"
                   placeholder="MM/JJ"
                   value="{{ old('vervaldatum') }}"
                   required>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">
                CVV
            </label>

            <input type="password"
                   name="cvv"
                   class="form-control"
                   maxlength="4"
                   required>
        </div>

    </div>

    <a href="{{ route('facaturen.index') }}"
       class="btn btn-secondary">
        Terug
    </a>

    <button type="submit"
            class="btn btn-success">
        Betaling uitvoeren
    </button>

</form>
```

</div>

@endsection
