<?php

declare(strict_types=1);

namespace App\Command;

use App\Model\Table\UsersTable;
use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\ORM\TableRegistry;

/**
 * CreateUser command.
 */
class CreateUserCommand extends Command
{
    /**
     * Hook method for defining this command's option parser.
     *
     * @see https://book.cakephp.org/3.0/en/console-and-shells/commands.html#defining-arguments-and-options
     *
     * @param \Cake\Console\ConsoleOptionParser $parser The parser to be defined
     * @return \Cake\Console\ConsoleOptionParser The built parser.
     */
    public function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser = parent::buildOptionParser($parser);

        return $parser;
    }

    /**
     * Implement this method with your command's logic.
     *
     * @param \Cake\Console\Arguments $args The command arguments.
     * @param \Cake\Console\ConsoleIo $io The console io
     * @return null|int The exit code or null for success
     */
    public function execute(Arguments $args, ConsoleIo $io): ?int
    {
        $username = $io->ask(
            __('Please enter a new username')
        );
        $password = $io->ask(
            __('Set password')
        );
        $passwordConfirm = $io->ask(
            __('Confirm password')
        );

        if ($password !== $passwordConfirm) {
            $io->error(
                __('Passwords are not the same')
            );
            return 1;
        }

        /** @var UsersTable $UsersTable */
        $UsersTable = TableRegistry::getTableLocator()->get('Users');

        $user = $UsersTable->newEmptyEntity();
        $user = $UsersTable->patchEntity($user, [
            'username' => $username,
            'password' => $password
        ]);

        $UsersTable->save($user);
        if ($user->hasErrors()) {
            $io->out($user->getErrors());
            return 1;
        }

        $io->success(__('New user created successfully.'));
        return 0;
    }
}
