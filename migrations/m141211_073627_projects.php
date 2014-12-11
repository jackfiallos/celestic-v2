<?php

use yii\db\Schema;
use yii\db\Migration;

class m141211_073627_projects extends Migration
{
    public function up()
    {
        $this->createTable('projects', array(
            'id' => 'INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT',
            'name' => 'VARCHAR(100) NOT NULL',
            'description' => 'TEXT NOT NULL',
            'date_created' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'start_date' => 'DATETIME NOT NULL',
            'is_active' => 'TINYINT(1) NOT NULL DEFAULT 0',
            'companies_id' => 'INT(11) NOT NULL',
        ));

        $this->addForeignKey('fk_companies_projects_idx', 'projects', 'companies_id', 'companies', 'id');
    }

    public function down()
    {
        echo "m141211_073627_projects cannot be reverted.\n";

        return false;
    }
}
