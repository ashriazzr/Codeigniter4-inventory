<?php

namespace App\Models;

use CodeIgniter\Model;
use PhpParser\Node\Stmt\Return_;

class ModelTempBarangKeluar extends Model
{
    protected $table            = 'temp_barangkeluar';
    protected $primaryKey       = 'id';

    protected $allowedFields    = [
        'detfaktur', 'detbrgkode', 'dethargamasuk', 'dethargajual', 'detjml', 'detsubtotal'
    ];

    public function showDataTemp($nofaktur)
    {
        return $this->table('temp_barangkeluar')->join('product', 'detbrgkode=brgkode')->where('detfaktur', $nofaktur)->get();
    }

    public function deleteData($nofaktur)
    {
        $this->table('temp_barangkeluar')->where('detfaktur', $nofaktur);
        return $this->table('temp_barangkeluar')->delete();
    }
}
