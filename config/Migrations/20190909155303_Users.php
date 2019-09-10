<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class Users extends AbstractMigration
{
    public $autoId = false;

    public function up()
    {

        $this->table('measurements')
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
                'signed' => false,
                'after' => 'id'
            ])
        ->update();
        
        if($this->hasTable('users') === false){
            $this->table('users')
                ->addColumn('id', 'integer', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 11,
                    'null' => false,
                    'signed' => false,
                ])
                ->addPrimaryKey(['id'])
                ->addColumn('username', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('password', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('firstname', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('lastname', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->create();
        }
    }

    public function down()
    {
        $this->table('users')->drop()->save();
    }
}
