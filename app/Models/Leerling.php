<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Leerling extends Model
{
    protected $table = 'Leerlingen';

    protected $primaryKey = 'LeerlingId';

    public $timestamps = false;

    protected $guarded = [];

    // Centrale afhandeling voor SP-selects: bij fouten loggen en veilige fallback geven.
    // Extra context (query + bindings) maakt debuggen in het logbestand veel makkelijker.
    private function safeSelect(string $query, array $bindings = []): array
    {
        try {
            return DB::select($query, $bindings);
        } catch (\Throwable $e) {
            Log::error('Stored procedure select mislukt', [
                'query' => $query,
                'bindings' => $bindings,
                'message' => $e->getMessage(),
            ]);

            report($e);

            return [];
        }
    }

    // Variant voor één record (of null bij fout / geen resultaat).
    private function safeSelectOne(string $query, array $bindings = []): ?object
    {
        try {
            return DB::selectOne($query, $bindings);
        } catch (\Throwable $e) {
            Log::error('Stored procedure selectOne mislukt', [
                'query' => $query,
                'bindings' => $bindings,
                'message' => $e->getMessage(),
            ]);

            report($e);

            return null;
        }
    }

    // Uniforme CRUD logging voor overzicht in storage/logs/laravel.log.
    private function logCrudAction(string $action, array $context = []): void
    {
        Log::info('Leerling CRUD actie', [
            'action' => $action,
            ...$context,
        ]);
    }

    public function sp_GetAllLeerlingen(): array
    {
        // READ: alle leerlingen ophalen.
        $this->logCrudAction('read_all');

        return $this->safeSelect('CALL sp_GetAllLeerlingen()');
    }

    public function sp_GetLeerlingById(int $id): ?object
    {
        // READ: specifieke leerling op basis van ID.
        $this->logCrudAction('read_one', ['leerling_id' => $id]);

        return $this->safeSelectOne('CALL sp_GetLeerlingById(:id)', ['id' => $id]);
    }

    public function sp_CreateLeerling(array $leerlingData): int
    {
        // CREATE: nieuwe leerling aanmaken.
        $this->logCrudAction('create_start', [
            'email' => $leerlingData['email'] ?? null,
            'instructeur_id' => $leerlingData['instructeur_id'] ?? null,
            'lespakket_id' => $leerlingData['lespakket_id'] ?? null,
        ]);

        $row = $this->safeSelectOne(
            'CALL sp_CreateLeerling(:voornaam, :achternaam, :geboortedatum, :telefoon, :email, :adres, :postcode, :woonplaats, :instructeur_id, :lespakket_id, :les_tegoed, :is_actief, :opmerking)',
            [
                'voornaam' => $leerlingData['voornaam'],
                'achternaam' => $leerlingData['achternaam'],
                'geboortedatum' => $leerlingData['geboortedatum'],
                'telefoon' => $leerlingData['telefoon'],
                'email' => $leerlingData['email'],
                'adres' => $leerlingData['adres'],
                'postcode' => $leerlingData['postcode'],
                'woonplaats' => $leerlingData['woonplaats'],
                'instructeur_id' => $leerlingData['instructeur_id'],
                'lespakket_id' => $leerlingData['lespakket_id'],
                'les_tegoed' => $leerlingData['les_tegoed'],
                'is_actief' => $leerlingData['is_actief'] ? 1 : 0,
                'opmerking' => $leerlingData['opmerking'],
            ]
        );

        $newId = (int) ($row->new_id ?? 0);
        $this->logCrudAction('create_done', ['new_id' => $newId]);

        return $newId;
    }

    public function sp_UpdateLeerling(int $id, array $leerlingData): int
    {
        // UPDATE: bestaande leerlinggegevens aanpassen.
        $this->logCrudAction('update_start', ['leerling_id' => $id]);

        $row = $this->safeSelectOne(
            'CALL sp_UpdateLeerling(:id, :voornaam, :achternaam, :geboortedatum, :telefoon, :email, :adres, :postcode, :woonplaats, :instructeur_id, :lespakket_id, :les_tegoed, :is_actief, :opmerking)',
            [
                'id' => $id,
                'voornaam' => $leerlingData['voornaam'],
                'achternaam' => $leerlingData['achternaam'],
                'geboortedatum' => $leerlingData['geboortedatum'],
                'telefoon' => $leerlingData['telefoon'],
                'email' => $leerlingData['email'],
                'adres' => $leerlingData['adres'],
                'postcode' => $leerlingData['postcode'],
                'woonplaats' => $leerlingData['woonplaats'],
                'instructeur_id' => $leerlingData['instructeur_id'],
                'lespakket_id' => $leerlingData['lespakket_id'],
                'les_tegoed' => $leerlingData['les_tegoed'],
                'is_actief' => $leerlingData['is_actief'] ? 1 : 0,
                'opmerking' => $leerlingData['opmerking'],
            ]
        );

        $affected = (int) ($row->affected ?? 0);
        $this->logCrudAction('update_done', [
            'leerling_id' => $id,
            'affected' => $affected,
        ]);

        return $affected;
    }

    public function sp_DeleteLeerling(int $id): int
    {
        // DELETE: leerling verwijderen op basis van ID.
        $this->logCrudAction('delete_start', ['leerling_id' => $id]);

        $row = $this->safeSelectOne('CALL sp_DeleteLeerling(:id)', ['id' => $id]);

        $affected = (int) ($row->affected ?? 0);
        $this->logCrudAction('delete_done', [
            'leerling_id' => $id,
            'affected' => $affected,
        ]);

        return $affected;
    }

    public function sp_GetActieveInstructeurs(): array
    {
        return $this->safeSelect('CALL sp_GetActieveInstructeurs()');
    }

    public function sp_GetActieveLespakketten(): array
    {
        return $this->safeSelect('CALL sp_GetActieveLespakketten()');
    }
}
