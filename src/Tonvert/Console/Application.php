<?php
namespace Tonvert\Console;

use Symfony\Component\Console\Application as BaseApplication;

class Application extends BaseApplication {

    public function __construct() {
        parent::__construct('Tonvert Console', 'v0.1.0');
    }

}
