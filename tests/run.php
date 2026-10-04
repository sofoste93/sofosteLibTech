<?php

declare(strict_types=1);

use Sofoste\LibTech\Library;

require_once dirname(__DIR__) . '/src/Library.php';

$root = dirname(__DIR__);
$resources = require $root . '/data/resources.php';
$translations = require $root . '/src/translations.php';
$library = new Library($resources);
$failures = [];

function check(bool $condition, string $message): void
{
    global $failures;
    if (!$condition) {
        $failures[] = $message;
    }
}

check(count($library->all()) >= 8, 'The catalogue should contain at least eight resources.');
check(count($library->filter('PHP')) === 1, 'Search should be case-insensitive.');
check(count($library->filter('', 'health')) === 2, 'Category filtering should return health resources.');
check($library->filter('does-not-exist') === [], 'Unknown searches should return an empty list.');

$ids = [];
foreach ($resources as $resource) {
    check(!isset($ids[$resource['id']]), 'Resource IDs must be unique: ' . $resource['id']);
    $ids[$resource['id']] = true;
    check(filter_var($resource['url'], FILTER_VALIDATE_URL) !== false, 'Invalid URL: ' . $resource['url']);
    check(str_starts_with($resource['url'], 'https://'), 'Resources must use HTTPS: ' . $resource['url']);
}

check(array_keys($translations['en']) === array_keys($translations['fr']), 'English and French translation keys must match.');

$_GET = ['q' => '<script>', 'category' => 'invalid', 'lang' => 'invalid'];
ob_start();
require $root . '/index.php';
$html = (string) ob_get_clean();
check(str_contains($html, '<!doctype html>'), 'The application should render a complete HTML document.');
check(!str_contains($html, 'value="<script>"'), 'Query values must be escaped in HTML.');

if ($failures !== []) {
    fwrite(STDERR, implode("\n", array_map(static fn (string $failure): string => 'FAIL: ' . $failure, $failures)) . "\n");
    exit(1);
}

echo "All " . (count($resources) + 7) . " checks passed.\n";

