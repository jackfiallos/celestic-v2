<?php

use yii\db\Schema;
use yii\db\Migration;

class m141211_073622_companies extends Migration
{
    public function up()
    {
        $this->createTable('companies', array(
            'id' => 'INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT',
            'name' => 'VARCHAR(100) NOT NULL',
            'description' => 'TEXT NOT NULL',
            'url' => 'VARCHAR(255) NULL DEFAULT NULL',
            'geo_lat' => 'FLOAT(11) NULL DEFAULT NULL',
            'geo_lng' => 'FLOAT(11) NULL DEFAULT NULL',
            'users_id' => 'INT(11) NOT NULL',
        ));

        $this->addForeignKey('fk_companies_users1_idx', 'companies', 'users_id', 'users', 'id');
    }

    public function down()
    {
        echo "m141211_073622_companies cannot be reverted.\n";

        return false;
    }
}
