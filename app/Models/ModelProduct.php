<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelProduct extends Model
{
    protected $table            = 'product';
    protected $primaryKey       = 'brgkode';
    protected $allowedFields    = [
        'brgkode', 'brgnama', 'brgkatid', 'brgsatid', 'brgharga', 'brggambar', 'brgstock'
    ];

    public function showData()
    {
        return $this->table('products')->join('category', 'brgkatid = katid')->join('unit', 'brgsatid = satid');
    }

    public function showData_search($search)
    {
        return $this->table('product')->join('category', 'product.brgkatid = category.katid')
            ->join('unit', 'product.brgsatid = unit.satid')
            ->orlike('product.brgkode', $search)
            ->orLike('product.brgnama', $search)
            ->orLike('category.katnama', $search);
    }
}
