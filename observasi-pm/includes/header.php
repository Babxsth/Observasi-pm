<?php require_once __DIR__ . '/../config/database.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Instrumen Observasi Pembelajaran Mendalam</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="no-print">
    <div>
        <h1>📋 Instrumen Observasi Pembelajaran Mendalam</h1>
        <div class="subtitle">Rekam, kelola, dan cetak hasil observasi per guru</div>
    </div>
</header>
<div class="container">
<nav class="tabs no-print">
    <a href="index.php" class="tab-btn <?= basename($_SERVER['PHP_SELF'])=='index.php'?'active':'' ?>">📑 Daftar Observasi</a>
    <a href="tambah_observasi.php" class="tab-btn <?= basename($_SERVER['PHP_SELF'])=='tambah_observasi.php'?'active':'' ?>">➕ Observasi Baru</a>
</nav>
