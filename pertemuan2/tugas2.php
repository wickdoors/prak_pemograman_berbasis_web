<?php
function statusKelulusan(float $ipk): string
{
    if ($ipk >= 3.80) return 'Dengan Pujian (Cumlaude)';
    if ($ipk >= 3.50) return 'Sangat Memuaskan';
    if ($ipk >= 3.00) return 'Memuaskan';
    return 'Perlu Peningkatan';
}

$mahasiswa = [
    'nim' => '4524210062',
    'nama' => 'muhammad fariz fahreza',
    'prodi' => 'Teknik Informatika',
    'semester' => 5,
    'ipk' => 3.85,
    'angkatan' => 2024,
    'status_keaktifan' => 'Aktif'
];
?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Biodata Mahasiswa</title>
    <!-- Modifikasi 2: Penambahan CSS styling agar Tampilan Bermakna & Rapi -->
</head>

<body>
    <div class="card">
        <h1>Biodata Mahasiswa</h1>

        <ul>
            <?php foreach ($mahasiswa as $kunci => $nilai): ?>
                <li>
                    <strong><?= ucfirst(str_replace('_', ' ', $kunci)) ?>:</strong> 
                    <?= htmlspecialchars($kunci === 'nama' ? ucwords((string)$nilai) : (string)$nilai) ?>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="predikat">
            Predikat: <?= statusKelulusan($mahasiswa['ipk']) ?>
        </div>
    </div>
</body>
</html>