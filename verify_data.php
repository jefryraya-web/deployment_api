<?php
echo "<pre>";
echo "=== DATA VERIFICATION ===\n\n";

// Check data.json
$dataFile = __DIR__ . "/api/data.json";
echo "Data file location: " . $dataFile . "\n";
echo "Data file exists: " . (file_exists($dataFile) ? "YES" : "NO") . "\n";

if (file_exists($dataFile)) {
    echo "File size: " . filesize($dataFile) . " bytes\n";
    echo "File readable: " . (is_readable($dataFile) ? "YES" : "NO") . "\n";
    echo "\nFile content:\n";
    echo "=====================================\n";
    $content = file_get_contents($dataFile);
    echo $content;
    echo "\n=====================================\n";
    
    echo "\nParsed as JSON:\n";
    $data = json_decode($content, true);
    if ($data) {
        echo "Total items: " . count($data) . "\n";
        foreach ($data as $item) {
            echo "  - ID: {$item['id']}, Title: {$item['title']}\n";
        }
    } else {
        echo "ERROR: Invalid JSON\n";
    }
} else {
    echo "No data file yet (will be created on first POST)\n";
}

echo "</pre>";
