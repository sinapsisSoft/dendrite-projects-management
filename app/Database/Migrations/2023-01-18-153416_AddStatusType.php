<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusType extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'StatType_id'=>[
                'type'=>'INT',
                'constraint'=>5,
                'unsigned'=>true,
                'auto_increment'=>true
            ],
            'StatType_name'=>[
                'type'=>'VARCHAR',
                'constraint'=>'100',
                'null'=>false
                
            ],
            'StatType_description'=>[
                'type'=>'VARCHAR',
                'constraint'=>'200',
                'null'=>false
                
            ],
            'updated_at'=>[
                'type'=>'datetime',
                'null'=>true
                
            ],
            'created_at datetime default current_timestamp',
        ]);
        $this->forge->addPrimaryKey('StatType_id');
        $this->forge->createTable('statusType',true);
    }

    public function down()
    {
        $this->forge->dropTable('statusType');
    }
}
