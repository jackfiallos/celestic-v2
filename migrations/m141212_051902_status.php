<?php

use yii\db\Schema;
use yii\db\Migration;

class m141212_051902_status extends Migration
{
    public function up()
    {
    	$this->createTable('status', array(
            'id' => 'INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT',
            'name' => 'VARCHAR(45) NOT NULL',
        ), 'ENGINE = MyISAM DEFAULT CHARACTER SET = utf8 COLLATE = utf8_general_ci');

        $this->insert('status', array(
            'name' => 'pending',
        ));
        $this->insert('status', array(
            'name' => 'cancelled',
        ));
        $this->insert('status', array(
            'name' => 'accepted',
        ));
        $this->insert('status', array(
            'name' => 'closed',
        ));
        $this->insert('status', array(
            'name' => 'totest',
        ));
        $this->insert('status', array(
            'name' => 'inprogress',
        ));
        $this->insert('status', array(
            'name' => 'revised',
        ));
    }

    public function down()
    {
        echo "m141212_051902_status cannot be reverted.\n";

        return false;
    }
}
