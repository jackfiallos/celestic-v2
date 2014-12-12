<?php

use yii\db\Schema;
use yii\db\Migration;

class m141212_051939_taskstages extends Migration
{
    public function up()
    {
    	$this->createTable('taskstages', array(
            'id' => 'INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT',
            'name' => 'VARCHAR(45) NOT NULL',
        ), 'ENGINE = MyISAM DEFAULT CHARACTER SET = utf8 COLLATE = utf8_general_ci');

        $this->insert('taskstages', array(
            'name' => 'analysis',
        ));
        $this->insert('taskstages', array(
            'name' => 'design',
        ));
        $this->insert('taskstages', array(
            'name' => 'development',
        ));
        $this->insert('taskstages', array(
            'name' => 'testing',
        ));
        $this->insert('taskstages', array(
            'name' => 'documentation',
        ));
        $this->insert('taskstages', array(
            'name' => 'evolution',
        ));
        $this->insert('taskstages', array(
            'name' => 'finalization',
        ));
    }

    public function down()
    {
        echo "m141212_051939_taskstages cannot be reverted.\n";

        return false;
    }
}
