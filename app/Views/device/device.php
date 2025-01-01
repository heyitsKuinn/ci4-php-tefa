<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Devices Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Devices</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($data) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tablet-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Connect Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Connect</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">-</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-link fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Messages Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Messages</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">68</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-envelope fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    
    <!-- Devices Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Devices</h6>
            <button type="button" class="btn btn-dark btn-sm float-right" data-bs-toggle="modal" data-bs-target="#addDeviceModal">+ Add Device</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered float-right" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Device</th>
                            <th>Package</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <?php foreach ($data as $row): ?>
                    <tbody>
                        <tr>
                            <td>
                                <div><?= $row['nomor_telepon'] ?></div>
                                <div><?= $row['nama'] ?></div>
                                <div>Disconnect</div>
                            </td>
                            <td>
                                <div>Free</div>
                                <div>1000</div>
                                <div>31 jan 2025</div>
                            </td>
                            <td>
                                <button class="btn btn-primary btn-sm">Reconnect</button>
                                <button class="btn btn-danger btn-sm">Disconnect</button>
                                <button class="btn btn-secondary btn-sm">Order</button>
                                <button class="btn btn-dark btn-sm">Token</button>
                                <button class="btn btn-info btn-sm" onclick="openEditModal({id_device: <?= $row['id_device'] ?>, nama: '<?= $row['nama'] ?>', nomor_telepon: '<?= $row['nomor_telepon'] ?>', token: '<?= $row['token'] ?>'})">Edit</button>
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addDeviceModal" tabindex="-1" aria-labelledby="addDeviceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDeviceModalLabel">Add Device</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('device/save') ?>" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" id="nomor_telepon" name="nomor_telepon" required>
                    </div>
                    <div class="mb-3">
                        <label for="token" class="form-label">Token</label>
                        <input type="text" class="form-control" id="token" name="token" required>
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

<div class="modal fade" id="editDeviceModal" tabindex="-1" aria-labelledby="editDeviceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDeviceModalLabel">Edit Device</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('/device/edit') ?>" method="post">
                <input type="hidden" id="edit_id_device" name="id_device">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="edit_nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_nomor_telepon" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" id="edit_nomor_telepon" name="nomor_telepon" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_token" class="form-label">Token</label>
                        <input type="text" class="form-control" id="edit_token" name="token" required>
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
    function openEditModal(device) {
        document.getElementById('edit_id_device').value = device.id_device;
        document.getElementById('edit_nama').value = device.nama;
        document.getElementById('edit_nomor_telepon').value = device.nomor_telepon;
        document.getElementById('edit_token').value = device.token;
        new bootstrap.Modal(document.getElementById('editDeviceModal')).show();
    }
</script>

<!--Footer-->
<?= $this->include('footer') ?>
<!--End of Footer-->


<?= $this->endSection() ?>