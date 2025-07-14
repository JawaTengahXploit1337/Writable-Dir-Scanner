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

$foundDirs = [];
$error = '';
$inputDir = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputDir = rtrim($_POST['dir'], DIRECTORY_SEPARATOR);
    if (is_dir($inputDir)) {
        scanWritableDirs($inputDir, $foundDirs);
    } else {
        $error = "Direktori tidak valid: $inputDir";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Writable Directory Scanner</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f4;
            padding: 40px;
        }

        .container {
            background: #fff;
            padding: 30px;
            max-width: 700px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
        }

        h1 {
            margin-bottom: 20px;
            color: #333;
        }

        input[type="text"] {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            margin-top: 15px;
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error {
            color: #d8000c;
            background: #ffd2d2;
            padding: 10px;
            border-radius: 5px;
            margin-top: 15px;
        }

        .result {
            margin-top: 25px;
        }

        ul {
            list-style-type: none;
            padding-left: 0;
        }

        ul li {
            padding: 8px;
            border-bottom: 1px solid #eee;
            font-family: monospace;
        }

        code {
            background: #eee;
            padding: 2px 4px;
            border-radius: 4px;
        }

        .no-result {
            font-style: italic;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Writable Directory Scanner</h1>
        <form method="POST">
            <label for="dir">Masukkan path direktori awal:</label>
            <input type="text" name="dir" id="dir" placeholder="/var/www/html" value="<?= htmlspecialchars($inputDir) ?>" required>
            <input type="submit" value="Scan">
        </form>

        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$error): ?>
            <div class="result">
                <h2>Hasil scan dari <code><?= htmlspecialchars($inputDir) ?></code>:</h2>
                <?php if (empty($foundDirs)): ?>
                    <p class="no-result">Tidak ada direktori writable ditemukan.</p>
                <?php else: ?>
                    <ul>
                        <?php foreach ($foundDirs as $dir): ?>
                            <li><?= htmlspecialchars($dir) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
