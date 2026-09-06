<?php
date_default_timezone_set('Asia/Jakarta');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title><?= $title ?> &mdash; <?= $p_umum['title'] ?></title>
    <link rel="shortcut icon" href="<?= base_url('assets/images/' . $p_umum['favicon']) ?>" type="image/x-icon">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>modules/fontawesome/css/all.min.css">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>modules/summernote/summernote-bs4.css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>modules/jquery-selectric/selectric.css">

    <link rel="stylesheet" href="<?= base_url('assets/') ?>modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>css/style.css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>css/components.css">

</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <div class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
                    </ul>
                </div>
                <ul class="navbar-nav navbar-right">

                    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img alt="image" src="<?= base_url('assets') ?>/images/profiles/<?= $user['foto_profile'] ?>" class="rounded-circle mr-1">

                            <div class="d-sm-none d-lg-inline-block">Hi, <?= $user['nama'] ?></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <?php if ($user['role_id'] == 1) : ?>
                                <a href="<?= base_url('superadmin/profile') ?>" class="dropdown-item has-icon">
                                    <i class="far fa-user"></i> Profile
                                </a>
                            <?php elseif ($user['role_id'] == 2) : ?>
                                <a href="<?= base_url('admin/profile') ?>" class="dropdown-item has-icon">
                                    <i class="far fa-user"></i> Profile
                                </a>
                            <?php endif; ?>
                            <div class="dropdown-divider"></div>
                            <?php if ($user['role_id'] == 1) : ?>
                                <a href="<?= base_url('superadmin/logout') ?>" class="dropdown-item btn-logout has-icon text-danger">
                                    <i class="fas fa-sign-out-alt"></i> Keluar
                                </a>
                            <?php elseif ($user['role_id'] == 2) : ?>
                                <a href="<?= base_url('admin/logout') ?>" class="dropdown-item btn-logout has-icon text-danger">
                                    <i class="fas fa-sign-out-alt"></i> Keluar
                                </a>
                            <?php else : ?>

                            <?php endif; ?>
                        </div>
                    </li>
                </ul>
            </nav>