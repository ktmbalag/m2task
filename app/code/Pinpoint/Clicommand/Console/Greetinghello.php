<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Pinpoint\Clicommand\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Greetinghello
 * For display the hello using CLI command
 * CLI Command: php bin/magento greeting
 */
class Greetinghello extends Command
{
	/**
     * {@inheritdoc}
	 * configure() method is used to set the name, description, command line arguments
     */
   protected function configure()
   {
       $this->setName('greeting');
       $this->setDescription('Show the greeting to the user');
       
       parent::configure();
   }
   
   /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * execute() method will run when we call this command line via console
	 * Output show hello
     */
   protected function execute(InputInterface $input, OutputInterface $output)
   {
       $output->writeln("Greeting to the user :)");
       $output->writeln("hello");
   }
}