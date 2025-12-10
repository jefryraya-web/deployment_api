<?php
echo "<pre>";
echo "=== API TEST (JSON Storage) ===\n\n";

// Test GET /api (status)
echo "Testing GET /api\n";
$ch = curl_init("http://deployment.test/api");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
echo "HTTP Status: " . $httpCode . "\n";
echo "Response: " . $response . "\n\n";

// Test POST /api/items
echo "Testing POST /api/items\n";
$ch = curl_init("http://deployment.test/api/items");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    "title" => "Test Item",
    "content" => "Test Content"
]));
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
echo "HTTP Status: " . $httpCode . "\n";
echo "Response: " . $response . "\n\n";

// Test GET /api/items
echo "Testing GET /api/items\n";
$ch = curl_init("http://deployment.test/api/items");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
echo "HTTP Status: " . $httpCode . "\n";
echo "Response: " . $response . "\n\n";

// Check data.json file
echo "=== DATA FILE ===\n";
$dataFile = __DIR__ . "/api/data.json";
if (file_exists($dataFile)) {
    echo "data.json exists: YES\n";
    echo "File size: " . filesize($dataFile) . " bytes\n";
    echo "Content:\n";
    echo file_get_contents($dataFile);
} else {
    echo "data.json exists: NO (will be created on first POST)\n";
}

echo "</pre>";
