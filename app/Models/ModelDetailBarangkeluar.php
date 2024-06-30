<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelDetailBarangkeluar extends Model
{
    protected $table            = 'detail_barangkeluar';
    protected $primaryKey       = 'idetail';

    protected $allowedFields    = [
        'idetail', 'detfaktur', 'detbrgkode', 'dethargamasuk', 'dethargajual', 'detjml', 'detsubtotal'
    ];

    public function showDataTemp($nofaktur)
    {
        return $this->table('detail_barangkeluar')->join('product', 'detbrgkode=brgkode')->where('detfaktur', $nofaktur)->get();
    }
}
