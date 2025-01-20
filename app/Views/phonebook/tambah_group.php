<?= $this->extend('template/layout') ?>

<?= $this->section('title') ?>
    <title>Tefa IT - Tambah Group</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <form class="user" method="POST" action="<?= base_url('phonebook/tambah_group') ?>">
        <div class="mb-4">
            <label for="nama_grup" class="form-label">Nama Grup</label>
            <input type="text" name="nama_grup" id="nama_grup" class="form-control" placeholder="Masukkan nama grup.." required>
        </div>
        <div class="mb-4">
            <label for="contact" class="form-label">Contacts</label>
            <select name="contacts[]" id="contact" class="selectpicker form-control" multiple data-live-search="true">
                <?php if (!empty($contacts)): ?>
                    <?php foreach ($contacts as $contact): ?>
                        <option value="<?= $contact['id_kontak']; ?>"><?= $contact['nama']; ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary btn-sm">Simpan Data</button>
        <a href="<?= base_url('phonebook/group') ?>" class="btn btn-danger btn-sm">Batal</a>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('#contact').select2({
            placeholder: "Select contact",
            allowClear: true
        });
    });
</script>

<?= $this->endSection() ?>
