<?= $this->extend('template/layout') ?>

<?= $this->section('title') ?>
    <title>Tefa IT - WA Group</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">WhatsApp Group List</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Contact Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Device</h6>
                <a href="#" class="btn btn-sm btn-primary shadow-sm" id="updateButton"> 
                    <i class="fas fa-sync-alt fa-sm text-white-50"></i> Update List 
                </a>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <select name="device" id="device" class="form-select">
                        <option value="">Select Device</option>
                        <!-- Add device options here -->
                    </select>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($contacts)): ?>
                                <?php foreach ($contacts as $row): ?>
                                    <tr>
                                        <td><?= $row['id']; ?></td>
                                        <td><?= $row['name']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="2" class="text-center">No connected device.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
