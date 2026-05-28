<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Leerling extends Model
{
    protected $table = 'Leerlingen';

    protected $primaryKey = 'LeerlingId';

    public $timestamps = false;

    protected $guarded = [];

    public function sp_GetAllLeerlingen(): array
    {
        return DB::select('CALL sp_GetAllLeerlingen()');
    }

    public function sp_GetLeerlingById(int $id): ?object
    {
        return DB::selectOne('CALL sp_GetLeerlingById(:id)', ['id' => $id]);
    }

    public function sp_CreateLeerling(array $leerlingData): int
    {
        $row = DB::selectOne(
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

        return (int) ($row->new_id ?? 0);
    }

    public function sp_UpdateLeerling(int $id, array $leerlingData): int
    {
        $row = DB::selectOne(
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

        return (int) ($row->affected ?? 0);
    }

    public function sp_DeleteLeerling(int $id): int
    {
        $row = DB::selectOne('CALL sp_DeleteLeerling(:id)', ['id' => $id]);

        return (int) ($row->affected ?? 0);
    }

    public function sp_GetActieveInstructeurs(): array
    {
        return DB::select('CALL sp_GetActieveInstructeurs()');
    }

    public function sp_GetActieveLespakketten(): array
    {
        return DB::select('CALL sp_GetActieveLespakketten()');
    }
}
