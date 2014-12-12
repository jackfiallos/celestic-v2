<?php

use yii\db\Schema;
use yii\db\Migration;

class m141212_052006_tasktypes extends Migration
{
    public function up()
    {
    	$this->createTable('tasktypes', array(
            'id' => 'INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT',
            'name' => 'VARCHAR(45) NOT NULL',
        ), 'ENGINE = MyISAM DEFAULT CHARACTER SET = utf8 COLLATE = utf8_general_ci');

        $this->insert('tasktypes', array(
            'name' => 'analysis',
        ));
        $this->insert('tasktypes', array(
            'name' => 'Suggestion',
        ));
        $this->insert('tasktypes', array(
            'name' => 'Error',
        ));
        $this->insert('tasktypes', array(
            'name' => 'Additon',
        ));
        $this->insert('tasktypes', array(
            'name' => 'Maintenance',
        ));
        $this->insert('tasktypes', array(
            'name' => 'Improvement',
        ));
        $this->insert('tasktypes', array(
            'name' => 'Modification',
        ));
        $this->insert('tasktypes', array(
            'name' => 'Planning',
        ));
        $this->insert('tasktypes', array(
            'name' => 'Testing',
        ));
    }

    public function down()
    {
        echo "m141212_052006_tasktypes cannot be reverted.\n";

        return false;
    }
}
