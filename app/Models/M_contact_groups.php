<?php 
namespace App\Models;

use CodeIgniter\Model;

class M_contact_groups extends Model
{
    protected $table = 'contact_groups';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_kontak', 'id_group'];
}

?>
