<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelDetailBarangMasuk extends Model
{
    protected $table            = 'detail_barangmasuk';
    protected $primaryKey       = 'iddetail';
    protected $allowedFields    = [
        'detfaktur','detbrgkode','dethargamasuk','dethargajual','detjml','detsubtotal'
    ];

    
}
