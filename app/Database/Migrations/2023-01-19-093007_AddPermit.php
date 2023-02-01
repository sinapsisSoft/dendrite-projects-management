<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPermit extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'Perm_id'=>[
                'type'=>'INT',
                'constraint'=>5,
                'unsigned'=>true,
                'auto_increment'=>true
            ],
            'Perm_name'=>[
                'type'=>'VARCHAR',
                'constraint'=>'50',
                'null'=>false
                
            ],
            'Perm_description'=>[
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
        $this->forge->addPrimaryKey('Perm_id');
        $this->forge->createTable('permit',true);
    }

    public function down()
    {
        $this->forge->dropTable('permit');
    }
}
