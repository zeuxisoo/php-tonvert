<?php
namespace Tonvert\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\ConsoleOutput;
use Tonvert\Console\Application;

class BaseCommand extends Command {

    private $output;

    public function __construct() {
        parent::__construct();

        $this->output = new ConsoleOutput();
    }

    public function error(string $message) {
        $this->output->writeln("<error>{$message}</error>");
    }

    public function info(string $message) {
        $this->output->writeln("<info>{$message}</info>");
    }

}
