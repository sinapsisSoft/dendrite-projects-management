<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddProfile extends Migration
{
    public function up()
    {
        
        $this->forge->addField([
            'Profile_id'=>[
                'type'=>'INT',
                'constraint'=>5,
                'unsigned'=>true,
                'auto_increment'=>true
            ],
            'Profile_img'=>[
                'type'=>'VARCHAR',
                'constraint'=>'150',
                'null'=>false
                
            ],
            'Profile_alias'=>[
                'type'=>'VARCHAR',
                'constraint'=>'20',
                'null'=>false
                
            ],
            'Profile_cellphone'=>[
                'type'=>'VARCHAR',
                'constraint'=>'10',
                'null'=>false
                
            ],
            'Profile_identification'=>[
                'type'=>'VARCHAR',
                'constraint'=>'10',
                'null'=>false
                
            ],
            'DocType_id'=>[
                'type'=>'INT',
                'constraint'=>5,
                'unsigned'=>true
            ],
            'User_id'=>[
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
        $this->forge->addPrimaryKey('Profile_id');
        //$this->forge->addForeignKey('Comp_id', 'company', 'Comp_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('profile',true);
    }

    public function down()
    {
        $this->forge->dropTable('profile');
    }
}
