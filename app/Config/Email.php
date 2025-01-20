<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    // Email Pengirim (from)
    public string $fromEmail  = '001tefait@gmail.com';  // Ganti dengan alamat email Anda
    public string $fromName   = 'TEFA IT';  // Nama pengirim, misalnya nama aplikasi
    public string $recipients = '';  // Bisa kosong jika tidak ada penerima default

    // User Agent
    public string $userAgent = 'CodeIgniter';

    // Protokol Pengiriman Email
    public string $protocol = 'smtp';  // Ubah ke 'smtp' untuk pengiriman via SMTP

    // Lokasi Sendmail (biarkan default jika tidak menggunakan sendmail)
    public string $mailPath = '/usr/sbin/sendmail';

    // Pengaturan SMTP Server
    public string $SMTPHost = 'smtp.gmail.com';  // Host SMTP Gmail
    public string $SMTPUser = '001tefait@gmail.com';  // Alamat email Anda untuk autentikasi
    public string $SMTPPass = 'asdqwe123@#$';  // Password atau App Password jika menggunakan 2FA
    public int $SMTPPort = 587;  // Port SMTP untuk Gmail (gunakan 465 untuk SSL)
    
    // Timeout SMTP (dalam detik)
    public int $SMTPTimeout = 5;

    // Mengaktifkan koneksi SMTP yang persisten
    public bool $SMTPKeepAlive = false;

    // Enkripsi SMTP: tls untuk Gmail
    public string $SMTPCrypto = 'tls';

    // Enable word-wrap pada email
    public bool $wordWrap = true;

    // Jumlah karakter untuk word wrap
    public int $wrapChars = 76;

    // Jenis email: 'text' atau 'html'
    public string $mailType = 'html';  // Mengirimkan email dalam format HTML

    // Karakter set untuk email
    public string $charset = 'UTF-8';

    // Validasi alamat email
    public bool $validate = false;

    // Prioritas email
    public int $priority = 3;

    // Karakter baru untuk email (RFC 822)
    public string $CRLF = "\r\n";
    public string $newline = "\r\n";

    // Mengaktifkan BCC Batch Mode
    public bool $BCCBatchMode = false;
    public int $BCCBatchSize = 200;

    // Mengaktifkan pesan pemberitahuan dari server
    public bool $DSN = false;
}