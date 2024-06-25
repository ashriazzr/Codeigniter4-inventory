<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTempBarangMasuk extends Model
{
    protected $table            = 'temp_barangmasuk';
    protected $primaryKey       = 'iddetail';
    protected $allowedFields    = [
        'detfaktur', 'detbrgkode', 'dethargamasuk', 'dethargajual', 'detjml', 'detsubtotal'
    ];

    public function showDataTemp($faktur)
    {
        return $this->table('temp_barangmasuk')->join('product', 'brgkode=detbrgkode')->where(['detfaktur' => $faktur])->get();
    }
}
