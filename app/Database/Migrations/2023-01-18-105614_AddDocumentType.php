<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDocumentType extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'DocType_id'=>[
                'type'=>'INT',
                'constraint'=>5,
                'unsigned'=>true,
                'auto_increment'=>true
            ],
            'DocType_name'=>[
                'type'=>'VARCHAR',
                'constraint'=>'100',
                'null'=>false
                
            ],
            'DocType_code'=>[
                'type'=>'VARCHAR',
                'constraint'=>'10',
                'null'=>false
                
            ],
            'updated_at'=>[
                'type'=>'datetime',
                'null'=>true
                
            ],
            'created_at datetime default current_timestamp',
        ]);
        $this->forge->addPrimaryKey('DocType_id');
        $this->forge->createTable('docType',true);
    }

    public function down()
    {
        $this->forge->dropTable('docType');
    }
}
