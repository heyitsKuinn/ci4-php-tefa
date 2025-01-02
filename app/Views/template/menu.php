<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Main Feature
</div>

<!-- Nav Item - Dashboard -->
<li class="nav-item">
    <a class="nav-link" href="<?= base_url('dashboard') ?>">
        <i class="bi bi-house-door-fill"></i>
        <span>Dashboard</span>
    </a>
</li>

<!-- Nav Item - Device -->
<li class="nav-item">
    <a class="nav-link" href="<?= base_url('device') ?>">
        <i class="bi bi-pc-display"></i>
        <span>Device</span>
    </a>
</li>

<!-- Nav Item - Phonebook -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#phonebook-collapse" aria-expanded="false" aria-controls="phonebook-collapse">
        <i class="bi bi-journal-bookmark-fill"></i>
        <span>Phone Book</span>
    </a>
    <div id="phonebook-collapse" class="collapse" aria-labelledby="phonebook-collapse" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?= base_url('phonebook/contact') ?>"><i class="bi bi-phone-fill" style="margin-right: 8px;"></i>Contact</a>
            <a class="collapse-item" href="<?= base_url('phonebook/group') ?>"><i class="bi bi-people-fill" style="margin-right: 8px;"></i>Group</a>
            <a class="collapse-item" href="<?= base_url('phonebook/wa-group') ?>"><i class="bi bi-whatsapp" style="margin-right: 8px;"></i>WA Group</a>
        </div>
    </div>
</li>