<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $name
 * @property string $password
 * @property string $email
 * @property string $phone
 * @property integer $is_admin
 * @property integer $is_active
 * @property integer $accountManager
 * @property string $last_login
 * @property string $date_created
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'password', 'email'], 'required'],
            [['is_admin', 'is_active', 'accountManager'], 'integer'],
            [['last_login', 'date_created'], 'safe'],
            [['name', 'password', 'email'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 20]
        ];
    }

    public function fields()
    {
        return [
            'id',
            'email',
            'phone_number' => 'phone',
            'active' => 'is_active',
            'last_login',
            'name' => function ($model)
            {
		return $model->name.' '.$model->lastname;
            },
	];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'password' => Yii::t('app', 'Password'),
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Phone'),
            'is_admin' => Yii::t('app', 'Is Admin'),
            'is_active' => Yii::t('app', 'Is Active'),
            'accountManager' => Yii::t('app', 'Account Manager'),
            'last_login' => Yii::t('app', 'Last Login'),
            'date_created' => Yii::t('app', 'Date Created'),
        ];
    }
}
