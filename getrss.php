<?php
declare(strict_types=1);

// FeedsReader - secure, cached RSS backend.
// Allowed feed keys mapped to their canonical (prefer HTTPS) URLs.
const FEEDS = [
    'LaNacion'   => 'https://contenidos.lanacion.com.ar/herramientas/rss-origen=2',
    'Iprofesional' => 'https://www.iprofesional.com/rss/home',
    'Infobae'    => 'https://www.infobae.com/arc/outboundfeeds/rss/',
    'BBC'        => 'https://feeds.bbci.co.uk/mundo/rss.xml',
    'MuyInt'     => 'https://feeds2.feedburner.com/Muyinteresantees',
    'MuyComputer'=> 'https://www.muycomputer.com/feed/',
    'TechCrunch' => 'https://techcrunch.com/feed/',
    'FayerWayer' => 'https://www.fayerwayer.com/arc/outboundfeeds/rss/',
    'ClimaCba'   => 'https://xml.tutiempo.net/rss/42926.xml',
    'ClimaR4'    => 'https://xml.tutiempo.net/rss/31019.xml',
    'ClimaVT'    => 'https://xml.tutiempo.net/rss/43412.xml',
    'ClimaJN'    => 'https://xml.tutiempo.net/rss/43074.xml',
    'OLE'        => 'https://www.ole.com.ar/rss/ultimas-noticias/',
];

const CACHE_DIR = __DIR__ . '/cache';
const CACHE_TTL = 600; // seconds
const REQUEST_TIMEOUT = 10; // seconds

header('Content-Type: text/html; charset=utf-8');

if (!isset($_GET['q']) || !is_string($_GET['q'])) {
    http_response_code(400);
    echo '<p class="error">Feed not specified.</p>';
    exit;
}

$q = trim($_GET['q']);
if (!array_key_exists($q, FEEDS)) {
    http_response_code(400);
    echo '<p class="error">Invalid feed.</p>';
    exit;
}

function fetchFeed(string $url): ?string
{
    if (!is_dir(CACHE_DIR) && !@mkdir(CACHE_DIR, 0777, true)) {
        return null;
    }
    $cacheFile = CACHE_DIR . '/' . md5($url) . '.cache';
    if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < CACHE_TTL) {
        return file_get_contents($cacheFile);
    }

    $data = tryCurl($url, true);
    if ($data === null) {
        // Some sites have cert/chain issues; retry without peer verification.
        $data = tryCurl($url, false);
    }

    if ($data === null) {
        return null;
    }

    @file_put_contents($cacheFile, $data);
    return $data;
}

function tryCurl(string $url, bool $verifyPeer): ?string
{
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL            => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => REQUEST_TIMEOUT,
        CURLOPT_CONNECTTIMEOUT => 5,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_MAXREDIRS      => 5,
        CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0 Safari/537.36',
        CURLOPT_SSL_VERIFYPEER => $verifyPeer,
        CURLOPT_SSL_VERIFYHOST => $verifyPeer ? 2 : 0,
    ]);
    $data = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($data === false || $httpCode < 200 || $httpCode >= 300) {
        return null;
    }
    return $data;
}

function escape(string $s): string
{
    return htmlspecialchars((string) $s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function printNews(string $link, string $title, string $description): void
{
    echo '<article class="news-item">';
    echo '<hr />';
    if ($link !== '') {
        echo '<a href="' . escape($link) . '" target="_blank" rel="noopener noreferrer">';
        echo '<h3>' . escape($title) . '</h3>';
        echo '</a>';
    } else {
        echo '<h3>' . escape($title) . '</h3>';
    }
    echo '<p>' . escape($description) . '</p>';
    echo '</article>';
}

function renderFeed(string $url): void
{
    $xml = fetchFeed($url);
    if ($xml === null || $xml === '') {
        echo '<p class="error">Unable to load feed.</p>';
        return;
    }
    libxml_use_internal_errors(true);
    $rss = simplexml_load_string($xml);
    if ($rss === false) {
        echo '<p class="error">Unable to parse feed.</p>';
        return;
    }

    $items = $rss->xpath('//item');
    if ($items === false || empty($items)) {
        echo '<p class="empty">No items found.</p>';
        return;
    }

    foreach ($items as $item) {
        $link  = (string) ($item->link  ?? '');
        $title = (string) ($item->title ?? '(no title)');
        $desc  = (string) ($item->description ?? '');
        // Strip leftover HTML from descriptions before re-escaping.
        $desc = strip_tags($desc);
        printNews($link, $title, $desc);
    }
}

$url = FEEDS[$q];
renderFeed($url);
