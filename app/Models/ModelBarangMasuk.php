<?php

namespace App\Models;

use App\Controllers\BarangMasuk;
use CodeIgniter\Model;

class ModelBarangMasuk extends Model
{
    protected $table            = 'barangmasuk';
    protected $primaryKey       = 'faktur';
    protected $allowedFields    = [
        'faktur', 'tglfaktur', 'totalharga'
    ];

    public function showData_search($search)
    {
        return $this->table('barangMasuk')->like('faktur', $search);
    }

    public function laporanPeriode($firstDate, $lastDate)
    {
        return $this->table('barangmasuk')->where('tglfaktur >=', $firstDate)->where('tglfaktur <=', $lastDate)->get();
    }
}
