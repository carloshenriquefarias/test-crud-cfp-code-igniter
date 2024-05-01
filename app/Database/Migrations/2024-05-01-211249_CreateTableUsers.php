<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableUsers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'firstname' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'lastname' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],           
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'mobile' => [
                'type'       => 'VARCHAR',
                'constraint' => 20
            ],
            'dateofbirth' => [
                'type'       => 'DATETIME',
                'null'       =>   true,
                'default'    =>   null,
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'created_at' => [
                'type'       => 'DATETIME',
                'null'       =>   true,
                'default'    =>   null,
            ],
            'updated_at' => [
                'type'       => 'DATETIME',
                'null'       =>   true,
                'default'    =>   null,
            ],
            'deleted_at' => [
                'type'       => 'DATETIME',
                'null'       =>   true,
                'default'    =>   null,
            ]
            
        ]);
        $this->forge->addKey('id', true);
        
        $this->forge->addUniqueKey(['id', 'email', 'username'], 'key_name');

        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
