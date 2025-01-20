<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Kode</title>
</head>

<body>
    <h1>Verifikasi Kode</h1>
    <?php if (session()->getFlashdata('error')): ?>
    <p style="color: red;"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>
    <form action="<?= base_url('verify-code') ?>" method="post">
        <input type="email" name="email" placeholder="Masukkan email" required>
        <input type="text" name="verification_code" placeholder="Masukkan kode verifikasi" required>
        <button type="submit">Verifikasi</button>
    </form>


</body>

</html>