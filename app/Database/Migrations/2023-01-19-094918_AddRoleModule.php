<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRoleModule extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'Role_mod_id'=>[
                'type'=>'INT',
                'constraint'=>5,
                'unsigned'=>true,
                'auto_increment'=>true
            ],
            'Role_id'=>[
                'type'=>'INT',
                'constraint'=>5,
                'unsigned'=>true
            ],
            'Mod_id'=>[
                'type'=>'INT',
                'constraint'=>5,
                'unsigned'=>true
            ],
            'updated_at'=>[
                'type'=>'datetime',
                'null'=>true
                
            ],
            'created_at datetime default current_timestamp',
        ]);
        $this->forge->addPrimaryKey('Role_mod_id');
        $this->forge->createTable('role_module',true);
    }

    public function down()
    {
       $this->forge->dropTable('role_module');
    }
}
