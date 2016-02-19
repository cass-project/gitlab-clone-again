<?php

use Phinx\Migration\AbstractMigration;

class User extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    private $accountTableName = 'account';
    private $oauthProviderTableName = 'oauth_provider';
    private $oauthAccountTableName = 'oauth_account';


    public function change()
    {
        // Adding account table
        $this->table($this->accountTableName)
            ->addColumn('email', 'string')
            ->addColumn('phone', 'integer', ['null' => true])
            ->addColumn('password', 'string', ['limit' => 40])
            ->addIndex(['phone'], ['unique' => true])
            ->addIndex(['email'], ['unique' => true])
            ->create()
        ;

        // Adding aouth provider table
        $this->table($this->oauthProviderTableName)
            ->addColumn('app_id', 'integer')
            ->addColumn('name', 'string')
            ->create()
        ;

        // Adding aouth account table
        $this->table($this->oauthAccountTableName)
            ->addColumn('account_id', 'integer')
            ->addForeignKey('account_id', $this->accountTableName, 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
            ->addColumn('token', 'string')
            ->addColumn('expires', 'timestamp')
            ->addColumn('provider_id', 'integer')
            ->addForeignKey('provider_id', $this->oauthProviderTableName, 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
            ->create()
        ;

        $this->insertData();
    }

    private function insertData(){
        $this->table($this->accountTableName)->insert([
            'email' => 'cass@cass.io',
            'password' => '57f43b6042ed2d842591d3af449ff3e685d1dba1', // 1234
        ])->saveData();

        $this->table($this->oauthProviderTableName)->insert([
            ['name' => 'vk'],
            ['name' => 'facebook'],
            ['name' => 'ok'],
            ['name' => 'mailru'],
            ['name' => 'yandex'],
            ['name' => 'google']
        ])->saveData();
    }
}
