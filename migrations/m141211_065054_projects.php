<?php

use yii\db\Schema;
use yii\db\Migration;

class m141211_065054_projects extends Migration
{
    public function up()
    {
        return $this->createTable('projects', array(
            'id' => 'INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT',
            'name' => 'VARCHAR(100) NOT NULL',
            'description' => 'TEXT NOT NULL',
            'date_created' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'start_date' => 'DATETIME NOT NULL',
            'is_active' => 'TINYINT(1) NOT NULL DEFAULT 0'
        ));
    }

    public function down()
    {
        echo "m141211_065054_projects cannot be reverted.\n";

        return false;
    }
}
