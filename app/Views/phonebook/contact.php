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
                <h6 class="m-0 font-weight-bold text-primary">Data Kontak</h6>
            </div>
            <div class="card-body">
                    <a href="<?= base_url('phonebook/tambah_contact') ?>" class="btn btn-success btn-icon-split btn-sm">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">Tambah Kontak</span>
                    </a>
                    <p></p>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>No Telepon</th>
                                        <th>Grup</th>
                                        <th>Variable</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $db = \Config\Database::connect();
                                        $query = $db->query("SELECT * FROM contacts");
                                        $result = $query->getResultArray();
                                        if (count($result) > 0): 
                                            $no = 1;
                                            foreach ($result as $row): ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $row['nama']; ?></td>
                                                    <td><?= $row['no_telp']; ?></td>
                                                    <td><?= $row['grup']; ?></td>
                                                    <td><?= $row['variable']; ?></td>
                                                    <td>
                                                        <button class="btn btn-warning btn-sm" onclick="openEditModal({id_kontak: <?= $row['id_kontak'] ?>, nama: '<?= $row['nama'] ?>', no_telp: '<?= $row['no_telp'] ?>'})">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </button>
                                                        <form action="<?= base_url('device/hapus') ?>" method="post" style="display:inline;">
                                                            <input type="hidden" name="id_kontak" value="<?= $row['id_kontak'] ?>">
                                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus kontak ini?')">
                                                                <i class="fas fa-trash"></i> Delete
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php 
                                            $no++;
                                            endforeach;
                                        else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center">No contacts available.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </p>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
