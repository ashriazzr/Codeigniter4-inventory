<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBarangKeluar extends Model
{
    protected $table            = 'barangkeluar';
    protected $primaryKey       = 'faktur';
    protected $allowedFields    = [
        'faktur', 'tglfaktur', 'idpel', 'totalharga', 'jumlahuang', 'sisauang'
    ];

    public function noFaktur($realDate)
    {
        return $this->table('barangkeluar')->select('max(faktur) as nofaktur')->where('tglfaktur', $realDate)->get();

        // select max(faktur) as nofaktur from barangkeluar where tglfaktur='';
    }
    public function laporanPeriode($firstDate, $lastDate)
    {
        return $this->table('barangkeluar')->where('tglfaktur >=', $firstDate)->where('tglfaktur <=', $lastDate)->get();
    }
}
