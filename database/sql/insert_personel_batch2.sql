-- Batch 2: nama, jabatan, ID personel (kode P...).
-- Nomor KTP 16 digit tidak dimasukkan.
-- ID personel disimpan di kolom nik (Nomor Id Karyawan).
-- Yang namanya sudah ada di-update, yang baru di-insert.
-- File ini sudah dijalankan di database local (jangan dijalankan ulang kecuali DB masih kosong).

UPDATE personel SET nik = 'P260601909', namapersonel = 'David Ladi Allolinggi', jabatan = 'Welder' WHERE namapersonel = 'Dafid Ladi A.';
UPDATE personel SET nik = 'P250409819', namapersonel = 'Dian Febriansyah', jabatan = 'HTW/HWC Technician' WHERE namapersonel = 'Dian Febriansyah';
UPDATE personel SET nik = 'P251118402', namapersonel = 'Eko Siantoro', jabatan = 'HTW/HWC Technician' WHERE namapersonel = 'Eko Siantoro';
UPDATE personel SET nik = 'P260200520', namapersonel = 'Hadi Bangbang', jabatan = 'General Equipment Technician' WHERE namapersonel = 'Hadi Bangbang S.';
UPDATE personel SET nik = 'P260606811', namapersonel = 'Saepudin (B)', jabatan = 'Fitter' WHERE namapersonel = 'Saepudin (B)';
UPDATE personel SET nik = 'P251118419', namapersonel = 'Sutriman', jabatan = 'HTW/HWC Technician' WHERE namapersonel = 'Sutriman';
UPDATE personel SET nik = 'P260406800', namapersonel = 'Syahrudin Nasution', jabatan = 'Fitter' WHERE namapersonel = 'Syahrudin Nasution';
UPDATE personel SET nik = 'P251101799', namapersonel = 'Yudhistira Galih Saputra', jabatan = 'General Equipment Technician' WHERE namapersonel = 'Yudhistira Galih Saputra';
UPDATE personel SET nik = 'P250314980', namapersonel = 'Azhar Permadi', jabatan = 'HTW/HWC Technician' WHERE namapersonel = 'Azhar Permadi';
UPDATE personel SET nik = 'P251118420', namapersonel = 'Galan Reza Ashari', jabatan = 'HTW/HWC Technician' WHERE namapersonel = 'Galan Reza Azhari';
UPDATE personel SET nik = 'P250114542', namapersonel = 'Rangga Arya Pratama', jabatan = 'HTW/HWC Technician' WHERE namapersonel = 'Rangga Arya Pratama';
UPDATE personel SET nik = 'P260215155', namapersonel = 'Rian Gading Perkasa', jabatan = 'Welder' WHERE namapersonel = 'Rian Gading Perkasa';
UPDATE personel SET nik = 'P260315634', namapersonel = 'Adiksa Arya Purnatama', jabatan = 'Welder' WHERE namapersonel = 'Adiksa Arya Purnatama';
UPDATE personel SET nik = 'P251118401', namapersonel = 'Ridho Kurniawan', jabatan = 'HTW/HWC Technician' WHERE namapersonel = 'Ridho Kurniawan';
UPDATE personel SET nik = 'P251018129', namapersonel = 'Viery Andriyanto', jabatan = 'HTW/HWC Technician' WHERE namapersonel = 'Viery Andriyanto';
UPDATE personel SET nik = 'P260609817', namapersonel = 'Agus Hernanto', jabatan = 'HTW/HWC Technician' WHERE namapersonel = 'Agus Hernanto';
UPDATE personel SET nik = 'P260618470', namapersonel = 'Sandi', jabatan = 'HTW/HWC Technician' WHERE namapersonel = 'Sandi';
UPDATE personel SET nik = 'P260415636', namapersonel = 'Ramses Lumban Gaol Marbun', jabatan = 'Fitter' WHERE namapersonel = 'Ramses L. Gaol';
UPDATE personel SET nik = 'P260705731', namapersonel = 'Agus Ginanjar', jabatan = 'Fitter' WHERE namapersonel = 'Agus Ginanjar';

INSERT INTO personel (nik, namapersonel, jabatan, created_at, updated_at) VALUES
('P260601900', 'Abdul Azis Hidayat', 'Rigger (Scaffolder)', NOW(), NOW()),
('P250900538', 'Abdullah Abdul Hamid', 'Fitter', NOW(), NOW()),
('P260304709', 'Adeswara Ramdhany', 'Safetyman', NOW(), NOW()),
('P260104633', 'Agung Andrianto', 'Rigger (Scaffolder)', NOW(), NOW()),
('P250104542', 'Agus Widodo', 'Rigger (Scaffolder)', NOW(), NOW()),
('P260205101', 'Agus Dwi Larso', 'Safetyman', NOW(), NOW()),
('P260606077', 'Agus Sutrisno', 'Welder', NOW(), NOW()),
('P250704214', 'Andiyanto Fajar Saputra', 'Fitter', NOW(), NOW()),
('P250104544', 'Aris Riyanto', 'Rigger (Scaffolder)', NOW(), NOW()),
('P260109623', 'Aseng Amoi Pandiangan', 'Rigger (Scaffolder)', NOW(), NOW()),
('P260700535', 'Budi Prasetyo', 'Blaster/Painter', NOW(), NOW()),
('P260706557', 'Budi Nurwanto', 'Fitter Foreman', NOW(), NOW()),
('P260604547', 'Bunyamin', 'Construction Supervisor', NOW(), NOW()),
('P250104548', 'Chaerul Anwar', 'Rigger (Scaffolder)', NOW(), NOW()),
('P260304549', 'Dadang Amor Kuswara', 'Safetyman', NOW(), NOW()),
('P260104550', 'Dedi Kodir', 'Rigger (Scaffolder) Foreman', NOW(), NOW()),
('P260706795', 'Deni Rochdjali', 'Welder', NOW(), NOW()),
('P250104579', 'Didik Marsudi', 'Rigger (Scaffolder) Foreman', NOW(), NOW()),
('P250104212', 'Elroy Samson Reinhold Butar Butar', 'Safety Officer', NOW(), NOW()),
('P260304551', 'Fae Buadodo Zalukhu', 'Rigger (Scaffolder)', NOW(), NOW()),
('P260304216', 'Febriyanto Firdaus', 'Safetyman', NOW(), NOW()),
('P260704213', 'Gudel Setyana', 'Safety Officer', NOW(), NOW()),
('P260604360', 'Hasuri', 'Welder', NOW(), NOW()),
('P260701921', 'Imam Trilistianto', 'Rigger (Scaffolder)', NOW(), NOW()),
('P251107333', 'Irfan Catur Santoso', 'Instrument Supervisor', NOW(), NOW()),
('P260204554', 'Iwan Parjianto', 'Rigger (Scaffolder)', NOW(), NOW()),
('P260310951', 'Jaedi', 'Welder', NOW(), NOW()),
('P260704941', 'Kholid', 'Fitter', NOW(), NOW()),
('P260205704', 'Kodir Jaelani', 'General Equipment Technician', NOW(), NOW()),
('P250604354', 'Lamtorang', 'Rigger (Scaffolder)', NOW(), NOW()),
('P250410346', 'M. Hidayat Nawawi', 'Instrument Technician', NOW(), NOW()),
('P260204556', 'Mantono', 'Rigger (Scaffolder) Foreman', NOW(), NOW()),
('P250706367', 'M. Hadi Arofi', 'General Equipment Technician', NOW(), NOW()),
('P250704356', 'Muhammad Yusuf Helmi', 'Rigger (Scaffolder)', NOW(), NOW()),
('P260700518', 'Muhammad Solikhin', 'Rigger (Scaffolder)', NOW(), NOW()),
('P260204710', 'Muhammad Husin', 'Radio Operator', NOW(), NOW()),
('P250706953', 'Muhamad Maliki', 'Instrument Supervisor', NOW(), NOW()),
('P250104561', 'Nulato Aji', 'Rigger (Scaffolder)', NOW(), NOW()),
('P260604364', 'Nur Iskandar', 'Rigger (Scaffolder)', NOW(), NOW()),
('P260604357', 'Nurfuad', 'Construction Supervisor', NOW(), NOW()),
('P260704365', 'Oki Priwibowo', 'Rigger (Scaffolder)', NOW(), NOW()),
('P260604376', 'Philip Susanto', 'Rigger (Scaffolder)', NOW(), NOW()),
('P260804377', 'Prasetyo Adi Nugroho', 'Rigger (Scaffolder)', NOW(), NOW()),
('P260601795', 'Prayoga Giananta', 'Safety Officer', NOW(), NOW()),
('P250201938', 'Raffy Vaturusi', 'General Equipment Technician', NOW(), NOW()),
('P260601939', 'Rahmat Hidayat Lubis', 'Fitter Foreman', NOW(), NOW()),
('P250600524', 'Ramli Sitorus', 'Fitter Foreman', NOW(), NOW()),
('P250104378', 'Ramly Adi Wibowo', 'Rigger (Scaffolder)', NOW(), NOW()),
('P260804379', 'Ranto Fajar Hutapea', 'Rigger (Scaffolder)', NOW(), NOW()),
('P250104382', 'Rofi''i Iriyanto', 'Rigger (Scaffolder) Foreman', NOW(), NOW()),
('P260601943', 'Roni Awaludin', 'Radio Operator', NOW(), NOW()),
('P260604384', 'Sabam Simbolon', 'Rigger (Scaffolder)', NOW(), NOW()),
('P260104385', 'Samsul Bahri', 'Rigger (Scaffolder)', NOW(), NOW()),
('P250104388', 'Sartono', 'Rigger (Scaffolder)', NOW(), NOW()),
('P260701946', 'Septian Deris Noer Pradana', 'Rigger (Scaffolder)', NOW(), NOW()),
('P260310575', 'Septo Wibowo', 'Fitter', NOW(), NOW()),
('P260604564', 'Sofyan Hadi Nugroho', 'Rigger (Scaffolder)', NOW(), NOW()),
('P260104389', 'Sugiyanto', 'Rigger (Scaffolder)', NOW(), NOW()),
('P260604390', 'Sujana', 'Rigger (Scaffolder)', NOW(), NOW()),
('P260804565', 'Sukamto', 'Rigger (Scaffolder)', NOW(), NOW()),
('P260701952', 'Sulaiman Welemuly', 'General Equipment Technician', NOW(), NOW()),
('P260104567', 'Sulistiono', 'Safetyman', NOW(), NOW()),
('P260318859', 'Sumanto', 'Construction Supervisor', NOW(), NOW()),
('P250104392', 'Sumbodo Pramestika Sektiyantoro', 'Safetyman', NOW(), NOW()),
('P260104417', 'Supriyanto', 'Blaster/Painter', NOW(), NOW()),
('P260304624', 'Suradi', 'Fitter', NOW(), NOW()),
('P260607314', 'Sutarman', 'Blaster/Painter', NOW(), NOW()),
('P250600534', 'Suyono', 'Fitter Foreman', NOW(), NOW()),
('P260104397', 'Syarifudin Afrianto', 'Welder', NOW(), NOW()),
('P260204571', 'Tamad', 'Welder', NOW(), NOW()),
('P260304735', 'Tedi Suswanto', 'General Equipment Technician', NOW(), NOW()),
('P260205390', 'Tua Marudut Pandiangan', 'Rigger (Scaffolder) Foreman', NOW(), NOW()),
('P260304736', 'Tubagus Rizki Febrian', 'Blaster/Painter', NOW(), NOW()),
('P260100217', 'Ucok Berry', 'General Equipment Technician', NOW(), NOW()),
('P250807084', 'Unggul Hananto', 'Fitter', NOW(), NOW()),
('P260404918', 'Warsito', 'Safetyman', NOW(), NOW()),
('P260101962', 'Wasimun', 'Blaster/Painter', NOW(), NOW()),
('P260604401', 'Wiyono', 'Construction Supervisor', NOW(), NOW()),
('P250114543', 'Tanu Manggala', 'HTW/HWC Technician', NOW(), NOW()),
('P251218469', 'Erdin Syamsudin', 'HTW/HWC Technician', NOW(), NOW()),
('P260618677', 'Abdillah Fajar Kusumah', 'HTW/HWC Technician', NOW(), NOW()),
('P251218635', 'Lindu Aji', 'HTW/HWC Technician', NOW(), NOW()),
('P251218651', 'Calvin Junarta Wibowo', 'HTW/HWC Technician', NOW(), NOW()),
('P260119005', 'Irfan Amrullah', 'Fitter', NOW(), NOW()),
('P251218634', 'Arik Prasetiya', 'HTW/HWC Technician', NOW(), NOW());
