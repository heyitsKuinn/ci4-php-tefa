<?php

namespace App\Controllers;
use App\Models\M_contact;
use App\Models\M_groups;

class Phonebook extends BaseController
{
    private $db;
 
    public function contact()
    {
        $contactModel = new M_contact();
        $groupModel = new M_groups();

        // Ambil semua kontak dengan grup menggunakan join
        $data = $contactModel
            ->select('contacts.*, groups.nama_grup')
            ->join('groups', 'contacts.id_group = groups.id_group', 'left') // Left join untuk menyertakan kontak tanpa grup
            ->findAll();

        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // die(); 
        
        // Ambil data grup untuk digunakan dalam select dropdown
        $groups = $groupModel->findAll();

        // Kirim data kontak dan grup ke view
        return view('phonebook/contact', ['data' => $data, 'groups' => $groups]);
    }

    public function tambah_contact()
    {
        $groupModel = new \App\Models\M_groups(); // Pastikan model M_groups sudah ada
        $data['groups'] = $groupModel->findAll(); // Ambil semua grup

        // Periksa apakah request adalah POST
        if ($this->request->is('post')) {
            $model = new M_contact();

            $numbers = $this->request->getPost('number');
            $country = $this->request->getPost('countryCode');
            $groups = $this->request->getPost('groups');

            if (!is_array($groups)) {
                $groups = [];
            }

            $lines = explode("\n", $numbers);
            $data = [];

            foreach ($lines as $line) {
                $parts = explode('|', trim($line));
                if (count($parts) === 3) {
                    $data[] = [
                        'no_telp' => $parts[0],
                        'nama' => $parts[1],
                        'variable' => $parts[2],
                        'id_group' => implode(',', $groups), // Simpan id_group sebagai string CSV
                        'country' => $country,
                        'created_at' => date('Y-m-d H:i:s'),
                    ];
                }
            }

            if (!empty($data) && $model->insertBatch($data)) {
                return redirect()->to(base_url('phonebook/contact'))->with('msg', '<div class="alert alert-primary">Kontak berhasil ditambahkan.</div>');
            } else {
                return redirect()->to(base_url('phonebook/contact'))->with('msg', '<div class="alert alert-danger">Kontak gagal ditambahkan.</div>');
            }
        }

        // Jika request adalah GET, tampilkan form
        return view('phonebook/tambah_contact', $data); // Pass group data to view
    }


    public function edit_contact($id_kontak)
    {
        $model = new M_contact();
        $groupModel = new M_groups();

        // Ambil data kontak berdasarkan ID
        $contact = $model->find($id_kontak);
        if (!$contact) {
            return redirect()->to(base_url('phonebook/contact'))->with('msg', '<div class="alert alert-danger">Kontak tidak ditemukan.</div>');
        }

        // Ambil semua grup
        $groups = $groupModel->findAll();

        // Periksa apakah request adalah POST untuk menyimpan perubahan
        if ($this->request->is('post')) {
            $updatedData = [
                'nama' => $this->request->getPost('nama'),
                'no_telp' => $this->request->getPost('nomor_telepon'),
                'variable' => $this->request->getPost('variable'),
                'id_group' => implode(',', $this->request->getPost('groups')), // Simpan grup sebagai CSV
                'modified_at' => date('Y-m-d H:i:s'),
            ];

            if ($model->update($id_kontak, $updatedData)) {
                return redirect()->to(base_url('phonebook/contact'))->with('msg', '<div class="alert alert-primary">Kontak berhasil diperbarui.</div>');
            } else {
                return redirect()->back()->with('msg', '<div class="alert alert-danger">Gagal memperbarui kontak.</div>');
            }
        }

        // Kirim data ke view
        return view('phonebook/edit_contact', [
            'contact' => $contact,
            'groups' => $groups,
        ]);
    }

    public function hapus_contact()
    {
        $model = new M_contact(); // Model kontak untuk menghapus data

        $id_kontak = $this->request->getPost('id_kontak'); // Ambil id kontak dari POST

        if ($model->delete($id_kontak)) {
            session()->setFlashdata('msg', '<div class="alert alert-primary alert-dismissible fade show mb-0" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <b>Kontak berhasil dihapus.</b>
            </div>');
        } else {
            session()->setFlashdata('msg', '<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <b>Kontak gagal dihapus.</b>
            </div>');
        }

        return redirect()->back();
    }

} 