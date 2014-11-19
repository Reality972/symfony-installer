<?php

/*
 * This file is part of the Symfony Installer package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Installer;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * This command provides information about the Symfony installer.
 *
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 */
class AboutCommand extends Command
{
    private $appVersion;

    public function __construct($appVersion)
    {
        parent::__construct();

        $this->appVersion = $appVersion;
    }

    protected function configure()
    {
        $this
            ->setName('about')
            ->setDescription('Symfony Installer Help.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $commandHelp = <<<COMMAND_HELP

 Symfony Installer (%s)
 %s

 This is the official installer to start new projects based on the
 Symfony full-stack framework.

 To create a new project called <info>blog</info> in the current directory using
 the <info>latest stable version</info> of Symfony, execute the following command:

   <comment>$ %s new blog</comment>

 To base your project on a <info>specific Symfony version</info>, append the version
 number at the end of the command:

   <comment>$ %3\$s new blog 2.5.6</comment>

COMMAND_HELP;

        // show the self-update information only when using the PHAR file
        if ('phar://' === substr(__DIR__, 0, 7)) {
            $commandUpdateHelp = <<<COMMAND_UPDATE_HELP
 Updating the Symfony Installer
 ------------------------------

 New versions of the Symfony Installer are released regularly. To <info>update your
 installer</info> version, execute the following command:

   <comment>$ %3\$s self-update</comment>

COMMAND_UPDATE_HELP;

            $commandHelp .= $commandUpdateHelp;
        }

        $output->writeln(sprintf($commandHelp,
            $this->appVersion,
            str_repeat('=', 20 + strlen($this->appVersion)),
            $_SERVER['PHP_SELF']
        ));
    }
}
