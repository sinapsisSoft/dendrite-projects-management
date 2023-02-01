<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRole extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'Role_id'=>[
                'type'=>'INT',
                'constraint'=>5,
                'unsigned'=>true,
                'auto_increment'=>true
            ],
            'Role_name'=>[
                'type'=>'VARCHAR',
                'constraint'=>'50',
                'null'=>false
                
            ],
            'Role_description'=>[
                'type'=>'VARCHAR',
                'constraint'=>'100',
                'null'=>false
                
            ],
            'updated_at'=>[
                'type'=>'datetime',
                'null'=>true
                
            ],
            'created_at datetime default current_timestamp',
        ]);
        $this->forge->addPrimaryKey('Role_id');
        $this->forge->createTable('role',true);
    }

    public function down()
    {
        $this->forge->dropTable('role');
    }
}
