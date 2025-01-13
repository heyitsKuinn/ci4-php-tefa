<?php

namespace App\Models;

use CodeIgniter\Model;

class M_groups extends Model
{
    protected $table = 'groups';
    protected $primaryKey = 'id_group';
    protected $allowedFields = ['id_group', 'nama_grup', 'created_at', 'modified_at', 'deleted_at'];
    protected $useSoftDeletes = true;
    protected $useTimestamps = true; // Gunakan fitur timestamps 
    protected $createdField = 'created_at'; // Kolom untuk waktu pembuatan 
    protected $updatedField = 'modified_at'; // Kolom untuk waktu modifikasi

    public function getGroupsWithContactCount()
    {
        return $this->select('groups.*, COUNT(contacts.id_kontak) as jumlah_kontak')
                    ->join('contact_groups', 'contact_groups.id_group = groups.id_group', 'left')
                    ->join('contacts', 'contacts.id_kontak = contact_groups.id_kontak AND contacts.deleted_at IS NULL', 'left')
                    ->groupBy('groups.id_group')
                    ->findAll();
    }
}
