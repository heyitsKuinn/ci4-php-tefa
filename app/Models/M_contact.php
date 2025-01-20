<?php
namespace App\Models;

use CodeIgniter\Model;

class M_contact extends Model
{
    protected $table = 'contacts';
    protected $primaryKey = 'id_kontak';
    protected $allowedFields = ['id_kontak', 'nama', 'no_telp', 'id_group', 'variable', 'country', 'created_at', 'modified_at', 'deleted_at'];
    protected $useSoftDeletes = true;
    protected $useTimestamps = true; // Gunakan fitur timestamps 
    protected $createdField = 'created_at'; // Kolom untuk waktu pembuatan 
    protected $updatedField = 'modified_at'; // Kolom untuk waktu modifikasi

    public function getContactsWithGroups()
    {
        return $this->select('contacts.*, GROUP_CONCAT(groups.nama_grup SEPARATOR ", ") as nama_grup')
                    ->join('contact_groups', 'contact_groups.id_kontak = contacts.id_kontak', 'left')
                    ->join('groups', 'groups.id_group = contact_groups.id_group', 'left')
                    ->groupBy('contacts.id_kontak')
                    ->findAll();
    }
}
