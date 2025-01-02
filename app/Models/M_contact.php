<?php

namespace App\Models;

use CodeIgniter\Model;

class M_contact extends Model
{
    protected $table = 'contacts';
    protected $primaryKey = 'id_kontak';
    protected $allowedFields = ['id_kontak', 'nama', 'nomor_telp', 'group', 'variable'];
    //protected $useSoftDeletes = true;


}