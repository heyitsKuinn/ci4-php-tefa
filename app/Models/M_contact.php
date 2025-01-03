<?php

namespace App\Models;

use CodeIgniter\Model;

class M_contact extends Model
{
    protected $table = 'contacts';
    protected $primaryKey = 'id_kontak';
    protected $allowedFields = ['id_kontak', 'nama', 'no_telp', 'id_group', 'variable', 'country', 'created_at', 'modified_at', 'deleted_at'];
    protected $useSoftDeletes = true;

    public function getContactsWithGroups()
    {
        return $this->select('contacts.*, groups.nama_grup')
                    ->join('groups', 'contacts.id_group = groups.id_group', 'left')
                    ->findAll();
    }

}