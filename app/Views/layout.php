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
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">

            <?= $this->renderSection('content') ?>
        </div>

    </div>
</div>
</body>
</html>