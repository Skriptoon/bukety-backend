<?php

use Illuminate\Contracts\Console\Kernel;

$app = require __DIR__.'/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();
$_ENV['APP_ENV'] = 'testing';
$_ENV['DB_CONNECTION'] = 'sqlite';
$_ENV['DB_DATABASE'] = ':memory:';
