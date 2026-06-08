<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Facaturen extends Model
{
    protected $table = 'Facaturen';

    protected $primaryKey = 'FacaturenId';

    public $timestamps = false;

    protected $guarded = [];

    public function sp_GetAllLespakketten(): array
    {
        return DB::select('CALL sp_GetAllLespakketten()');
    }

    public function sp_GetLespakkettenById(int $id): ?object
    {
        return DB::selectOne('CALL sp_GetLespakkettenById(:id)', ['id' => $id]);
    }

    public function sp_CreateLespakket(array $Data): int
    {
        $row = DB::selectOne(
            'CALL sp_CreateLespakket(:naam, :omschrijving, :duur, :prijs)',
            [
                'naam' => $Data['naam'],
                'omschrijving' => $Data['omschrijving'],
                'duur' => $Data['duur'],
                'prijs' => $Data['prijs'],
            ]
        );

        return (int) ($row->new_id ?? 0);
    }

    public function sp_UpdateLespakket(int $id, array $Data): int
    {
        $row = DB::selectOne(
            'CALL sp_UpdateLespakket(:id, :naam, :omschrijving, :duur, :prijs)',
            [
                'id' => $id,
                'naam' => $Data['naam'],
                'omschrijving' => $Data['omschrijving'],
                'duur' => $Data['duur'],
                'prijs' => $Data['prijs'],
            ]
        );

        return (int) ($row->affected ?? 0);
    }
}