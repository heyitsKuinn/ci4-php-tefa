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
    
    public function save()
    {
        $deviceModel = new M_device();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama' => 'required|min_length[3]|max_length[50]',
            'nomor_telepo' => 'required|numeric',
            'token' => 'required|max_length[255]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors()
            ]);
        }

        if ($this->request->getPost('action') === 'simpan') {
            try {
                $deviceModel->save([
                    'nama' => $this->request->getPost('nama'),
                    'nomor_telepo' => $this->request->getPost('nomor_telepo'),
                    'token' => $this->request->getPost('token'),
                ]);

                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Device berhasil ditambahkan'
                ]);
            } catch (\Exception $e) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Failed to save device: ' . $e->getMessage()
                ]);
            }
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Invalid action'
        ]);
    }
}