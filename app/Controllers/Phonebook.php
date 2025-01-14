<?php

namespace App\Controllers;
use App\Models\M_contact;
use App\Models\M_groups;
use App\Models\M_contact_groups;

class Phonebook extends BaseController
{
    private $db;
 
    public function contact()
    {
        $contactModel = new M_contact();
        $groupModel = new M_groups();

        // Ambil semua kontak dengan atau tanpa grup
        $data = $contactModel->getContactsWithGroups();

        // Ambil data grup untuk digunakan dalam select dropdown
        $groups = $groupModel->findAll();

        // Kirim data kontak dan grup ke view
        return view('phonebook/contact', ['data' => $data, 'groups' => $groups]);
    }

    public function tambah_contact()
    {
        $groupModel = new M_groups();
        $contactGroupsModel = new M_contact_groups(); // Model untuk tabel penghubung
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
            $contacts = [];

            foreach ($lines as $line) {
                $parts = explode('|', trim($line));
                if (count($parts) === 3) {
                    $contacts[] = [
                        'no_telp' => $parts[0],
                        'nama' => $parts[1],
                        'variable' => $parts[2],
                        'country' => $country,
                        'created_at' => date('Y-m-d H:i:s'),
                    ];
                }
            }

            if (!empty($contacts) && $model->insertBatch($contacts)) {
                // Ambil ID kontak yang baru saja dimasukkan
                $insertedIds = $model->insertID();

                // Simpan data ke tabel penghubung
                foreach ($contacts as $index => $contact) {
                    $contactId = $insertedIds + $index;
                    foreach ($groups as $groupId) {
                        $contactGroupsModel->insert(['id_kontak' => $contactId, 'id_group' => $groupId]);
                    }
                }

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
        $contactGroupsModel = new M_contact_groups(); // Model untuk tabel penghubung

        // Ambil data kontak berdasarkan ID
        $contact = $model->find($id_kontak);
        if (!$contact) {
            return redirect()->to(base_url('phonebook/contact'))->with('msg', '<div class="alert alert-danger">Kontak tidak ditemukan.</div>');
        }

        // Ambil semua grup
        $groups = $groupModel->findAll();

        // Ambil grup yang sudah terhubung dengan kontak ini
        $contactGroups = $contactGroupsModel->where('id_kontak', $id_kontak)->findAll();
        $contactGroupIds = array_column($contactGroups, 'id_group');

        // Periksa apakah request adalah POST untuk menyimpan perubahan
        if ($this->request->getMethod() === 'post') {
            $updatedData = [
                'nama' => $this->request->getPost('nama'),
                'no_telp' => $this->request->getPost('nomor_telepon'),
                'variable' => $this->request->getPost('variable'),
                'modified_at' => date('Y-m-d H:i:s'),
            ];

            // Perbarui data kontak
            if ($model->update($id_kontak, $updatedData)) {
                // Hapus semua grup lama yang terhubung dengan kontak ini
                $contactGroupsModel->where('id_kontak', $id_kontak)->delete();

                // Simpan grup baru yang terhubung dengan kontak ini
                $newGroups = $this->request->getPost('groups');
                if (!empty($newGroups)) {
                    foreach ($newGroups as $groupId) {
                        $contactGroupsModel->insert(['id_kontak' => $id_kontak, 'id_group' => $groupId]);
                    }
                }

                return redirect()->to(base_url('phonebook/contact'))->with('msg', '<div class="alert alert-primary">Kontak berhasil diperbarui.</div>');
            } else {
                return redirect()->back()->with('msg', '<div class="alert alert-danger">Gagal memperbarui kontak.</div>');
            }
        }

        // Kirim data ke view
        return view('phonebook/edit_contact', [
            'contact' => $contact,
            'groups' => $groups,
            'contactGroupIds' => $contactGroupIds, // Kirim ID grup yang sudah terhubung dengan kontak ini
        ]);
    }


    public function hapus_contact()
    {
        $model = new M_contact(); // Model kontak untuk menghapus data
        $contactGroupsModel = new \App\Models\M_contact_groups(); // Model untuk tabel penghubung

        $id_kontak = $this->request->getPost('id_kontak'); // Ambil id kontak dari POST

        // Hapus data dari tabel penghubung terlebih dahulu
        $contactGroupsModel->where('id_kontak', $id_kontak)->delete();

        // Kemudian, hapus kontak dari tabel contacts
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


    public function group()
    {
        $contactModel = new M_contact();
        $groupModel = new M_groups();
        $contactGroupsModel = new M_contact_groups();

        // Ambil semua kontak dengan grup menggunakan join dari tabel penghubung
        $data = $contactModel
            ->select('contacts.*, GROUP_CONCAT(groups.nama_grup SEPARATOR ", ") as nama_grup')
            ->join('contact_groups', 'contact_groups.id_kontak = contacts.id_kontak', 'left')
            ->join('groups', 'groups.id_group = contact_groups.id_group', 'left')
            ->groupBy('contacts.id_kontak')
            ->findAll();

        // Ambil data grup beserta jumlah kontak dan anggota
        $groups = $groupModel->getGroupsWithContactCount();

        // Kirim data kontak dan grup ke view
        return view('phonebook/group', ['data' => $data, 'groups' => $groups]);
    }

    public function tambah_group()
    {
        $groupModel = new M_groups();
        $contactModel = new M_contact(); // Pastikan model M_contacts sudah ada
        $contactGroupsModel = new M_contact_groups();

        $data['contacts'] = $contactModel->findAll(); // Ambil semua kontak

        // Periksa apakah request adalah POST
        if ($this->request->getMethod() === 'post') {
            // Ambil data dari form
            $nama_grup = $this->request->getPost('nama_grup');
            $selected_contacts = $this->request->getPost('contacts');

            // Log data untuk debugging 
            error_log('Nama Grup: ' . $nama_grup); 
            error_log('Kontak Terpilih: ' . json_encode($selected_contacts));

            // Simpan grup baru
            $groupModel->insert([
                'nama_grup' => $nama_grup,
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            // Ambil id_group yang baru saja dimasukkan
            $id_group = $groupModel->getInsertID();

            // Simpan data ke tabel penghubung
            if (!empty($selected_contacts)) {
                foreach ($selected_contacts as $contact_id) {
                    $contactGroupsModel->insert(['id_kontak' => $contact_id, 'id_group' => $id_group]);
                }
            }

            return redirect()->to(base_url('phonebook/group'))->with('msg', '<div class="alert alert-primary">Group berhasil ditambahkan.</div>');
        }

        // Jika request adalah GET, tampilkan form
        return view('phonebook/tambah_group', $data); // Pass contact data to view
    }

    public function get_group_details($id_group)
    {
        $contactGroupsModel = new \App\Models\M_contact_groups();
        $contactModel = new M_contact();

        // Ambil ID kontak yang termasuk dalam grup berdasarkan id_group
        $contactIds = $contactGroupsModel->where('id_group', $id_group)->findColumn('id_kontak');

        if ($contactIds) {
            // Ambil data kontak berdasarkan ID kontak
            $members = $contactModel->whereIn('id_kontak', $contactIds)->findAll();
        } else {
            $members = [];
        }

        // Kembalikan data dalam format JSON
        return $this->response->setJSON($members);
    }

    public function edit_group()
    {
        $groupModel = new M_groups();

        // Ambil data dari request
        $id_group = $this->request->getPost('id_group');
        $nama_grup = $this->request->getPost('nama_grup');

        // Update nama grup di database
        $data = [
            'nama_grup' => $nama_grup,
        ];
        $groupModel->update($id_group, $data);

        // Kembalikan response dalam format JSON
        return $this->response->setJSON(['success' => true]);
    }

    public function hapus_group()
    {
        $groupModel = new M_groups();

        // Ambil data dari request
        $id_group = $this->request->getPost('id_group');

        // Hapus grup dari database
        $result = $groupModel->delete($id_group);

        if ($groupModel->delete($id_group)) {
            session()->setFlashdata('msg', '<div class="alert alert-primary alert-dismissible fade show mb-0" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <b>Group berhasil dihapus.</b>
            </div>');
        } else {
            session()->setFlashdata('msg', '<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <b>Group gagal dihapus.</b>
            </div>');
        }

        return redirect()->back();
    }

    public function wa_group()
    {
        return view('phonebook/wa_group');
    }
    
} 