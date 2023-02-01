<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUser extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'User_id'=>[
                'type'=>'INT',
                'constraint'=>5,
                'unsigned'=>true,
                'auto_increment'=>true
            ],
            'User_name'=>[
                'type'=>'VARCHAR',
                'constraint'=>'100',
                'null'=>false
                
            ],
            'User_email'=>[
                'type'=>'VARCHAR',
                'constraint'=>'100',
                'null'=>false,
                'unique'=>true
                
            ],
            'User_password'=>[
                'type'=>'VARCHAR',
                'constraint'=>'255',
                'null'=>false
                
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
        $this->forge->addPrimaryKey('User_id');
        //$this->forge->addForeignKey('Comp_id', 'company', 'Comp_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('user',true);
    }

    public function down()
    {
        $this->forge->dropTable('user');
    }
}
