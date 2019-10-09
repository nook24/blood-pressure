<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class Initial extends AbstractMigration {
    public $autoId = false;

    public function up() {

        $this->table('measurements', [
            'id' => 'id',
            'primary_key' => ['id']
        ])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit'   => 11,
                'null'    => false,
                'signed'  => false,
            ])
            ->addColumn('systolic', 'integer', [
                'default' => null,
                'limit'   => 11,
                'null'    => true,
                'signed'  => false,
            ])
            ->addColumn('diastolic', 'integer', [
                'default' => null,
                'limit'   => 11,
                'null'    => true,
                'signed'  => false,
            ])
            ->addColumn('heart_rate', 'integer', [
                'default' => null,
                'limit'   => 11,
                'null'    => true,
                'signed'  => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit'   => null,
                'null'    => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit'   => null,
                'null'    => true,
            ])
            ->create();

    }

    public function down() {
        $this->table('measurements')->drop()->save();
    }
}
