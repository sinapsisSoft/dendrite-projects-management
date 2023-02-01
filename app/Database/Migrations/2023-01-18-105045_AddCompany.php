<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCompany extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'Comp_id'=>[
                'type'=>'INT',
                'constraint'=>5,
                'unsigned'=>true,
                'auto_increment'=>true
            ],
            'Comp_name'=>[
                'type'=>'VARCHAR',
                'constraint'=>'100',
                'null'=>false
                
            ],
            'Comp_identification'=>[
                'type'=>'VARCHAR',
                'constraint'=>'20',
                'null'=>false,
                'unique'=>true
                
            ],
            'Comp_email'=>[
                'type'=>'VARCHAR',
                'constraint'=>'100',
                'null'=>false,
                'unique'=>true
                
            ],
            'Comp_phone'=>[
                'type'=>'VARCHAR',
                'constraint'=>'10',
                'null'=>false
                
            ],
            'DocType_id'=>[
                'type'=>'INT',
                'constraint'=>5,
                'unsigned'=>true
            ],
            'Stat_id'=>[
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
        $this->forge->addPrimaryKey('Comp_id');
        //$this->forge->addForeignKey('DocType_id', 'doctype', 'DocType_id', '', '');
        $this->forge->createTable('company');
    }

    public function down()
    {
        $this->forge->dropTable('company');
    }
}
