<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Facaturen extends Model
{
    protected $table = 'Facaturen';

    protected $primaryKey = 'FacatuurId';

    public $timestamps = false;

    protected $guarded = [];

    public function getAll()
    {
        return DB::select('CALL sp_GetAllFacaturen()');
    }

    public function getById($id)
    {
        return DB::selectOne(
            'CALL sp_GetFacatuurById(?)',
            [$id]
        );
    }

    public function createFacatuur($data)
    {
        return DB::selectOne(
            'CALL sp_CreateFacatuur(?,?,?,?,?,?)',
            [
                $data['lespakket_id'],
                $data['kaarthouder'],
                $data['kaartnummer'],
                $data['vervaldatum'].'-01',
                $data['cvv'],
                $data['opmerking'] ?? null
            ]
        );
    }

    public function updateFacatuur($id,$data)
    {
        return DB::selectOne(
            'CALL sp_UpdateFacatuur(?,?,?,?,?,?,?)',
            [
                $id,
                $data['kaarthouder'],
                $data['kaartnummer'],
                $data['vervaldatum'].'-01',
                $data['cvv'],
                $data['isactief'],
                $data['opmerking'] ?? null
            ]
        );
    }

    public function deleteFacatuur($id)
    {
        return DB::selectOne(
            'CALL sp_DeleteFacatuur(?)',
            [$id]
        );
    }
}