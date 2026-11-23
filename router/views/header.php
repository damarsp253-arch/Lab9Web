<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e($pageTitle); ?> - Aplikasi PHP Modular</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="assets/css/router.css">
</head>
<body>
<div class="container">
    <header>
        <h1>Aplikasi PHP Modular</h1>
        <p>Contoh pemisahan template dan konten dengan router</p>
    </header>
    <nav>
        <?php foreach ($menu as $rute => $teks): ?>
            <a href="index.php?page=<?php echo e($rute); ?>"<?php echo ($rute === $currentPage) ? ' class="active"' : ''; ?>><?php echo e($teks); ?></a>
        <?php endforeach; ?>
    </nav>
    <main>