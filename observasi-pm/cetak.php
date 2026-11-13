<?php
require_once __DIR__ . '/config/database.php';

$id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("SELECT * FROM observasi WHERE id = ?");
$stmt->execute([$id]);
$obs = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$obs) { die("Data observasi tidak ditemukan."); }

$stmtDetail = $pdo->prepare("
    SELECT d.hasil, d.catatan, a.nomor, a.kategori, a.deskripsi
    FROM observasi_detail d
    JOIN master_aspek a ON d.aspek_id = a.id
    WHERE d.observasi_id = ?
    ORDER BY a.nomor
");
$stmtDetail->execute([$id]);
$detail = $stmtDetail->fetchAll(PDO::FETCH_ASSOC);

$grouped = [];
foreach ($detail as $d) { $grouped[$d['kategori']][] = $d; }

function cek($hasil, $target) { return $hasil === $target ? '✓' : ''; }
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Cetak Observasi - <?= htmlspecialchars($obs['nama_guru']) ?></title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body class="print-page">

<div class="print-toolbar no-print">
    <button onclick="window.print()" class="btn btn-primary">🖨️ Cetak Halaman Ini</button>
    <a href="index.php" class="btn btn-outline">← Kembali ke Daftar</a>
</div>

<div class="print-sheet">
    <h1 class="print-title">INSTRUMEN OBSERVASI</h1>
    <h2 class="print-subtitle">PELAKSANAAN PEMBELAJARAN MENDALAM</h2>

    <table class="print-info">
        <tr><td class="label">Nama Observer</td><td>: <?= htmlspecialchars($obs['nama_observer']) ?></td></tr>
        <tr><td class="label">Asal Institusi</td><td>: <?= htmlspecialchars($obs['asal_institusi']) ?></td></tr>
        <tr><td class="label">Tanggal Observasi</td><td>: <?= date('d F Y', strtotime($obs['tanggal_observasi'])) ?></td></tr>
        <tr><td class="label">Nama Guru yang Diobservasi</td><td>: <strong><?= htmlspecialchars($obs['nama_guru']) ?></strong></td></tr>
        <tr><td class="label">Mata Pelajaran</td><td>: <?= htmlspecialchars($obs['mata_pelajaran']) ?></td></tr>
        <tr><td class="label">Fase/Semester</td><td>: <?= htmlspecialchars($obs['fase_semester']) ?></td></tr>
        <tr><td class="label">Unit Kerja</td><td>: <?= htmlspecialchars($obs['unit_kerja']) ?></td></tr>
    </table>

    <p class="instruksi">Tanda centang (✓) menunjukkan hasil observasi kegiatan Pembelajaran Mendalam oleh guru.</p>

    <table class="print-table">
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Aspek yang Diamati</th>
                <th colspan="3">Hasil Observasi</th>
                <th rowspan="2">Catatan</th>
            </tr>
            <tr>
                <th>Belum<br>Terlihat</th>
                <th>Terlihat Tidak<br>Konsisten</th>
                <th>Terlihat<br>Konsisten</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($grouped as $kategori => $items): ?>
            <tr class="kategori-row"><td colspan="6"><strong><?= htmlspecialchars($kategori) ?></strong></td></tr>
            <?php foreach ($items as $d): ?>
                <tr>
                    <td class="center"><?= $d['nomor'] ?></td>
                    <td class="aspek-cell"><?= nl2br(htmlspecialchars($d['deskripsi'])) ?></td>
                    <td class="center"><?= cek($d['hasil'],'belum_terlihat') ?></td>
                    <td class="center"><?= cek($d['hasil'],'tidak_konsisten') ?></td>
                    <td class="center"><?= cek($d['hasil'],'konsisten') ?></td>
                    <td><?= htmlspecialchars($d['catatan']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="print-essay">
        <p><strong>Kelebihan kegiatan pembelajaran yang dilaksanakan guru:</strong></p>
        <p class="essay-text"><?= nl2br(htmlspecialchars($obs['kelebihan'] ?: '-')) ?></p>

        <p><strong>Hal yang perlu ditingkatkan:</strong></p>
        <p class="essay-text"><?= nl2br(htmlspecialchars($obs['peningkatan'] ?: '-')) ?></p>

        <p><strong>Temuan menarik lainnya:</strong></p>
        <p class="essay-text"><?= nl2br(htmlspecialchars($obs['temuan_menarik'] ?: '-')) ?></p>

        <p><strong>Catatan:</strong></p>
        <p class="essay-text"><?= nl2br(htmlspecialchars($obs['catatan'] ?: '-')) ?></p>
    </div>

    <?php
    $fotos = array_filter([$obs['foto_1'], $obs['foto_2'], $obs['foto_3'], $obs['foto_4']]);
    if ($fotos): ?>
    <div class="print-dokumentasi">
        <p><strong>Dokumentasi Kegiatan Pembelajaran:</strong></p>
        <div class="foto-grid">
            <?php foreach ($fotos as $f): ?>
                <img src="<?= htmlspecialchars($f) ?>" alt="Dokumentasi">
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <div class="print-signature">
        <div class="signature-box">
            <p>Mengetahui,</p>
            <p>Guru yang Diobservasi</p>
            <div class="signature-space"></div>
            <p><strong><?= htmlspecialchars($obs['nama_guru']) ?></strong></p>
        </div>
        <div class="signature-box">
            <p><?= htmlspecialchars($obs['unit_kerja']) ?>, <?= date('d F Y', strtotime($obs['tanggal_observasi'])) ?></p>
            <p>Observer</p>
            <div class="signature-space"></div>
            <p><strong><?= htmlspecialchars($obs['nama_observer']) ?></strong></p>
        </div>
    </div>
</div>

</body>
</html>
