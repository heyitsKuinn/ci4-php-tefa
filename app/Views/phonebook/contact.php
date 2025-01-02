<?= $this->extend('template/layout') ?>

<?= $this->section('title') ?>
    <title>Tefa IT - Contact</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Contact List</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">

    <!-- Contact Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <button type="button" class="btn btn-dark btn-sm float-left" data-bs-toggle="modal" data-bs-target="#addContactModal">+ Add Contact</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered float-right" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>No Telepon</th>
                            <th>Group</th>
                            <th>Variable</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <?php foreach ($data as $row): ?>
                    <tbody>
                        <tr>
                            <td>
                                <div><?= $row['nama'] ?></div>
                            </td>
                            <td>
                                <div><?= $row['no_telp'] ?></div>
                            </td>
                            <td>
                                <div><?= $row['groub'] ?></div>
                            </td>
                            <td>
                                <div><?= $row['variable'] ?></div>
                            </td>
                            <td>
                                <button class="btn btn-info btn-sm" onclick="openEditModal({id_kontak: <?= $row['id_kontak'] ?>, nama: '<?= $row['nama'] ?>', no_telp: '<?= $row['no_telp'] ?>'})">Edit</button>
                                <form action="<?= base_url('device/hapus') ?>" method="post" style="display:inline;">
                                    <input type="hidden" name="id_kontak" value="<?= $row['id_kontak'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus kontak ini?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>