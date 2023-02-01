<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatus extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'Stat_id'=>[
                'type'=>'INT',
                'constraint'=>5,
                'unsigned'=>true,
                'auto_increment'=>true
            ],
            'Stat_name'=>[
                'type'=>'VARCHAR',
                'constraint'=>'100',
                'null'=>false
                
            ],
            'Stat_description'=>[
                'type'=>'VARCHAR',
                'constraint'=>'200',
                'null'=>false
                
            ],
            'StatType_id'=>[
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
        $this->forge->addPrimaryKey('Stat_id');
        $this->forge->createTable('status',true);
    }

    public function down()
    {
        $this->forge->dropTable('statusType');
    }
}
