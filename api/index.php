<?php

$compiledViewsPath = '/tmp/views';

if (! is_dir($compiledViewsPath)) {
    mkdir($compiledViewsPath, 0755, true);
}

putenv('VIEW_COMPILED_PATH='.$compiledViewsPath);
$_ENV['VIEW_COMPILED_PATH'] = $compiledViewsPath;
$_SERVER['VIEW_COMPILED_PATH'] = $compiledViewsPath;

require __DIR__.'/../public/index.php';
