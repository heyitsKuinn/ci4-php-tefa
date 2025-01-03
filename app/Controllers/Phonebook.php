<?php

namespace App\Controllers;
use App\Models\M_contact;

class Phonebook extends BaseController
{
    public function contact()
    {
        $contact = new M_contact();   
        $data['data'] = $contact->findAll();
        return view('phonebook/contact', $data);  // Memuat tampilan contact 
    }

    public function tambah_contact()
    {
        // Periksa apakah request adalah POST
        if ($this->request->is('post')) {
            $model = new M_contact();

            $numbers = $this->request->getPost('number');
            $country = $this->request->getPost('countryCode');
            $groups = $this->request->getPost('grup');

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
                        'grup' => implode(',', $groups),
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
        return view('phonebook/tambah_contact');
    }
}  