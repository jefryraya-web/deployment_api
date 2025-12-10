<?php
// Router untuk Laragon
$requestUri = $_SERVER['REQUEST_URI'];
$scriptName = $_SERVER['SCRIPT_NAME'];

// Parse URI
$uri = parse_url($requestUri, PHP_URL_PATH);

// Normalize
$uri = str_replace($scriptName, '', $uri);
$uri = '/' . trim($uri, '/');

// ============================================
// SANGAT PENTING: Handle /api first!
// ============================================
if (strpos($uri, '/api') === 0) {
    // Muat API handler
    require __DIR__ . '/api/index.php';
    exit; // HARUS exit setelah api dipanggil
}

// ============================================
// Serve static files dari public
// ============================================
if ($uri !== '/' && $uri !== '') {
    $filePath = __DIR__ . '/public' . $uri;
    
    if (file_exists($filePath) && is_file($filePath)) {
        // Set MIME type
        $ext = pathinfo($filePath, PATHINFO_EXTENSION);
        $mimeTypes = [
            'html' => 'text/html; charset=utf-8',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'svg' => 'image/svg+xml',
        ];
        
        $mime = $mimeTypes[$ext] ?? 'application/octet-stream';
        header('Content-Type: ' . $mime);
        readfile($filePath);
        exit;
    }
}

// ============================================
// Fallback ke index.html untuk SPA
// ============================================
$indexPath = __DIR__ . '/public/index.html';
if (file_exists($indexPath)) {
    header('Content-Type: text/html; charset=utf-8');
    readfile($indexPath);
    exit;
}

// ============================================
// 404
// ============================================
http_response_code(404);
echo "404 Not Found";
exit;
