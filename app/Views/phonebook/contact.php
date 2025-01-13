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
                                        <th>Group</th>
                                        <th>Variable</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($data)): 
                                        $no = 1;
                                        foreach ($data as $row): ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td><?= $row['nama']; ?></td>
                                                <td><?= $row['no_telp']; ?></td>
                                                <td><?= $row['nama_grup'] ?? 'No Group'; ?></td> <!-- Tampilkan "No Group" jika nama_grup NULL -->
                                                <td><?= $row['variable']; ?></td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm" onclick="openEditModal({
                                                        id_kontak: <?= $row['id_kontak'] ?>, 
                                                        nama: '<?= $row['nama'] ?>', 
                                                        no_telp: '<?= $row['no_telp'] ?>', 
                                                        variable: '<?= $row['variable'] ?>'
                                                    })">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </button>
                                                    <form action="<?= base_url('phonebook/hapus_contact') ?>" method="post" style="display:inline;">
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

<div class="modal fade" id="editContactModal" tabindex="-1" aria-labelledby="editContactModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editContactModalLabel">Edit Contact</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editContactForm" method="post">
                <div class="modal-body">
                    <input type="hidden" id="edit_id_kontak" name="id_kontak">
                    <div class="mb-3">
                        <label for="edit_nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="edit_nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_nomor_telepon" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" id="edit_nomor_telepon" name="no_telp" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_variable" class="form-label">Variable</label>
                        <input type="text" class="form-control" id="edit_variable" name="variable" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_groups" class="form-label">Groups</label>
                        <select name="groups[]" id="edit_groups" class="form-control selectpicker" multiple>
                            <?php foreach ($groups as $group): ?>
                                <option value="<?= $group['id_group'] ?>"><?= $group['nama_grup'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openEditModal(contact) {
        document.getElementById('edit_id_kontak').value = contact.id_kontak;
        document.getElementById('edit_nama').value = contact.nama;
        document.getElementById('edit_nomor_telepon').value = contact.no_telp;
        document.getElementById('edit_variable').value = contact.variable;

        // Set selected groups
        const groupSelect = $('#edit_groups');
        groupSelect.val(contact.groups ? contact.groups.split(',') : []).trigger('change');

        // Set action URL for form
        document.getElementById('editContactForm').action = `<?= base_url('/phonebook/edit_contact') ?>/${contact.id_kontak}`;

        // Show modal
        new bootstrap.Modal(document.getElementById('editContactModal')).show();
    }

</script>

<?= $this->endSection() ?>
