<?php

namespace App\Models;

use CodeIgniter\Model;

class Users extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'userid';

    protected $allowedFields    = [
        'usernama', 'userpassword', 'userlevelid', 'useraktif'
    ];
}
