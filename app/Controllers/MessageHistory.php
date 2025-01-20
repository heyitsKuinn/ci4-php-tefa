<?php

namespace App\Controllers;

class MessageHistory extends BaseController
{
    public function history()
    {
        return view('message_history/history');  // Memuat tampilan welcome
    }
}