CREATE DATABASE IF NOT EXISTS observasi_pm_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE observasi_pm_db;

CREATE TABLE IF NOT EXISTS observasi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_observer VARCHAR(100) NOT NULL,
    asal_institusi VARCHAR(150),
    tanggal_observasi DATE NOT NULL,
    nama_guru VARCHAR(100) NOT NULL,
    mata_pelajaran VARCHAR(100),
    fase_semester VARCHAR(50),
    unit_kerja VARCHAR(150),
    kelebihan TEXT,
    peningkatan TEXT,
    temuan_menarik TEXT,
    catatan TEXT,
    foto_1 VARCHAR(255),
    foto_2 VARCHAR(255),
    foto_3 VARCHAR(255),
    foto_4 VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS master_aspek (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nomor INT NOT NULL,
    kategori VARCHAR(100) NOT NULL,
    deskripsi TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS observasi_detail (
    id INT AUTO_INCREMENT PRIMARY KEY,
    observasi_id INT NOT NULL,
    aspek_id INT NOT NULL,
    hasil ENUM('belum_terlihat','tidak_konsisten','konsisten') NOT NULL,
    catatan VARCHAR(255),
    FOREIGN KEY (observasi_id) REFERENCES observasi(id) ON DELETE CASCADE,
    FOREIGN KEY (aspek_id) REFERENCES master_aspek(id)
);

INSERT INTO master_aspek (nomor, kategori, deskripsi) VALUES
(1,'Keselarasan','Implementasi pembelajaran di kelas selaras dengan perencanaan pembelajaran pada: kegiatan awal, kegiatan inti (memahami, mengaplikasi, merefleksi), dan kegiatan penutup pembelajaran.'),
(2,'Keselarasan','Pembelajaran menggambarkan adanya upaya tujuan pembelajaran dalam mencapai dimensi profil lulusan (DPL): selaras dengan perencanaan pembelajaran dan disesuaikan dengan konteks kebutuhan belajar siswa.'),
(3,'Implementasi Desain Pembelajaran','Strategi pembelajaran diimplementasikan sesuai dengan tujuan pembelajaran dan kebutuhan belajar murid untuk mencapai DPL.'),
(4,'Implementasi Desain Pembelajaran','Lingkungan pembelajaran menekankan integrasi antara ruang fisik, ruang virtual, dan budaya belajar untuk mendukung Pembelajaran Mendalam.'),
(5,'Implementasi Desain Pembelajaran','Terdapat mitra pembelajaran baik internal maupun eksternal dalam kegiatan pembelajaran.'),
(6,'Implementasi Desain Pembelajaran','Tersedianya sumber belajar digital yang beragam dalam mendukung pembelajaran yang lebih interaktif, kolaboratif, dan kontekstual.'),
(7,'Implementasi Pengalaman Belajar','Guru memfasilitasi kegiatan pembelajaran untuk saling memuliakan antara Guru-Murid, Murid-Guru, Murid-Murid yang tercermin dalam bahasa verbal dan nonverbal.'),
(8,'Implementasi Pengalaman Belajar','Guru memfasilitasi murid untuk memiliki kesadaran menjadi pembelajar yang aktif dan mampu meregulasi diri (kenyamanan, fokus, kesadaran berpikir, kesempatan memilih, keterlibatan strategi belajar, keterbukaan, keingintahuan).'),
(9,'Implementasi Pengalaman Belajar','Guru memfasilitasi murid dapat menerapkan pengetahuannya secara kontekstual, relevan dengan kehidupan nyata, dan bermanfaat untuk konteks baru.'),
(10,'Implementasi Pengalaman Belajar','Guru menciptakan suasana belajar yang positif, menyenangkan, menantang, dan memotivasi, dengan ruang untuk prakarsa dan kreativitas.'),
(11,'Implementasi Pengalaman Belajar','Guru memfasilitasi murid terlibat aktif mengonstruksi pengetahuan agar dapat memahami secara mendalam konsep/materi dari berbagai sumber dan konteks.'),
(12,'Implementasi Pengalaman Belajar','Guru memfasilitasi murid untuk mengaplikasi pemahaman secara kontekstual dalam kehidupan nyata sebagai bagian dari pendalaman pengetahuan.'),
(13,'Implementasi Pengalaman Belajar','Guru memfasilitasi murid mengevaluasi dan memaknai proses serta hasil dari tindakan/praktik nyata yang telah dilakukan, serta mengelola proses belajarnya secara mandiri.'),
(14,'Implementasi Pengalaman Belajar','Kegiatan pembelajaran mengakomodir pengalaman belajar yang sesuai dengan karakteristik murid, terutama tahapan berpikir murid.'),
(15,'Asesmen Pembelajaran','Guru mengimplementasikan asesmen awal untuk mendapatkan bukti kesiapan belajar secara emosional dan mental, pengetahuan awal, dan kebutuhan belajar murid.'),
(16,'Asesmen Pembelajaran','Guru menggunakan beragam teknik asesmen selama proses pembelajaran.'),
(17,'Asesmen Pembelajaran','Guru menggunakan asesmen di akhir pembelajaran dengan beragam cara (tes, portofolio, proyek, presentasi, dsb) yang selaras dengan tujuan pembelajaran.');
