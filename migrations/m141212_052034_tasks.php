<?php

use yii\db\Schema;
use yii\db\Migration;

class m141212_052034_tasks extends Migration
{
    public function up()
    {
    	$this->createTable('tasks', array(
            'id' => 'INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT',
            'description' => 'TEXT NOT NULL',
            'end_date' => 'DATE NOT NULL',
            'priority' => 'TINYINT(4) NULL DEFAULT NULL',
            'milestones_id' => 'INT(11) NULL DEFAULT NULL',
            'users_id' => 'INT(11) NOT NULL',
            'projects_id' => 'INT(11) NOT NULL',
			'status_id' => 'INT(11) NOT NULL',
			'tasktypes_id' => 'INT(11) NOT NULL',
			'taskstages_id' => 'INT(11) NOT NULL',
        ), 'ENGINE = MyISAM DEFAULT CHARACTER SET = utf8 COLLATE = utf8_general_ci');

        $this->addForeignKey('fk_tasks_milestones1_idx', 'tasks', 'milestones_id', 'milestones', 'id');
        $this->addForeignKey('fk_tasks_users1_idx', 'tasks', 'users_id', 'users', 'id');
        $this->addForeignKey('fk_tasks_projects1_idx', 'tasks', 'projects_id', 'projects', 'id');
        $this->addForeignKey('fk_tasks_status1_idx', 'tasks', 'status_id', 'status', 'id');
        $this->addForeignKey('fk_tasks_tasktypes1_idx', 'tasks', 'tasktypes_id', 'tasktypes', 'id');
        $this->addForeignKey('fk_tasks_taskstages1_idx', 'tasks', 'taskstages_id', 'taskstages', 'id');
    }

    public function down()
    {
        echo "m141212_052034_tasks cannot be reverted.\n";

        return false;
    }
}
