<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelCategory extends Model
{
    protected $table            = 'category';
    protected $primaryKey       = 'katid';
    protected $allowedFields    = [
        'katid', 'katnama'
    ];

    public function searchData($search)
    {
        return $this->table('category')->like('katnama', $search);
    }
    public function showData()
    {
        return $this->table('products')->join('category', 'brgkatid = katid')->join('unit', 'brgsatid = satid')->get();
    }
}
