<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Default Title' ?></title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <header>
        <h1><?= isset($title) ? $title : 'Welcome!' ?></h1>
    </header>
    <main>
        <p><?= isset($content) ? $content : 'No content provided.' ?></p>
    </main>
    <footer>
        <p>Copyright © <?= date('Y') ?></p>
    </footer>
</body>
</html>
