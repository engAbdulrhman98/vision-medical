<?php

/**
 * Laravel Router Script for PHP Built-in Server (Railway deployment)
 * Uses readfile() for explicit static file serving instead of return false
 */
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Serve static files directly using readfile() for reliability
if ($uri !== '/' && $uri !== '' && file_exists(__DIR__ . $uri) && is_file(__DIR__ . $uri)) {
    $ext = strtolower(pathinfo($uri, PATHINFO_EXTENSION));
    $mimes = [
        'css'   => 'text/css; charset=utf-8',
        'js'    => 'application/javascript; charset=utf-8',
        'mjs'   => 'application/javascript; charset=utf-8',
        'woff'  => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf'   => 'font/ttf',
        'eot'   => 'application/vnd.ms-fontobject',
        'svg'   => 'image/svg+xml',
        'png'   => 'image/png',
        'jpg'   => 'image/jpeg',
        'jpeg'  => 'image/jpeg',
        'gif'   => 'image/gif',
        'ico'   => 'image/x-icon',
        'webp'  => 'image/webp',
        'json'  => 'application/json',
        'map'   => 'application/json',
        'txt'   => 'text/plain',
        'xml'   => 'application/xml',
        'php'   => null, // Let PHP files fall through to execute
    ];

    // For PHP files, let them execute normally
    if ($ext === 'php') {
        require __DIR__ . $uri;
        exit;
    }

    if (isset($mimes[$ext])) {
        header('Content-Type: ' . $mimes[$ext]);
    }
    header('Cache-Control: public, max-age=31536000, immutable');
    header('Content-Length: ' . filesize(__DIR__ . $uri));
    readfile(__DIR__ . $uri);
    exit;
}

// Route everything else through Laravel
require_once __DIR__ . '/index.php';
