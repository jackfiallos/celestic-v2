<?php

use yii\db\Schema;
use yii\db\Migration;

class m141212_043111_milestones extends Migration
{
    public function up()
    {
    	$this->createTable('milestones', array(
            'id' => 'INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT',
            'title' => 'VARCHAR(100) NOT NULL',
            'description' => 'TEXT NOT NULL',
            'start_date' => 'DATE NOT NULL',
            'due_date' => 'DATE NOT NULL',
            'projects_id' => 'INT(11) NOT NULL',
            'users_id' => 'INT(11) NOT NULL',
        ), 'ENGINE = MyISAM DEFAULT CHARACTER SET = utf8 COLLATE = utf8_general_ci');

        $this->addForeignKey('fk_milestones_projects1_idx', 'milestones', 'projects_id', 'projects', 'id');
        $this->addForeignKey('fk_milestones_users1_idx', 'milestones', 'users_id', 'users', 'id');
    }

    public function down()
    {
        echo "m141212_043111_milestones cannot be reverted.\n";

        return false;
    }
}
