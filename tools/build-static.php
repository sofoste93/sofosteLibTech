<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$output = $root . '/dist';

if (is_dir($output)) {
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($output, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );
    foreach ($iterator as $item) {
        $item->isDir() ? rmdir($item->getPathname()) : unlink($item->getPathname());
    }
    rmdir($output);
}

mkdir($output . '/assets', 0777, true);
$_GET = [];
ob_start();
require $root . '/index.php';
$html = (string) ob_get_clean();
file_put_contents($output . '/index.html', $html);

foreach (['app.js', 'styles.css', 'logo.svg'] as $asset) {
    copy($root . '/assets/' . $asset, $output . '/assets/' . $asset);
}
foreach (['manifest.webmanifest', 'service-worker.js'] as $file) {
    copy($root . '/' . $file, $output . '/' . $file);
}

echo "Static site written to dist/\n";

