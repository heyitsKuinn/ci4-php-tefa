<?php

namespace App\Controllers;
use App\Models\M_device;

class device extends BaseController
{
    public function device()
    {
        $device = new M_device();   
        $data['data'] = $device->findAll();
        // dd($data);
        return view('device/device', $data); 
    }
    
    public function simpandevice()
    {
        $model = new M_device();

        $nama = $this->request->getPost('nama');
        $nomorTelepon = $this->request->getPost('nomor_telepon');
        $token = $this->request->getPost('token');
    
        $data = [
            'nama' => $nama,
            'nomor_telepon' => $nomorTelepon,
            'token' => $token,
            'created_at' => date('Y-m-d H:i:s')
        ];
        // dd($data);
    

        if ($model->insert($data)) {
            session()->setFlashdata('msg', '<div class="alert alert-primary alert-dismissible fade show mb-0" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <b>Device berhasil ditambahkan.</b>
            </div>');
        } else {
            session()->setFlashdata('msg', '<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <b>Device gagal ditambahkan.</b>
            </div>');
        }
    
        return redirect()->back();
    }

    public function editDevice()
    {
        $model = new M_device();

        $id_device = $this->request->getPost('id_device');
        $nama = $this->request->getPost('nama');
        $nomorTelepon = $this->request->getPost('nomor_telepon');
        $token = $this->request->getPost('token');

        $data = [
            'nama' => $nama,
            'nomor_telepo' => $nomorTelepon,
            'token' => $token
        ];

        if ($model->update($id_device, $data)) {
            session()->setFlashdata('msg', '<div class="alert alert-primary alert-dismissible fade show mb-0" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <b>Device berhasil diperbarui.</b>
            </div>');
        } else {
            session()->setFlashdata('msg', '<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <b>Device gagal diperbarui.</b>
            </div>');
        }

        return redirect()->back();
    }

    public function hapusDevice()
    {
        $model = new M_device();

        $id_device = $this->request->getPost('id_device');

        if ($model->delete($id_device)) {
            session()->setFlashdata('msg', '<div class="alert alert-primary alert-dismissible fade show mb-0" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <b>Device berhasil dihapus.</b>
            </div>');
        } else {
            session()->setFlashdata('msg', '<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <b>Device gagal dihapus.</b>
            </div>');
        }

        return redirect()->back();
    }
}