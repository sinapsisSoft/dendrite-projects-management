<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddClient extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'Client_id'=>[
                'type'=>'INT',
                'constraint'=>5,
                'unsigned'=>true,
                'auto_increment'=>true
            ],
            'Client_name'=>[
                'type'=>'VARCHAR',
                'constraint'=>'100',
                'null'=>false
                
            ],
            'Client_identification'=>[
                'type'=>'VARCHAR',
                'constraint'=>'20',
                'null'=>false,
                'unique'=>true
                
            ],
            'Client_email'=>[
                'type'=>'VARCHAR',
                'constraint'=>'100',
                'null'=>false,
                'unique'=>true
                
            ],
            'Client_phone'=>[
                'type'=>'VARCHAR',
                'constraint'=>'10',
                'null'=>false
                
            ],
            'Client_address'=>[
                'type'=>'VARCHAR',
                'constraint'=>'100',
                'null'=>false
                
            ],
            'DocType_id'=>[
                'type'=>'INT',
                'constraint'=>5,
                'unsigned'=>true
            ],
            'Comp_id'=>[
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
        $this->forge->addPrimaryKey('Client_id');
        //$this->forge->addForeignKey('DocType_id', 'doctype', 'DocType_id', '', '');
        $this->forge->createTable('client');
    }

    public function down()
    {
        $this->forge->dropTable('client');
    }
}
