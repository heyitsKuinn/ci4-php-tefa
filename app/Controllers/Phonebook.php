<?php

namespace App\Controllers;
use App\Models\M_contact;

class Phonebook extends BaseController
{
    public function contact()
    {
        $contact = new M_contact();   
        $data['data'] = $contact->findAll();
        // dd($data);
        //return view('device/device', $data);
        return view('phonebook/contact', $data);  // Memuat tampilan contact 
    }
}  