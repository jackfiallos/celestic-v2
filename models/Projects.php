<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "projects".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $date_created
 * @property string $start_date
 * @property integer $is_active
 * @property integer $companies_id
 *
 * @property Companies $companies
 */
class Projects extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'projects';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description', 'start_date', 'companies_id'], 'required'],
            [['description'], 'string'],
            [['date_created', 'start_date'], 'safe'],
            [['is_active', 'companies_id'], 'integer'],
            [['name'], 'string', 'max' => 100]
        ];
    }

    public function fields()
    {
        return [
            'id',
            'name',
            'description',
            'active' => 'is_active',
            'start_date',
            'companies_id',
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
            'date_created' => Yii::t('app', 'Date Created'),
            'start_date' => Yii::t('app', 'Start Date'),
            'is_active' => Yii::t('app', 'Is Active'),
            'companies_id' => Yii::t('app', 'Companies ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanies()
    {
        return $this->hasOne(Companies::className(), ['id' => 'companies_id']);
    }
}
