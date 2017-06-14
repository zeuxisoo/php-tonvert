<?php
$autoloadPaths = [
    __DIR__.'/../vendor/autoload.php',
    __DIR__.'/../../../autoload.php',
];

$loaded = false;
foreach($autoloadPaths as $autoloadPath) {
    if (file_exists($autoloadPath) === true) {
        include $autoloadPath;

        $loaded = true;
    }
}

if ($loaded === false) {
    echo "Please install the project dependencies using `composer install` first";
    exit(1);
}
