<?php require_once __DIR__ . '/includes/header.php'; ?>

<?php
$cari = $_GET['cari'] ?? '';
$stmt = $pdo->prepare("SELECT * FROM observasi WHERE nama_guru LIKE ? ORDER BY tanggal_observasi DESC");
$stmt->execute(['%' . $cari . '%']);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="card">
    <h2>📑 Daftar Hasil Observasi</h2>

    <?php if (isset($_GET['sukses'])): ?>
        <div class="alert-success">✅ Data observasi berhasil disimpan.</div>
    <?php endif; ?>

    <form method="GET" class="filter-bar">
        <input type="text" name="cari" placeholder="Cari nama guru yang diobservasi..." value="<?= htmlspecialchars($cari) ?>">
        <button type="submit" class="btn btn-outline">Cari</button>
    </form>

    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>Tanggal</th><th>Nama Guru Diobservasi</th><th>Mapel</th><th>Fase/Semester</th><th>Observer</th><th>Aksi</th></tr>
            </thead>
            <tbody>
            <?php if (empty($data)): ?>
                <tr><td colspan="6" style="text-align:center;color:#999;padding:30px;">Belum ada data observasi</td></tr>
            <?php else: foreach ($data as $d): ?>
                <tr>
                    <td><?= date('d M Y', strtotime($d['tanggal_observasi'])) ?></td>
                    <td><?= htmlspecialchars($d['nama_guru']) ?></td>
                    <td><?= htmlspecialchars($d['mata_pelajaran']) ?></td>
                    <td><?= htmlspecialchars($d['fase_semester']) ?></td>
                    <td><?= htmlspecialchars($d['nama_observer']) ?></td>
                    <td>
                        <a href="cetak.php?id=<?= $d['id'] ?>" class="btn btn-primary btn-sm" target="_blank">🖨️ Cetak</a>
                        <a href="hapus.php?id=<?= $d['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data observasi ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
