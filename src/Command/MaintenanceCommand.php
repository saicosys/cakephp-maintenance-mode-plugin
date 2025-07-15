<?php
declare(strict_types=1);

/**
 * Saicosys Technologies Private Limited
 * Copyright (c) 2017-2025, Saicosys Technologies
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.md
 * Redistributions of files must retain the above copyright notice.
 *
 * @author    Saicosys <info@saicosys.com>
 * @copyright Copyright (c) 2017-2025, Saicosys Technologies
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 * @link      https://www.saicosys.com
 * @since     1.0.0
 */
namespace Saicosys\Maintenance\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

/**
 * Maintenance command.
 */
class MaintenanceCommand extends Command
{
    /**
     * Hook method for defining this command's option parser.
     *
     * @see https://book.cakephp.org/4/en/console-commands/commands.html#defining-arguments-and-options
     * @param \Cake\Console\ConsoleOptionParser $parser The parser to be defined
     * @return \Cake\Console\ConsoleOptionParser The built parser.
     */
    public function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser
            ->addArgument('action', [
                'help' => 'Action to perform (enable/disable/status)',
                'required' => true,
                'choices' => ['enable', 'disable', 'status'],
            ]);

        return $parser;
    }

    /**
     * Implement this method with your command's logic.
     *
     * @param \Cake\Console\Arguments $args The command arguments.
     * @param \Cake\Console\ConsoleIo $io The console io
     * @return int|null|void The exit code or null for success
     */
    public function execute(Arguments $args, ConsoleIo $io): int|null|null
    {
        $action = $args->getArgument('action');

        switch ($action) {
            case 'enable':
                $this->enableMaintenance($io);
                break;
            case 'disable':
                $this->disableMaintenance($io);
                break;
            case 'status':
                $this->checkStatus($io);
                break;
        }

        return static::CODE_SUCCESS;
    }

    /**
     * Enables maintenance mode by creating a maintenance flag file.
     *
     * @param \Cake\Console\ConsoleIo $io The console io object for output.
     * @return void
     */
    private function enableMaintenance(ConsoleIo $io): void
    {
        // Implementation for enabling maintenance mode
        file_put_contents(CONFIG . 'maintenance.flag', time());
        $io->success('Maintenance mode enabled');
    }

    /**
     * Disables maintenance mode by removing the maintenance flag file.
     *
     * @param \Cake\Console\ConsoleIo $io The console io object for output.
     * @return void
     */
    private function disableMaintenance(ConsoleIo $io): void
    {
        // Implementation for disabling maintenance mode
        @unlink(CONFIG . 'maintenance.flag');
        $io->success('Maintenance mode disabled');
    }

    /**
     * Checks the current status of maintenance mode and outputs it.
     *
     * @param \Cake\Console\ConsoleIo $io The console io object for output.
     * @return void
     */
    private function checkStatus(ConsoleIo $io): void
    {
        $status = file_exists(CONFIG . 'maintenance.flag') ? 'enabled' : 'disabled';
        $io->info('Maintenance mode is currently ' . $status);
    }
}
