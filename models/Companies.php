<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "companies".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $url
 * @property double $geo_lat
 * @property double $geo_lng
 * @property integer $users_id
 *
 * @property Users $users
 * @property Projects[] $projects
 */
class Companies extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'companies';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description', 'users_id'], 'required'],
            [['description'], 'string'],
            [['geo_lat', 'geo_lng'], 'number'],
            [['users_id'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['url'], 'string', 'max' => 255]
        ];
    }

    public function fields()
    {
        return [
            'id',
            'name',
            'description',
            'geo_lat',
            'geo_lng',
            'projects'
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
            'description' => Yii::t('app', 'Description'),
            'url' => Yii::t('app', 'Url'),
            'geo_lat' => Yii::t('app', 'Geo Lat'),
            'geo_lng' => Yii::t('app', 'Geo Lng'),
            'users_id' => Yii::t('app', 'Users ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasOne(Users::className(), ['id' => 'users_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(Projects::className(), ['companies_id' => 'id']);
    }
}
