<?php require_once __DIR__ . '/includes/header.php'; ?>

<?php
$aspekList = $pdo->query("SELECT * FROM master_aspek ORDER BY nomor")->fetchAll(PDO::FETCH_ASSOC);
$grouped = [];
foreach ($aspekList as $a) { $grouped[$a['kategori']][] = $a; }
?>

<div class="card">
    <h2>➕ Formulir Observasi Pelaksanaan Pembelajaran Mendalam</h2>
    <form action="proses_tambah.php" method="POST" enctype="multipart/form-data">

        <div class="form-grid">
            <div><label>Nama Observer *</label><input type="text" name="nama_observer" required></div>
            <div><label>Asal Institusi</label><input type="text" name="asal_institusi"></div>
            <div><label>Tanggal Observasi *</label><input type="date" name="tanggal_observasi" required value="<?= date('Y-m-d') ?>"></div>
            <div><label>Nama Guru yang Diobservasi *</label><input type="text" name="nama_guru" required></div>
            <div><label>Mata Pelajaran</label><input type="text" name="mata_pelajaran"></div>
            <div><label>Fase/Semester</label><input type="text" name="fase_semester" placeholder="Contoh: Fase F / Semester 1"></div>
            <div><label>Unit Kerja</label><input type="text" name="unit_kerja"></div>
        </div>

        <p style="margin:20px 0 10px; font-weight:600; color:#1e3c72;">
            Berikan penilaian terhadap kegiatan Pembelajaran Mendalam yang digunakan oleh guru:
        </p>

        <?php foreach ($grouped as $kategori => $items): ?>
            <h3 class="kategori-title"><?= htmlspecialchars($kategori) ?></h3>
            <?php foreach ($items as $a): ?>
                <div class="aspek-row">
                    <div class="aspek-text"><strong><?= $a['nomor'] ?>.</strong> <?= htmlspecialchars($a['deskripsi']) ?></div>
                    <div class="aspek-options">
                        <label><input type="radio" name="hasil_<?= $a['id'] ?>" value="belum_terlihat" required> Belum Terlihat</label>
                        <label><input type="radio" name="hasil_<?= $a['id'] ?>" value="tidak_konsisten"> Terlihat Tidak Konsisten</label>
                        <label><input type="radio" name="hasil_<?= $a['id'] ?>" value="konsisten"> Terlihat Konsisten</label>
                    </div>
                    <input type="text" name="catatan_<?= $a['id'] ?>" placeholder="Catatan (opsional)" class="aspek-catatan">
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>

        <div style="margin-bottom:15px;">
            <label>Kelebihan kegiatan pembelajaran yang dilaksanakan guru</label>
            <textarea name="kelebihan"></textarea>
        </div>
        <div style="margin-bottom:15px;">
            <label>Hal yang perlu ditingkatkan dari kegiatan pembelajaran</label>
            <textarea name="peningkatan"></textarea>
        </div>
        <div style="margin-bottom:15px;">
            <label>Temuan menarik lainnya</label>
            <textarea name="temuan_menarik"></textarea>
        </div>
        <div style="margin-bottom:15px;">
            <label>Catatan tambahan</label>
            <textarea name="catatan"></textarea>
        </div>

        <div class="form-grid">
            <div><label>Dokumentasi Foto 1</label><input type="file" name="foto_1" accept="image/*"></div>
            <div><label>Dokumentasi Foto 2</label><input type="file" name="foto_2" accept="image/*"></div>
            <div><label>Dokumentasi Foto 3</label><input type="file" name="foto_3" accept="image/*"></div>
            <div><label>Dokumentasi Foto 4</label><input type="file" name="foto_4" accept="image/*"></div>
        </div>

        <button type="submit" class="btn btn-primary">💾 Simpan Hasil Observasi</button>
    </form>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
