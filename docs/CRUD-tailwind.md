# Laravel CRUD Handleiding (AI-proof, stap voor stap)

Doel van dit document:
- Je kunt dit bestand samen met een opdracht aan een AI geven.
- De AI moet hiermee een complete, nette en werkende CRUD bouwen in Laravel.
- Deze handleiding gebruikt testdata, niet de voorbeelddata van school.

## 1. Scope en uitgangspunten

We bouwen een simpele CRUD voor de entiteit Product.

Velden:
- id (primary key)
- naam (string, max 100)
- beschrijving (string, max 255)
- prijs (decimal 10,2)
- is_actief (boolean) moet altijd aanwezig zijn
- opmerkingen (string, max 255) moet altijd aanwezig zijn, maar mag null zijn
- created_at (datetime(6)) moet altijd aanwezig zijn
- updated_at (datetime(6)) moet altijd aanwezig zijn

Tech:
- Laravel, huidige versie van het project
- Blade views
- MySQL
- Tailwind via de bestaande Flux/starter shell
- Routes in routes/web.php

## 2. Wat de AI precies moet opleveren

De AI moet minimaal deze onderdelen maken of aanpassen:
- app/Http/Controllers/ProductController.php
- app/Models/Product.php
- resources/views/producten/index.blade.php
- resources/views/producten/create.blade.php
- resources/views/producten/edit.blade.php
- resources/views/layouts/app/sidebar.blade.php
- resources/views/dashboard.blade.php
- routes/web.php
- resources/css/app.css alleen als er extra Tailwind-stijlen nodig zijn
- resources/js/app.js alleen als er extra JavaScript nodig is
- database/createscripts/01_create_database_and_tables.sql
- database/createscripts/02_seed_testdata.sql
- database/createscripts/sp_GetAllProducten.sql
- database/createscripts/sp_CreateProduct.sql
- database/createscripts/sp_DeleteProduct.sql
- database/createscripts/sp_GetProductById.sql
- database/createscripts/sp_UpdateProduct.sql

Daarnaast:
- Correcte validatie in store() en update()
- Succes- en foutmeldingen in index view
- Redirects na create, update en delete
- Werkende link naar Producten in de sidebar

## 3. Basis van elke pagina

Gebruik voor iedere pagina die onder de ingelogde shell valt deze basis:

```blade
<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

    </div>
</x-layouts::app>
```

Regels:
- Dit is de basis van elke pagina in de app-shell.
- Bouw dus geen losse html-, head- of body-tags in de CRUD-views.
- Zet de pagina-inhoud altijd binnen de innerlijke `div`.
- Gebruik Tailwind-klassen voor layout, spacing, knoppen, kaarten en tabellen.

## 4. Sidebar links toevoegen

De sidebar van de app is de navigatiebasis. Voeg daar minimaal deze links toe:

```blade
<flux:sidebar.group :heading="__('Platform')" class="grid">
    <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
        {{ __('Dashboard') }}
    </flux:sidebar.item>

    <flux:sidebar.item icon="package" :href="route('producten.index')" :current="request()->routeIs('producten.*')" wire:navigate>
        {{ __('Producten') }}
    </flux:sidebar.item>

    <flux:sidebar.item icon="plus" :href="route('producten.create')" :current="request()->routeIs('producten.create')" wire:navigate>
        {{ __('Nieuw product') }}
    </flux:sidebar.item>
</flux:sidebar.group>
```

Belangrijk:
- Gebruik `wire:navigate` waar de bestaande shell dat ook gebruikt.
- Gebruik `:current` zodat de actieve pagina zichtbaar blijft.
- Als de route nog niet bestaat, maak die eerst aan in routes/web.php.

## 5. Setup en starten

1. Open project in VS Code.
2. Open terminal met Ctrl + `.
3. Start app met:

```bash
composer run dev
```

4. Gebruik de bestaande Tailwind/Flux-opzet van het project.
5. Installeer geen Bootstrap.
6. Laat de bestaande `@vite`-setup via `partials/head.blade.php` gewoon staan.

## 6. Database scripts (testdata)

Maak map database/createscripts als die nog niet bestaat.

### 6.1 Bestand: 01_create_database_and_tables.sql

```sql
DROP DATABASE IF EXISTS `mvc_test_crud`;
CREATE DATABASE IF NOT EXISTS `mvc_test_crud`;
USE `mvc_test_crud`;

DROP TABLE IF EXISTS Product;

CREATE TABLE IF NOT EXISTS Product (
	Id TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
	Naam VARCHAR(100) NOT NULL,
	Beschrijving VARCHAR(255) NOT NULL,
	Prijs DECIMAL(10,2) NOT NULL,
	IsActief BIT NOT NULL DEFAULT 1,
	DatumAangemaakt DATETIME(6) NOT NULL,
	DatumGewijzigd DATETIME(6) NOT NULL,
	CONSTRAINT PK_Product_Id PRIMARY KEY (Id)
) ENGINE=InnoDB;
```

### 6.2 Bestand: 02_seed_testdata.sql

```sql
USE `mvc_test_crud`;

INSERT INTO Product
(
	Naam,
	Beschrijving,
	Prijs,
	IsActief,
	DatumAangemaakt,
	DatumGewijzigd
)
VALUES
	('Test Product A', 'Eerste testproduct', 9.95, 1, SYSDATE(6), SYSDATE(6)),
	('Test Product B', 'Tweede testproduct', 19.50, 1, SYSDATE(6), SYSDATE(6)),
	('Test Product C', 'Derde testproduct', 5.00, 1, SYSDATE(6), SYSDATE(6));
```

### 6.3 Stored procedure: sp_GetAllProducten.sql

```sql
DROP PROCEDURE IF EXISTS sp_GetAllProducten;

DELIMITER $$

CREATE PROCEDURE sp_GetAllProducten()
BEGIN
	SELECT
		P.Id,
		P.Naam,
		P.Beschrijving,
		P.Prijs,
		P.IsActief
	FROM Product AS P
	ORDER BY P.Id ASC;
END$$

DELIMITER ;
```

### 6.4 Stored procedure: sp_CreateProduct.sql

```sql
DROP PROCEDURE IF EXISTS sp_CreateProduct;

DELIMITER $$

CREATE PROCEDURE sp_CreateProduct(
	IN p_naam VARCHAR(100),
	IN p_beschrijving VARCHAR(255),
	IN p_prijs DECIMAL(10,2)
)
BEGIN
	INSERT INTO Product (
		Naam,
		Beschrijving,
		Prijs,
		IsActief,
		DatumAangemaakt,
		DatumGewijzigd
	)
	VALUES (
		p_naam,
		p_beschrijving,
		p_prijs,
		1,
		SYSDATE(6),
		SYSDATE(6)
	);

	SELECT LAST_INSERT_ID() AS new_id;
END$$

DELIMITER ;
```

### 6.5 Stored procedure: sp_DeleteProduct.sql

```sql
DROP PROCEDURE IF EXISTS sp_DeleteProduct;

DELIMITER $$

CREATE PROCEDURE sp_DeleteProduct(
	IN p_id INT
)
BEGIN
	DELETE FROM Product
	WHERE Id = p_id;

	SELECT ROW_COUNT() AS affected;
END$$

DELIMITER ;
```

### 6.6 Stored procedure: sp_GetProductById.sql

```sql
DROP PROCEDURE IF EXISTS sp_GetProductById;

DELIMITER $$

CREATE PROCEDURE sp_GetProductById(
	IN p_id INT
)
BEGIN
	SELECT
		P.Id,
		P.Naam,
		P.Beschrijving,
		P.Prijs,
		P.IsActief
	FROM Product AS P
	WHERE P.Id = p_id;
END$$

DELIMITER ;
```

### 6.7 Stored procedure: sp_UpdateProduct.sql

```sql
DROP PROCEDURE IF EXISTS sp_UpdateProduct;

DELIMITER $$

CREATE PROCEDURE sp_UpdateProduct(
	IN p_id INT,
	IN p_naam VARCHAR(100),
	IN p_beschrijving VARCHAR(255),
	IN p_prijs DECIMAL(10,2)
)
BEGIN
	UPDATE Product
	SET
		Naam = p_naam,
		Beschrijving = p_beschrijving,
		Prijs = p_prijs,
		DatumGewijzigd = SYSDATE(6)
	WHERE Id = p_id;

	SELECT ROW_COUNT() AS affected;
END$$

DELIMITER ;
```

Voer deze scripts uit in MySQL Workbench in deze volgorde:
1. 01_create_database_and_tables.sql
2. 02_seed_testdata.sql
3. Alle sp_*.sql bestanden

## 7. Laravel controller en model genereren

Gebruik artisan:

```bash
php artisan make:controller ProductController --resource --model=Product
```

Controleer dat deze bestanden bestaan:
- app/Http/Controllers/ProductController.php
- app/Models/Product.php

## 8. Routes toevoegen

Voeg in routes/web.php de volgende routes toe:

```php
use App\Http\Controllers\ProductController;

Route::get('/producten', [ProductController::class, 'index'])->name('producten.index');
Route::get('/producten/create', [ProductController::class, 'create'])->name('producten.create');
Route::post('/producten', [ProductController::class, 'store'])->name('producten.store');
Route::get('/producten/{id}/edit', [ProductController::class, 'edit'])->name('producten.edit');
Route::put('/producten/{id}', [ProductController::class, 'update'])->name('producten.update');
Route::delete('/producten/{id}', [ProductController::class, 'destroy'])->name('producten.destroy');
```

Zorg ook dat de sidebar naar Producten verwijst, zodat de gebruiker overal snel naar de CRUD kan.

## 9. Model implementatie (stored procedures)

Plaats in app/Models/Product.php:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
	public function sp_GetAllProducten()
	{
		return DB::select('CALL sp_GetAllProducten()');
	}

	public function sp_CreateProduct($naam, $beschrijving, $prijs)
	{
		$row = DB::selectOne(
			'CALL sp_CreateProduct(:naam, :beschrijving, :prijs)',
			[
				'naam' => $naam,
				'beschrijving' => $beschrijving,
				'prijs' => $prijs,
			]
		);

		return $row->new_id;
	}

	public function sp_DeleteProduct($id)
	{
		$row = DB::selectOne('CALL sp_DeleteProduct(:id)', ['id' => $id]);

		return $row->affected;
	}

	public function sp_GetProductById($id)
	{
		return DB::selectOne('CALL sp_GetProductById(:id)', ['id' => $id]);
	}

	public function sp_UpdateProduct($id, $naam, $beschrijving, $prijs)
	{
		$row = DB::selectOne(
			'CALL sp_UpdateProduct(:id, :naam, :beschrijving, :prijs)',
			[
				'id' => $id,
				'naam' => $naam,
				'beschrijving' => $beschrijving,
				'prijs' => $prijs,
			]
		);

		return $row->affected ?? 0;
	}
}
```

## 10. Controller implementatie

Plaats in app/Http/Controllers/ProductController.php:

```php
<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
	private $productModel;

	public function __construct()
	{
		$this->productModel = new Product();
	}

	public function index()
	{
		$producten = $this->productModel->sp_GetAllProducten();

		return view('producten.index', [
			'title' => 'Producten',
			'producten' => $producten,
		]);
	}

	public function create()
	{
		return view('producten.create', [
			'title' => 'Nieuw product toevoegen',
		]);
	}

	public function store(Request $request)
	{
		$data = $request->validate([
			'naam' => 'required|string|max:100',
			'beschrijving' => 'required|string|max:255',
			'prijs' => 'required|numeric|min:0',
		]);

		$newId = $this->productModel->sp_CreateProduct(
			$data['naam'],
			$data['beschrijving'],
			$data['prijs']
		);

		return redirect()->route('producten.index')
			->with('success', 'Product succesvol toegevoegd met id ' . $newId);
	}

	public function edit($id)
	{
		$product = $this->productModel->sp_GetProductById($id);
		abort_if(!$product, 404);

		return view('producten.edit', [
			'title' => 'Product wijzigen',
			'product' => $product,
		]);
	}

	public function update(Request $request, $id)
	{
		$data = $request->validate([
			'naam' => 'required|string|max:100',
			'beschrijving' => 'required|string|max:255',
			'prijs' => 'required|numeric|min:0',
		]);

		$result = $this->productModel->sp_UpdateProduct(
			$id,
			$data['naam'],
			$data['beschrijving'],
			$data['prijs']
		);

		if ($result > 0) {
			return redirect()->route('producten.index')
				->with('success', 'Product succesvol gewijzigd');
		}

		return back()->withInput()->with('error', 'Product is niet gewijzigd');
	}

	public function destroy($id)
	{
		$result = $this->productModel->sp_DeleteProduct($id);

		if ($result > 0) {
			return redirect()->route('producten.index')
				->with('success', 'Product succesvol verwijderd');
		}

		return redirect()->route('producten.index')
			->with('error', 'Product is niet verwijderd');
	}
}
```

## 11. Views maken

Maak map resources/views/producten en maak 3 bestanden.

De basis van elke view is de app-shell. Gebruik dus geen losse html-, head- of body-tags.

### 11.1 index.blade.php

```blade
<x-layouts::app :title="$title">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl p-4 sm:p-6 lg:p-8">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight text-zinc-900 dark:text-white">{{ $title }}</h1>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Overzicht van alle testproducten.</p>
            </div>

            <a href="{{ route('producten.create') }}" class="inline-flex items-center justify-center rounded-xl bg-zinc-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-zinc-800 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-200">
                Nieuw product
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
                            <th class="px-4 py-3 text-left text-sm font-medium text-zinc-600 dark:text-zinc-300">Beschrijving</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-zinc-600 dark:text-zinc-300">Prijs</th>
                            <th class="px-4 py-3 text-center text-sm font-medium text-zinc-600 dark:text-zinc-300">Wijzig</th>
                            <th class="px-4 py-3 text-center text-sm font-medium text-zinc-600 dark:text-zinc-300">Verwijder</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        @forelse ($producten as $product)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                <td class="px-4 py-3 text-sm text-zinc-900 dark:text-zinc-100">{{ $product->Naam }}</td>
                                <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-300">{{ $product->Beschrijving }}</td>
                                <td class="px-4 py-3 text-sm font-medium text-zinc-900 dark:text-zinc-100">EUR {{ number_format($product->Prijs, 2, ',', '.') }}</td>
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('producten.edit', $product->Id) }}" class="inline-flex items-center rounded-lg bg-emerald-600 px-3 py-1.5 text-sm font-medium text-white transition hover:bg-emerald-500">
                                        Wijzig
                                    </a>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <form action="{{ route('producten.destroy', $product->Id) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je dit product wilt verwijderen?');">
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
                                <td colspan="5" class="px-4 py-8 text-center text-sm text-zinc-500 dark:text-zinc-400">Geen producten beschikbaar</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts::app>
```

### 11.2 create.blade.php

```blade
<x-layouts::app :title="$title">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl p-4 sm:p-6 lg:p-8">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-zinc-900 dark:text-white">{{ $title }}</h1>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Voeg een nieuw testproduct toe.</p>
        </div>

        @if ($errors->any())
            <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800 dark:border-rose-900/60 dark:bg-rose-950/40 dark:text-rose-200">
                <ul class="list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('producten.store') }}" class="max-w-2xl rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            @csrf

            <div class="space-y-5">
                <div>
                    <label for="naam" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Naam</label>
                    <input type="text" id="naam" name="naam" value="{{ old('naam') }}" required class="block w-full rounded-xl border-zinc-300 bg-white px-4 py-2.5 text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100">
                </div>

                <div>
                    <label for="beschrijving" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Beschrijving</label>
                    <input type="text" id="beschrijving" name="beschrijving" value="{{ old('beschrijving') }}" required class="block w-full rounded-xl border-zinc-300 bg-white px-4 py-2.5 text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100">
                </div>

                <div>
                    <label for="prijs" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Prijs</label>
                    <input type="number" step="0.01" min="0" id="prijs" name="prijs" value="{{ old('prijs') }}" required class="block w-full rounded-xl border-zinc-300 bg-white px-4 py-2.5 text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100">
                </div>
            </div>

            <div class="mt-6 flex flex-wrap gap-3">
                <button type="submit" class="inline-flex items-center rounded-xl bg-zinc-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-zinc-800 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-200">
                    Opslaan
                </button>
                <a href="{{ route('producten.index') }}" class="inline-flex items-center rounded-xl border border-zinc-300 px-4 py-2 text-sm font-medium text-zinc-700 transition hover:bg-zinc-100 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800">
                    Annuleren
                </a>
            </div>
        </form>
    </div>
</x-layouts::app>
```

### 11.3 edit.blade.php

```blade
<x-layouts::app :title="$title">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl p-4 sm:p-6 lg:p-8">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-zinc-900 dark:text-white">{{ $title }}</h1>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Wijzig het geselecteerde testproduct.</p>
        </div>

        @if ($errors->any())
            <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800 dark:border-rose-900/60 dark:bg-rose-950/40 dark:text-rose-200">
                <ul class="list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('producten.update', $product->Id) }}" class="max-w-2xl rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            @csrf
            @method('PUT')

            <div class="space-y-5">
                <div>
                    <label for="naam" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Naam</label>
                    <input type="text" id="naam" name="naam" value="{{ old('naam', $product->Naam) }}" required class="block w-full rounded-xl border-zinc-300 bg-white px-4 py-2.5 text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100">
                </div>

                <div>
                    <label for="beschrijving" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Beschrijving</label>
                    <input type="text" id="beschrijving" name="beschrijving" value="{{ old('beschrijving', $product->Beschrijving) }}" required class="block w-full rounded-xl border-zinc-300 bg-white px-4 py-2.5 text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100">
                </div>

                <div>
                    <label for="prijs" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Prijs</label>
                    <input type="number" step="0.01" min="0" id="prijs" name="prijs" value="{{ old('prijs', $product->Prijs) }}" required class="block w-full rounded-xl border-zinc-300 bg-white px-4 py-2.5 text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100">
                </div>
            </div>

            <div class="mt-6 flex flex-wrap gap-3">
                <button type="submit" class="inline-flex items-center rounded-xl bg-zinc-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-zinc-800 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-200">
                    Opslaan
                </button>
                <a href="{{ route('producten.index') }}" class="inline-flex items-center rounded-xl border border-zinc-300 px-4 py-2 text-sm font-medium text-zinc-700 transition hover:bg-zinc-100 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800">
                    Annuleren
                </a>
            </div>
        </form>
    </div>
</x-layouts::app>
```

## 12. Prompt-template die je aan AI kunt geven

Kopieer dit blok en vul alleen project-specifieke details in:

```text
Bouw een volledige Laravel CRUD voor entiteit Product met Blade, Tailwind en MySQL stored procedures.

Eisen:
1. Gebruik routes:
   - GET /producten (index)
   - GET /producten/create (create)
   - POST /producten (store)
   - GET /producten/{id}/edit (edit)
   - PUT /producten/{id} (update)
   - DELETE /producten/{id} (destroy)
2. Gebruik modelmethodes die stored procedures aanroepen met named binding.
3. Gebruik validatie in store en update.
4. Gebruik @csrf in alle forms.
5. Gebruik @method('PUT') en @method('DELETE') waar nodig.
6. Bouw views binnen de bestaande app-shell:
   - begin elke pagina met <x-layouts::app>
   - gebruik Tailwind-klassen
   - zet de CRUD-pagina's in resources/views/producten/
7. Voeg in resources/views/layouts/app/sidebar.blade.php minimaal links toe voor Dashboard, Producten en Nieuw product.
8. Toon success/error meldingen in index met Tailwind-styling.
9. Gebruik geen Bootstrap en voeg het ook niet toe via npm.
10. Lever SQL scripts voor:
   - database + tabel
   - seed testdata
   - sp_GetAllProducten
   - sp_CreateProduct
   - sp_DeleteProduct
   - sp_GetProductById
   - sp_UpdateProduct
11. Houd code PSR-12 stijl aan en wijzig alleen noodzakelijke bestanden.

Geef als output:
- Een kort overzicht van gewijzigde bestanden
- Volledige code per bestand
- Korte teststappen om handmatig te controleren dat CRUD werkt
```

## 13. Handmatige test-checklist

1. Open de app en klik op de sidebar-link Producten.
2. Controleer of de lijst met testdata zichtbaar is.
3. Klik op Nieuw product, vul het formulier in en sla op.
4. Controleer de successmelding en het nieuwe record in de tabel.
5. Klik op Wijzig, pas de velden aan en sla op.
6. Controleer of de wijzigingen zichtbaar zijn.
7. Klik op Verwijder en bevestig de popup.
8. Controleer of het record weg is en de successmelding zichtbaar blijft.

Als alle stappen slagen, is de CRUD correct gebouwd.

## 14. Belangrijke extra's om toe te voegen

1. joins
2. try/catch
3. stored procedures
4. passende naamgeving
5. technische log
6. duidelijke terugkoppeling
7. responsive
