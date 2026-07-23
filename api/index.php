<?php

/**
 * Vercel only allows runtime writes under /tmp. Laravel normally stores its
 * compiled views and cached manifests in bootstrap/cache, which is read-only
 * in a serverless function.
 */
$runtimePaths = [
    'VIEW_COMPILED_PATH' => '/tmp/views',
    'APP_CONFIG_CACHE' => '/tmp/config.php',
    'APP_EVENTS_CACHE' => '/tmp/events.php',
    'APP_PACKAGES_CACHE' => '/tmp/packages.php',
    'APP_ROUTES_CACHE' => '/tmp/routes.php',
    'APP_SERVICES_CACHE' => '/tmp/services.php',
];

if (! is_dir($runtimePaths['VIEW_COMPILED_PATH'])) {
    mkdir($runtimePaths['VIEW_COMPILED_PATH'], 0755, true);
}

foreach ($runtimePaths as $name => $path) {
    putenv($name.'='.$path);
    $_ENV[$name] = $path;
    $_SERVER[$name] = $path;
}

require __DIR__.'/../public/index.php';
