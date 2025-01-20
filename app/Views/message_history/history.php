<?= $this->extend('template/layout') ?>

<?= $this->section('title') ?>
    <title>Tefa IT - WhatsApp History</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Message History</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Contact Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">History</h6>
                <button id="filter-toggle" class="btn btn-secondary btn-sm">Show Filters</button>
            </div>
            <div id="filter-section" class="filter-section" style="display: none;">
                <div class="p-3">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="devices">Devices</label>
                            <select id="devices" class="form-control">
                                <option value="all">All</option>
                                <!-- Tambahkan opsi perangkat lainnya di sini -->
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="start-date">Start</label>
                            <input type="datetime-local" id="start-date" class="form-control">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="end-date">End</label>
                            <input type="datetime-local" id="end-date" class="form-control">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="status">Status</label>
                            <select id="status" class="form-control">
                                <option value="all">All</option>
                                <!-- Tambahkan opsi status lainnya di sini -->
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="target-search">Search for Target</label>
                            <input type="text" id="target-search" class="form-control" placeholder="input target">
                        </div>
                        <div class="col-md-4 mb-3 d-flex align-items-end">
                            <button id="filter-button" class="btn btn-primary w-100">Filter</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-end mb-3">
                    <button id="delete-selected" class="btn btn-sm btn-danger mr-2">Delete Selected</button>
                    <button id="delete-all" class="btn btn-sm btn-danger mr-2">Delete All</button>
                    <button id="download-button" class="btn btn-sm btn-success">Download</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Time</th>
                                <th>Device</th>
                                <th>Target</th>
                                <th>Contact</th>
                                <th>Type</th>
                                <th>Message</th>
                                <th>Url</th>
                                <th>Status</th>
                                <th>State</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="11" class="text-center">No message sent</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="total-data text-center mt-2">Total 0 data</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM Content Loaded'); // Pesan debug tambahan

        var filterToggle = document.getElementById('filter-toggle');
        var filterSection = document.getElementById('filter-section');

        if (filterToggle && filterSection) {
            filterToggle.addEventListener('click', function() {
                console.log('Button clicked!'); // Tambahkan pesan debug
                if (filterSection.style.display === 'none' || filterSection.style.display === '') {
                    filterSection.style.display = 'block';
                    filterToggle.textContent = 'Hide Filters';
                } else {
                    filterSection.style.display = 'none';
                    filterToggle.textContent = 'Show Filters';
                }
            });
        } else {
            console.log('Element not found!'); // Pesan debug untuk elemen tidak ditemukan
        }
    });
</script>

<?= $this->endSection() ?>
