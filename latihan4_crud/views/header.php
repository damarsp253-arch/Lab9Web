<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e($pageTitle); ?> - Aplikasi Data Barang</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="container">
    <header>
        <h1>Aplikasi Data Barang</h1>
        <p>CRUD PHP modular dengan template dan router</p>
    </header>
    <nav>
        <?php foreach ($menu as $rute => $teks): ?>
            <a href="index.php?page=<?php echo e($rute); ?>"<?php echo ($rute === $currentMenu) ? ' class="active"' : ''; ?>><?php echo e($teks); ?></a>
        <?php endforeach; ?>
    </nav>
    <main>
        <?php $flash = getFlash(); ?>
        <?php if ($flash): ?>
            <div class="alert alert-<?php echo e($flash['type']); ?>"><?php echo e($flash['text']); ?></div>
        <?php endif; ?>
