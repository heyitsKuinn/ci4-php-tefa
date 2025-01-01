<?php

namespace App\Models;

use CodeIgniter\Model;

class M_device extends Model
{
    protected $table = 'device';
    protected $primaryKey = 'id_device';
    protected $allowedFields = ['id_device', 'nama', 'nomor_telepo', 'token'];
    protected $useSoftDeletes = true;


}