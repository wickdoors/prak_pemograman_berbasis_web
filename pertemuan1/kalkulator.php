<?php
$hasil =null;
$pesan = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $a = (float) ($_POST['a'] ?? 0);
    $b = (float) ($_POST['b'] ?? 0);
    $operator = $_POST['operator'] ?? '+';

    switch($operator) {
        case '+':
            $hasil = $a + $b;
            break;
        case '-':
            $hasil = $a - $b;
            break;
        case '*':
            $hasil = $a * $b;
            break;
        case '/':
            if ($b == 0) {
            $pesan = 'pembagian dengan nol tidak di perbolehkan.';
            } else {
            $hasil = $a / $b;
            }
            break;
            default:
            $pesan = 'operartor tidak valid.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>kalkulator</title>
</head>
<body>
    <h1>kalkulator sederhana</h1>
    <form method="post">
        <input type="number" step="any" name="a"
        required>
        <select name="operator">
            <option>+</option>
            <option>-</option>
            <option>*</option>
            <option>/</option>
        </select>
        <input type="number" step="any" name="b"
        required>
        <button type="submit">hitung</button>
    </form>
    <?php if ($pesan): ?>
        <p><?= htmlspecialchars($pesan) ?></p>
        <?php elseif ($hasil !== null): ?>
        <p>hasil: <?=htmlspecialchars((string)$hasil) ?></p>
        <?php endif; ?>
</body>
</html>