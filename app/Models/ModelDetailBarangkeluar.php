<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelDetailBarangkeluar extends Model
{
    protected $table            = 'detail_barangkeluar';
    protected $primaryKey       = 'id';

    protected $allowedFields    = [
        'detfaktur', 'detbrgkode', 'dethargamasuk', 'dethargajual', 'detjml', 'detsubtotal'
    ];

    public function showDataTemp($nofaktur)
    {
        return $this->table('detail_barangkeluar')->join('product', 'detbrgkode=brgkode')->join('unit', 'brgsatid=satid')->where('detfaktur', $nofaktur)->get();
    }

    function ambilTotalPrice($nofaktur)
    {
        $query = $this->table('detail_barangkeluar')->getWhere([
            'detfaktur' => $nofaktur
        ]);
        $totalPrice = 0;
        foreach ($query->getResultArray() as $r) :
            $totalPrice += $r['detsubtotal'];
        endforeach;
        return $totalPrice;
    }
}
