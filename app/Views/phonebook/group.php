<?= $this->extend('template/layout') ?>

<?= $this->section('title') ?>
    <title>Tefa IT - Group</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Group List</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Group Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Group</h6>
            </div>
            <div class="card-body">
                <a href="<?= base_url('phonebook/tambah_group') ?>" class="btn btn-success btn-icon-split btn-sm">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Tambah Group</span>
                </a>
                <p>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Grup</th>
                                <th>Contact(s)</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($groups)): 
                                $no = 1;
                                foreach ($groups as $group): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= htmlspecialchars($group['nama_grup'], ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?= $group['jumlah_kontak']; ?></td>
                                        <td>
                                            <button class="btn btn-primary btn-sm" onclick="openModal(<?= $group['id_group'] ?>)">
                                                <i class="fas fa-info-circle"></i> Detail
                                            </button>
                                            <button class="btn btn-warning btn-sm" onclick='openEditModal(<?= json_encode($group['id_group']) ?>, <?= json_encode($group['nama_grup']) ?>)'>
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <form action="<?= base_url('phonebook/hapus_group') ?>" method="post" style="display:inline;">
                                                <input type="hidden" name="id_group" value="<?= $group['id_group'] ?>">
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus grup ini?')">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">No groups available.</td>
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

<!-- Modal Detail --> 
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true"> 
    <div class="modal-dialog" role="document"> 
        <div class="modal-content"> 
            <div class="modal-header"> 
                <h5 class="modal-title" id="detailModalLabel">Detail Grup</h5> 
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> 
            </div> 
            <div class="modal-body"> 
                <table class="table table-bordered"> 
                    <thead> 
                        <tr> 
                            <th>No</th> 
                            <th>No Telp</th> 
                            <th>Nama</th> 
                            <th>Variable</th> 
                        </tr> 
                    </thead> 
                    <tbody id="modalBodyContent"> 
                        <!-- Konten modal akan diisi secara dinamis --> 
                    </tbody> 
                </table> 
            </div> 
            <div class="modal-footer"> 
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> 
            </div> 
        </div> 
    </div> 
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <div class="form-group">
                        <label for="groupName">Nama Grup</label>
                        <input type="text" class="form-control" id="groupName" name="nama_grup" required> 
                    </div>
                    <input type="hidden" id="groupId" name="id_group">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openModal(idGroup) {
        // Bersihkan konten modal
        document.getElementById('modalBodyContent').innerHTML = '';

        // Ambil data anggota grup berdasarkan id_group
        fetch('<?= base_url('phonebook/get_group_details') ?>/' + idGroup)
            .then(response => response.json())
            .then(data => {
                console.log(data); // Log untuk debugging
                let modalContent = '';
                let no = 1;
                
                if (data.length > 0) {
                    data.forEach(member => {
                        modalContent += `<tr>
                                            <td>${no++}</td>
                                            <td>${member.no_telp}</td>
                                            <td>${member.nama}</td>
                                            <td>${member.variable}</td>
                                         </tr>`;
                    });
                } else {
                    modalContent = '<tr><td colspan="4" class="text-center">No members available.</td></tr>';
                }
                
                document.getElementById('modalBodyContent').innerHTML = modalContent;
                
                // Buka modal
                $('#detailModal').modal('show');
            })
            .catch(error => console.error('Error:', error));
    }
</script>

<script>
    function openEditModal(idGroup, namaGrup) {
        // Log data untuk debugging
        console.log('idGroup:', idGroup, 'namaGrup:', namaGrup);

        // Isi form dengan data grup yang dipilih
        document.getElementById('groupId').value = idGroup;
        document.getElementById('groupName').value = namaGrup;

        // Buka modal
        $('#editModal').modal('show');
    }

    document.getElementById('editForm').addEventListener('submit', function(event) {
        event.preventDefault();

        // Ambil data dari form
        const formData = new FormData(this);

        // Kirim data ke server
        fetch('<?= base_url('phonebook/edit_group') ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Tutup modal dan refresh halaman
                $('#editModal').modal('hide');
                location.reload();
            } else {
                // Tampilkan pesan error
                alert('Gagal mengubah nama grup');
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>

<?= $this->endSection() ?>
