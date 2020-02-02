<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Pinpoint\Clicommand\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\Module\FullModuleList;
use Magento\Framework\Module\Manager;

/**
 * Class Checkactivemodules
 * For display the active modules using CLI command
 * CLI Command: php bin/magento check-active
 */
class Checkactivemodules extends Command
{

    protected $fullModuleList;
    protected $moduleCollector;

    /**
     * @param Magento\Framework\Module\FullModuleLis
     * @param Magento\Framework\Module\Manager;
	 */
    public function __construct(
        FullModuleList $fullModuleList,
        Manager $moduleCollector
    ) {
        parent::__construct();
        $this->fullModuleList = $fullModuleList;
        $this->moduleCollector  = $moduleCollector;
    }

    /**
     * {@inheritdoc}
	 * configure() method is used to set the name, description, command line arguments
     */
    public function configure()
    {
        $this->setName('check-active')
            ->setDescription('Show the list of active modules.');
    }

   /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * execute() method will run when we call this command line via console
	 * Output show list of all active modules
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fullModulesList = $this->fullModuleList->getAll();
        $output->writeln('List of active modules:');
        foreach ($fullModulesList as $module) {
            if($this->moduleCollector->isEnabled($module['name'])) {
                $output->writeln($module['name']);
            }
        }
    }
}