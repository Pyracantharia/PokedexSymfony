<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GreetCommand extends Command
{
    // ...


    protected static $defaultName = 'f2i:test';
    protected static $defaultDescription = 'Pour tester';

    protected function configure(): void
    {
        // ...
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln([
            '<info>Lorem Ipsum Dolor Sit Amet</>',
            '<info>==========================</>',
            '',
        ]);

       
        return Command::SUCCESS;
    }

    
}