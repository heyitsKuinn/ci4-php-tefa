<!DOCTYPE html>
<html lang="en">
    <head>
    <?= $this->include('header') ?>
    </head>
<body id="page-top">

<div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <?= $this->include('sidebar') ?>
    </ul>

     <!-- Content Wrapper -->
     <div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">
        <!-- Topbar -->
        <?= $this->include('topbar') ?>
        <!-- End of Topbar -->

        <!-- Page Content -->
        <div class="container-fluid">
            <?= $this->renderSection('content') ?>
        </div>
    </div>
    <!-- End of Main Content -->

</div>
</body>
</html>