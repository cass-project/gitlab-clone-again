<?php

use Phinx\Migration\AbstractMigration;

class RoomMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('room')
            ->addColumn('name', 'string', [ 'null' => false ])
            ->addColumn('owner_id', 'integer', [ 'null' => false ])
            ->addColumn('owner_type', 'integer', [ 'null' => false ])
            ->addColumn('created', 'datetime', ['null' => false])
            ->create()
        ;
    }
}
