<?php
echo "<pre>";

// 1. Check PHP version
echo "=== PHP INFO ===\n";
echo "PHP Version: " . phpversion() . "\n";
echo "OS: " . php_uname() . "\n";

// 2. Check extensions
echo "\n=== EXTENSIONS ===\n";
echo "PDO: " . (extension_loaded("PDO") ? "YES" : "NO") . "\n";
echo "PDO SQLite: " . (extension_loaded("pdo_sqlite") ? "YES" : "NO") . "\n";

// 3. Check folder permissions
echo "\n=== FOLDER PERMISSIONS ===\n";
$apiFolder = __DIR__ . "/api";
echo "API Folder exists: " . (is_dir($apiFolder) ? "YES" : "NO") . "\n";
echo "API Folder writable: " . (is_writable($apiFolder) ? "YES" : "NO") . "\n";

// 4. Try to create database
echo "\n=== DATABASE TEST ===\n";
try {
    $dbFile = $apiFolder . "/db.sqlite";
    
    // Remove old database
    if (file_exists($dbFile)) {
        unlink($dbFile);
        echo "Old database removed\n";
    }
    
    // Create new connection
    $pdo = new PDO("sqlite:" . $dbFile);
    echo "Database connection: OK\n";
    echo "Database file: " . $dbFile . "\n";
    echo "Database file exists: " . (file_exists($dbFile) ? "YES" : "NO") . "\n";
    
    // Create table
    $pdo->exec("CREATE TABLE IF NOT EXISTS items (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT NOT NULL,
        content TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
    echo "Table created: OK\n";
    
    // Test insert
    $stmt = $pdo->prepare("INSERT INTO items (title, content) VALUES (?, ?)");
    $stmt->execute(["Test Title", "Test Content"]);
    $id = $pdo->lastInsertId();
    echo "Test insert: OK (ID: $id)\n";
    
    // Test select
    $result = $pdo->query("SELECT * FROM items")->fetchAll(PDO::FETCH_ASSOC);
    echo "Test select: OK (Count: " . count($result) . ")\n";
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}

// 5. Check API error log
echo "\n=== ERROR LOG ===\n";
$errorLog = $apiFolder . "/error.log";
if (file_exists($errorLog)) {
    echo "Error log found. Last 20 lines:\n";
    $lines = file($errorLog);
    $last20 = array_slice($lines, -20);
    foreach ($last20 as $line) {
        echo $line;
    }
} else {
    echo "No error log found yet\n";
}

echo "</pre>";
