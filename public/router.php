<?php

/**
 * Laravel Router Script for PHP Built-in Server (Railway deployment)
 * Serves static files directly, and routes everything else to index.php
 */
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Serve static files directly (CSS, JS, images, fonts, etc.)
if ($uri !== '/' && file_exists(__DIR__ . $uri)) {
    // Set correct content-type for common static assets
    $ext = strtolower(pathinfo($uri, PATHINFO_EXTENSION));
    $mimes = [
        'css'   => 'text/css',
        'js'    => 'application/javascript',
        'mjs'   => 'application/javascript',
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
    ];
    if (isset($mimes[$ext])) {
        header('Content-Type: ' . $mimes[$ext]);
    }
    return false; // Serve the file as-is
}

// Route everything else through Laravel
require_once __DIR__ . '/index.php';
