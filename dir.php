<?php

function isWritableDir($dir) {
    return is_dir($dir) && is_writable($dir);
}

function scanWritableDirs($baseDir, &$results) {
    if (!is_readable($baseDir)) return;

    $items = scandir($baseDir);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        $fullPath = $baseDir . DIRECTORY_SEPARATOR . $item;
        if (is_dir($fullPath)) {
            if (isWritableDir($fullPath)) {
                $results[] = $fullPath;
            }
            scanWritableDirs($fullPath, $results);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputDir = rtrim($_POST['dir'], DIRECTORY_SEPARATOR);
    $foundDirs = [];

    if (is_dir($inputDir)) {
        scanWritableDirs($inputDir, $foundDirs);
        echo "<h2>Writable directories found under <code>$inputDir</code>:</h2>";
        if (empty($foundDirs)) {
            echo "<p><i>No writable directories found.</i></p>";
        } else {
            echo "<ul>";
            foreach ($foundDirs as $dir) {
                echo "<li>" . htmlspecialchars($dir) . "</li>";
            }
            echo "</ul>";
        }
    } else {
        echo "<p style='color:red;'>Invalid directory: <code>$inputDir</code></p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Directory Scanner</title>
</head>
<body>
    <h1>Writable Directory Scanner</h1>
    <form method="POST">
        <label for="dir">Masukkan path direktori awal:</label><br>
        <input type="text" name="dir" id="dir" style="width:400px;" placeholder="/var/www/html" required>
        <br><br>
        <input type="submit" value="Scan">
    </form>
</body>
</html>
