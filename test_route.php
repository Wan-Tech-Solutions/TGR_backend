<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

// Check if routes are cached
$routes = file_exists(base_path('bootstrap/cache/routes-v7.php')) ? 'CACHED' : 'NOT CACHED';
echo "Routes status: $routes\n";

// Try to resolve the route
try {
    $url = app('url')->route('prospectus.store');
    echo "✓ Route resolved: $url\n";
} catch (Exception $e) {
    echo "✗ Route error: " . $e->getMessage() . "\n";
}

// Check if POST /prospectus route exists
$routes = app('router')->getRoutes();
$found = false;
foreach ($routes as $route) {
    if ($route->getName() === 'prospectus.store') {
        echo "✓ Found route: " . $route->getName() . " (" . implode(',', $route->methods) . ") -> " . $route->uri() . "\n";
        $found = true;
    }
}

if (!$found) {
    echo "✗ Route 'prospectus.store' not found\n";
}
