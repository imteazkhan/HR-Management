<?php
// Simple test to check current user and routes
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

// Boot the application
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

echo "Current URL: " . $request->url() . "\n";
echo "Current path: " . $request->path() . "\n";

// Check if user is authenticated
if (auth()->check()) {
    echo "Logged in user: " . auth()->user()->name . "\n";
    echo "User role: " . auth()->user()->role . "\n";
} else {
    echo "No user logged in\n";
}

echo "Available routes for superadmin/employees:\n";
$routes = \Illuminate\Support\Facades\Route::getRoutes();
foreach ($routes as $route) {
    if (str_contains($route->uri(), 'superadmin/employees')) {
        echo "- " . implode('|', $route->methods()) . " " . $route->uri() . " -> " . $route->getName() . "\n";
    }
}