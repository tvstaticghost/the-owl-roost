<?php 
$routes = [
    '/' => '/views/home.php',
    '/course' => '/views/course.php',
    '/communities' => '/views/communities.php',
    '/resources' => '/views/resources.php',
];

$requestUri = $_SERVER['REQUEST_URI'];

// Remove query string from the request URI for path matching
$requestPath = strtok($requestUri, '?');

// Check if the route exists in $routes array
if (array_key_exists($requestPath, $routes)) {
    // If route exists, include the corresponding file
    require __DIR__ . $routes[$requestPath];
} else {
    // If route doesn't exist, include the 404 file
    require __DIR__ . '/views/404.php';
}
?>
