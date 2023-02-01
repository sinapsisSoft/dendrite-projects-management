<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRoleModulePermit extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'Role_mod_per_id'=>[
                'type'=>'INT',
                'constraint'=>5,
                'unsigned'=>true,
                'auto_increment'=>true
            ],
            'Perm_id'=>[
                'type'=>'INT',
                'constraint'=>5,
                'unsigned'=>true
            ],
            'Role_mod_id'=>[
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
        $this->forge->addPrimaryKey('Role_mod_per_id');
        $this->forge->createTable('role_module_permit',true);
    }

    public function down()
    {
        $this->forge->dropTable('role_module_permit');
    }
}
