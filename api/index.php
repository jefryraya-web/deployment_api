<?php
// PREVENT ANY OUTPUT BEFORE JSON!
ob_clean();

// Set error logging
ini_set("display_errors", 0);
ini_set("log_errors", 1);
ini_set("error_log", __DIR__ . "/error.log");

// Headers CORS - MUST BE BEFORE ANY OUTPUT
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Handle OPTION request
if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(204);
    exit();
}

// ===== DATA FILE =====
$dataFile = __DIR__ . "/data.json";

// Load data from JSON
function loadData() {
    global $dataFile;
    if (!file_exists($dataFile)) {
        return [];
    }
    $json = file_get_contents($dataFile);
    return json_decode($json, true) ?: [];
}

// Save data to JSON
function saveData($data) {
    global $dataFile;
    file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

// Get next ID
function getNextId($items) {
    if (empty($items)) return 1;
    $maxId = max(array_column($items, 'id'));
    return $maxId + 1;
}

// ===== ROUTING =====
$method = $_SERVER["REQUEST_METHOD"];
$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$path = trim(str_replace("/api", "", $path), "/");

// GET /api/items - list all
if ($path === "items" && $method === "GET") {
    $items = loadData();
    usort($items, fn($a, $b) => $b['id'] - $a['id']);
    echo json_encode($items);
    exit();
}

// POST /api/items - create
if ($path === "items" && $method === "POST") {
    $input = json_decode(file_get_contents("php://input"), true);
    $title = $input["title"] ?? "";
    $content = $input["content"] ?? "";
    
    if (empty($title)) {
        http_response_code(400);
        die(json_encode(["error" => "Title is required"]));
    }
    
    $items = loadData();
    $id = getNextId($items);
    $now = date("Y-m-d H:i:s");
    
    $newItem = [
        "id" => $id,
        "title" => $title,
        "content" => $content,
        "created_at" => $now,
        "updated_at" => $now
    ];
    
    $items[] = $newItem;
    saveData($items);
    
    http_response_code(201);
    echo json_encode($newItem);
    exit();
}

// GET /api/items/{id} - detail
if (preg_match("/^items\/(\d+)$/", $path, $m) && $method === "GET") {
    $id = (int)$m[1];
    $items = loadData();
    $item = array_filter($items, fn($i) => $i['id'] == $id);
    $item = reset($item);
    
    if (!$item) {
        http_response_code(404);
        die(json_encode(["error" => "Not found"]));
    }
    
    echo json_encode($item);
    exit();
}

// PUT /api/items/{id} - update
if (preg_match("/^items\/(\d+)$/", $path, $m) && $method === "PUT") {
    $id = (int)$m[1];
    $input = json_decode(file_get_contents("php://input"), true);
    $title = $input["title"] ?? "";
    $content = $input["content"] ?? "";
    
    if (empty($title)) {
        http_response_code(400);
        die(json_encode(["error" => "Title is required"]));
    }
    
    $items = loadData();
    $found = false;
    
    foreach ($items as &$item) {
        if ($item['id'] == $id) {
            $item['title'] = $title;
            $item['content'] = $content;
            $item['updated_at'] = date("Y-m-d H:i:s");
            $found = true;
            break;
        }
    }
    
    if (!$found) {
        http_response_code(404);
        die(json_encode(["error" => "Not found"]));
    }
    
    saveData($items);
    echo json_encode(["id" => $id, "title" => $title, "content" => $content]);
    exit();
}

// DELETE /api/items/{id} - delete
if (preg_match("/^items\/(\d+)$/", $path, $m) && $method === "DELETE") {
    $id = (int)$m[1];
    $items = loadData();
    $newItems = array_filter($items, fn($i) => $i['id'] != $id);
    
    if (count($newItems) === count($items)) {
        http_response_code(404);
        die(json_encode(["error" => "Not found"]));
    }
    
    saveData(array_values($newItems));
    echo json_encode(["deleted" => true, "id" => $id]);
    exit();
}

// GET /api - status
if (empty($path) && $method === "GET") {
    echo json_encode(["status" => "ok", "message" => "API Running (JSON Storage)"]);
    exit();
}

// Not found
http_response_code(404);
echo json_encode(["error" => "Endpoint not found"]);
exit();
