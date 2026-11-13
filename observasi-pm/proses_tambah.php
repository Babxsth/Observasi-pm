<?php
require_once __DIR__ . '/config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: tambah_observasi.php');
    exit;
}

function uploadFoto($fieldName) {
    if (!empty($_FILES[$fieldName]['name']) && $_FILES[$fieldName]['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES[$fieldName]['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) return null;
        $dir = __DIR__ . '/uploads/dokumentasi';
        if (!is_dir($dir)) mkdir($dir, 0755, true);
        $newName = uniqid($fieldName . '_') . '.' . $ext;
        move_uploaded_file($_FILES[$fieldName]['tmp_name'], $dir . '/' . $newName);
        return 'uploads/dokumentasi/' . $newName;
    }
    return null;
}

$pdo->beginTransaction();
try {
    $stmt = $pdo->prepare("INSERT INTO observasi
        (nama_observer, asal_institusi, tanggal_observasi, nama_guru, mata_pelajaran, fase_semester, unit_kerja, kelebihan, peningkatan, temuan_menarik, catatan, foto_1, foto_2, foto_3, foto_4)
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

    $stmt->execute([
        trim($_POST['nama_observer']),
        trim($_POST['asal_institusi']),
        $_POST['tanggal_observasi'],
        trim($_POST['nama_guru']),
        trim($_POST['mata_pelajaran']),
        trim($_POST['fase_semester']),
        trim($_POST['unit_kerja']),
        trim($_POST['kelebihan']),
        trim($_POST['peningkatan']),
        trim($_POST['temuan_menarik']),
        trim($_POST['catatan']),
        uploadFoto('foto_1'),
        uploadFoto('foto_2'),
        uploadFoto('foto_3'),
        uploadFoto('foto_4')
    ]);

    $observasiId = $pdo->lastInsertId();

    $aspekList = $pdo->query("SELECT id FROM master_aspek")->fetchAll(PDO::FETCH_COLUMN);
    $stmtDetail = $pdo->prepare("INSERT INTO observasi_detail (observasi_id, aspek_id, hasil, catatan) VALUES (?,?,?,?)");

    foreach ($aspekList as $aspekId) {
        $hasil = $_POST['hasil_' . $aspekId] ?? null;
        $catatanAspek = trim($_POST['catatan_' . $aspekId] ?? '');
        if ($hasil) {
            $stmtDetail->execute([$observasiId, $aspekId, $hasil, $catatanAspek]);
        }
    }

    $pdo->commit();
    header('Location: index.php?sukses=1');
    exit;

} catch (Exception $e) {
    $pdo->rollBack();
    die("Gagal menyimpan data: " . $e->getMessage());
}
