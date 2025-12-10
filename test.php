<?php
// Debug file
echo "PHP Version: " . phpversion() . "\n";
echo "SQLite3 enabled: " . (extension_loaded("pdo_sqlite") ? "YES" : "NO") . "\n";
echo "API Path: " . __DIR__ . "/api/db.sqlite" . "\n";

// Test PDO
try {
    $pdo = new PDO("sqlite:" . __DIR__ . "/api/db.sqlite");
    echo "Database connection: OK\n";
    
    // Test create table
    $pdo->exec("CREATE TABLE IF NOT EXISTS test (id INTEGER PRIMARY KEY, name TEXT)");
    echo "Table creation: OK\n";
} catch (Exception $e) {
    echo "Database error: " . $e->getMessage() . "\n";
}
