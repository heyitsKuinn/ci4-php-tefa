<?php

namespace App\Models;

use CodeIgniter\Model;

class M_groups extends Model
{
    protected $table = 'groups';
    protected $primaryKey = 'id_group';
    protected $allowedFields = ['id_group', 'nama_grup', 'created_at', 'modified_at', 'deleted_at'];
    protected $useSoftDeletes = true;
}
