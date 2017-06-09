<?php
namespace Tonvert\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

/**
 * Usage
 * =====
 *
 * Tran
 *
 *      php tonvert tran
 *      php tonvert tran --in=/path/to/file --output=/path/to/file
 */
class TranCommand extends BaseCommand {

    protected function configure() {
        $this->setName('tran')
             ->setDescription('Translate file')
             ->setAliases(['tran'])
             ->addOption('--in', 'i', InputOption::VALUE_REQUIRED)
             ->addOption('--out', 'o', InputOption::VALUE_REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $in = $input->getOption('in') ?: '';
        $out = $input->getOption('out') ?: '';

        if (empty($in) === true) {
            $this->error("Input file path incorrect");
            return 1;
        }

        if (file_exists($in) === false || is_file($in) === false) {
            $this->error("Input file path: {$in} could not be open");
            return 1;
        }
    }

}
