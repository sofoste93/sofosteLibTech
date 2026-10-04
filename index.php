<?php

declare(strict_types=1);

use Sofoste\LibTech\Library;

require_once __DIR__ . '/src/Library.php';

$resources = require __DIR__ . '/data/resources.php';
$translations = require __DIR__ . '/src/translations.php';
$library = new Library($resources);

$requestedLanguage = (string) ($_GET['lang'] ?? 'en');
$language = array_key_exists($requestedLanguage, $translations) ? $requestedLanguage : 'en';
$text = $translations[$language];
$query = trim((string) ($_GET['q'] ?? ''));
$requestedCategory = (string) ($_GET['category'] ?? 'all');
$categories = ['all', 'technology', 'science', 'health', 'learning'];
$category = in_array($requestedCategory, $categories, true) ? $requestedCategory : 'all';
$visibleResources = $library->filter($query, $category);

function escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

?><!doctype html>
<html lang="<?= escape($language) ?>" data-theme="system">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="A curated, community-rooted library of trusted learning resources.">
    <meta name="theme-color" content="#174f3a">
    <title>Sofoste LibTech · Open knowledge</title>
    <link rel="icon" href="assets/logo.svg" type="image/svg+xml">
    <link rel="manifest" href="manifest.webmanifest">
    <link rel="stylesheet" href="assets/styles.css">
    <script>
        // Apply the saved theme before painting the page to avoid a flash.
        try { document.documentElement.dataset.theme = localStorage.getItem('libtech-theme') || 'system'; } catch (_) {}
    </script>
</head>
<body>
<a class="skip-link" href="#resources" data-i18n="skip"><?= escape($text['skip']) ?></a>

<header class="site-header">
    <a class="brand" href="./" aria-label="Sofoste LibTech home">
        <img src="assets/logo.svg" alt="" width="44" height="44">
        <span><strong>Sofoste</strong><small>LIBTECH</small></span>
    </a>
    <nav aria-label="Main navigation">
        <a href="#resources" data-i18n="explore"><?= escape($text['explore']) ?></a>
        <a href="#mission" data-i18n="about"><?= escape($text['about']) ?></a>
        <button class="nav-button" type="button" data-open-dialog="help-dialog" data-i18n="help"><?= escape($text['help']) ?></button>
        <button class="icon-button" type="button" data-open-dialog="settings-dialog" aria-label="<?= escape($text['settings']) ?>" title="<?= escape($text['settings']) ?>">
            <svg aria-hidden="true" viewBox="0 0 24 24"><path d="M12 8.6a3.4 3.4 0 1 0 0 6.8 3.4 3.4 0 0 0 0-6.8Zm8.1 4.8-1.8 1.1.1 2.1-2.5 1.5-1.8-1.1-1.9 1-0.1 2.1H9.2L9 18l-1.9-1-1.8 1.1-2.5-1.5.1-2.1-1.8-1.1v-2.9l1.8-1.1-.1-2.1 2.5-1.5 1.8 1.1L9 5.9l.2-2.1h2.9l.1 2.1 1.9 1 1.8-1.1 2.5 1.5-.1 2.1 1.8 1.1v2.9Z"/></svg>
        </button>
    </nav>
</header>

<main>
    <section class="hero">
        <div class="hero-copy">
            <p class="eyebrow" data-i18n="eyebrow"><?= escape($text['eyebrow']) ?></p>
            <h1 data-i18n="title"><?= escape($text['title']) ?></h1>
            <p class="hero-intro" data-i18n="intro"><?= escape($text['intro']) ?></p>
            <a class="primary-button" href="#resources" data-i18n="explore"><?= escape($text['explore']) ?><span aria-hidden="true">↓</span></a>
        </div>
        <div class="hero-art" aria-hidden="true">
            <div class="orb orb-one"></div><div class="orb orb-two"></div>
            <svg viewBox="0 0 520 420" role="presentation">
                <path class="vine" d="M261 370c-4-75 13-126 64-169 34-29 54-69 44-122"/>
                <path class="vine faint" d="M259 368c8-66-20-117-76-145-35-17-58-47-63-91"/>
                <path class="leaf" d="M327 204c29-43 72-51 113-32-17 48-59 66-113 32Z"/>
                <path class="leaf" d="M185 224c-44 2-76-24-87-66 48-9 87 14 87 66Z"/>
                <path class="leaf small" d="M367 126c-3-38 17-65 52-77 14 40-4 72-52 77Z"/>
                <path class="book" d="M126 292c54-12 99 3 135 43 36-40 81-55 135-43v89c-53-10-98 1-135 32-37-31-82-42-135-32v-89Z"/>
                <path class="book-line" d="M261 335v78M145 316c42-3 78 8 105 32M377 316c-42-3-78 8-105 32"/>
            </svg>
        </div>
    </section>

    <section class="library" id="resources" aria-labelledby="resources-title">
        <div class="section-heading">
            <div><p class="eyebrow">SOFOSTE COLLECTION 01</p><h2 id="resources-title" data-i18n="resources"><?= escape($text['resources']) ?></h2></div>
            <p class="result-count" aria-live="polite"><strong id="result-count"><?= count($visibleResources) ?></strong> <span id="result-label"><?= count($visibleResources) === 1 ? escape($text['result']) : escape($text['results']) ?></span></p>
        </div>

        <form class="filters" method="get" role="search" id="library-filters">
            <label class="search-field">
                <span class="sr-only" data-i18n="search"><?= escape($text['search']) ?></span>
                <svg aria-hidden="true" viewBox="0 0 24 24"><path d="m21 21-4.3-4.3m2.3-5.2a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z"/></svg>
                <input type="search" name="q" value="<?= escape($query) ?>" placeholder="<?= escape($text['placeholder']) ?>" data-i18n-placeholder="placeholder" autocomplete="off">
            </label>
            <div class="category-tabs" aria-label="Resource categories">
                <?php foreach ($categories as $item): ?>
                    <button type="submit" name="category" value="<?= $item ?>" class="category-tab<?= $category === $item ? ' active' : '' ?>" data-category="<?= $item ?>" data-i18n="<?= $item ?>"><?= escape($text[$item]) ?></button>
                <?php endforeach; ?>
            </div>
            <input type="hidden" name="lang" value="<?= escape($language) ?>" id="language-input">
        </form>

        <div class="resource-grid" id="resource-grid">
            <?php foreach ($resources as $resource): ?>
                <?php $isVisible = in_array($resource, $visibleResources, true); ?>
                <article class="resource-card" data-resource-id="<?= escape($resource['id']) ?>" data-category="<?= escape($resource['category']) ?>" data-search="<?= escape(implode(' ', [$resource['title'], $resource['description'], $resource['provider'], implode(' ', $resource['tags'])])) ?>"<?= $isVisible ? '' : ' hidden' ?>>
                    <div class="card-topline"><span class="category-label" data-i18n="<?= escape($resource['category']) ?>"><?= escape($text[$resource['category']]) ?></span><button class="save-button" type="button" aria-pressed="false" data-save="<?= escape($resource['id']) ?>"><span aria-hidden="true">◇</span><span data-i18n="save"><?= escape($text['save']) ?></span></button></div>
                    <h3><?= escape($resource['title']) ?></h3>
                    <p><?= escape($resource['description']) ?></p>
                    <div class="tags"><span data-i18n="level_<?= escape($resource['level']) ?>"><?= escape($text['level_' . $resource['level']]) ?></span><span><?= escape($resource['provider']) ?></span></div>
                    <a href="<?= escape($resource['url']) ?>" target="_blank" rel="noopener noreferrer"><span data-i18n="open"><?= escape($text['open']) ?></span><span aria-hidden="true">↗</span></a>
                </article>
            <?php endforeach; ?>
        </div>
        <div class="empty-state" id="empty-state"<?= $visibleResources === [] ? '' : ' hidden' ?>><span>⌁</span><p data-i18n="empty"><?= escape($text['empty']) ?></p><button type="button" class="text-button" id="clear-filters" data-i18n="clear"><?= escape($text['clear']) ?></button></div>
    </section>

    <section class="mission" id="mission">
        <p class="eyebrow">MANGWA · ABAKWA · EVERYWHERE</p>
        <h2 data-i18n="mission_title"><?= escape($text['mission_title']) ?></h2>
        <p data-i18n="mission_text"><?= escape($text['mission_text']) ?></p>
        <div class="mission-values"><span>01 <b>Curated</b></span><span>02 <b>Open</b></span><span>03 <b>Human</b></span></div>
    </section>
</main>

<footer><a class="brand compact" href="./"><img src="assets/logo.svg" alt="" width="32" height="32"><strong>Sofoste LibTech</strong></a><p data-i18n="footer"><?= escape($text['footer']) ?></p><p>© <?= date('Y') ?> Sofoste</p></footer>

<dialog id="settings-dialog">
    <form method="dialog" class="dialog-card"><div class="dialog-heading"><h2 data-i18n="settings"><?= escape($text['settings']) ?></h2><button class="icon-button" value="close" aria-label="<?= escape($text['close']) ?>">×</button></div>
        <label><span data-i18n="language"><?= escape($text['language']) ?></span><select id="language-select"><option value="en">English</option><option value="fr">Français</option></select></label>
        <fieldset><legend data-i18n="theme"><?= escape($text['theme']) ?></legend><div class="segmented"><button type="button" data-theme-choice="light" data-i18n="light"><?= escape($text['light']) ?></button><button type="button" data-theme-choice="dark" data-i18n="dark"><?= escape($text['dark']) ?></button><button type="button" data-theme-choice="system" data-i18n="system"><?= escape($text['system']) ?></button></div></fieldset>
        <label class="toggle"><span data-i18n="motion"><?= escape($text['motion']) ?></span><input type="checkbox" id="reduce-motion"><span class="toggle-track"></span></label>
    </form>
</dialog>

<dialog id="help-dialog"><form method="dialog" class="dialog-card"><div class="dialog-heading"><h2 data-i18n="help_title"><?= escape($text['help_title']) ?></h2><button class="icon-button" value="close" aria-label="<?= escape($text['close']) ?>">×</button></div><p data-i18n="help_text"><?= escape($text['help_text']) ?></p><div class="privacy-note"><span aria-hidden="true">✓</span><p data-i18n="privacy"><?= escape($text['privacy']) ?></p></div><button class="primary-button full" value="close" data-i18n="close"><?= escape($text['close']) ?></button></form></dialog>

<script id="translations" type="application/json"><?= json_encode($translations, JSON_HEX_TAG | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?></script>
<script src="assets/app.js" defer></script>
</body>
</html>
