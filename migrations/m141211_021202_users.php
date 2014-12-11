<?php

use yii\db\Schema;
use yii\db\Migration;

class m141211_021202_users extends Migration
{
    public function up()
    {
	return $this->createTable('users', array(
		'id' => 'INT NOT NULL PRIMARY KEY AUTO_INCREMENT',
		'name' => 'VARCHAR(100) NOT NULL',
		'password' => 'VARCHAR(100) NOT NULL',
		'email' => 'VARCHAR(100) NOT NULL',
		'phone' => 'VARCHAR(20) NULL DEFAULT NULL',
		'is_admin' => 'TINYINT(1) NOT NULL DEFAULT 0',
		'is_active' => 'TINYINT(1) NOT NULL DEFAULT 0',
		'accountManager' => 'TINYINT(1) NOT NULL DEFAULT 0',
		'last_login' => 'DATETIME NULL DEFAULT NULL',
		'date_created' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
	));
    }

    public function down()
    {
        echo "m141211_021202_users cannot be reverted.\n";

        return false;
    }
}
