<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddModule extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'Mod_id'=>[
                'type'=>'INT',
                'constraint'=>5,
                'unsigned'=>true,
                'auto_increment'=>true
            ],
            'Mod_name'=>[
                'type'=>'VARCHAR',
                'constraint'=>'50',
                'null'=>false
                
            ],
            'Mod_description'=>[
                'type'=>'VARCHAR',
                'constraint'=>'100',
                'null'=>false
                
            ],
            'Mod_route'=>[
                'type'=>'VARCHAR',
                'constraint'=>'30',
                'null'=>false
                
            ],
            'updated_at'=>[
                'type'=>'datetime',
                'null'=>true
                
            ],
            'created_at datetime default current_timestamp',
        ]);
        $this->forge->addPrimaryKey('Mod_id');
        $this->forge->createTable('module',true);
    }

    public function down()
    {
       $this->forge->dropTable('module');
    }
}
