<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "milestones".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $start_date
 * @property string $due_date
 * @property integer $projects_id
 * @property integer $users_id
 */
class Milestones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'milestones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description', 'start_date', 'due_date', 'projects_id', 'users_id'], 'required'],
            [['description'], 'string'],
            [['start_date', 'due_date'], 'safe'],
            [['projects_id', 'users_id'], 'integer'],
            [['title'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'start_date' => Yii::t('app', 'Start Date'),
            'due_date' => Yii::t('app', 'Due Date'),
            'projects_id' => Yii::t('app', 'Projects ID'),
            'users_id' => Yii::t('app', 'Users ID'),
        ];
    }
}
