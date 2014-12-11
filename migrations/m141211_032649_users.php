<?php

use yii\db\Schema;
use yii\db\Migration;

class m141211_032649_users extends Migration
{
    public function up()
    {
	return $this->addColumn('users', 'lastname', 'VARCHAR(20) NULL DEFAULT NULL AFTER name');
    }

    public function down()
    {
        echo "m141211_032649_users cannot be reverted.\n";

        return false;
    }
}
