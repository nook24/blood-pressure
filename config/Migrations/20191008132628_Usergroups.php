<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class Usergroups extends AbstractMigration {
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change() {

        $this->table('usergroups')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit'   => 255,
                'null'    => true,
            ])
            ->create();

        $this->table('users')
            ->addColumn('usergroup_id', 'integer', [
                'default'       => null,
                'limit'         => 11,
                'null'          => false,
                'signed'        => false,
            ])
            ->update();
    }

}
