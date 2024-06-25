<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelUnit extends Model
{
    protected $table            = 'unit';
    protected $primaryKey       = 'satid';
    protected $allowedFields    = [
        'satid', 'katid'
    ];

    public function searchData($search)
    {
        return $this->table('unit')->like('satid', $search);
    }
}
