<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property integer $id
 * @property string $description
 * @property string $end_date
 * @property integer $priority
 * @property integer $milestones_id
 * @property integer $users_id
 * @property integer $projects_id
 * @property integer $status_id
 * @property integer $tasktypes_id
 * @property integer $taskstages_id
 *
 * @property Taskstages $taskstages
 * @property Milestones $milestones
 * @property Projects $projects
 * @property Status $status
 * @property Tasktypes $tasktypes
 * @property Users $users
 */
class Tasks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description', 'users_id', 'projects_id', 'status_id', 'tasktypes_id', 'taskstages_id'], 'required'],
            [['description'], 'string'],
            [['end_date'], 'safe'],
            [['priority', 'milestones_id', 'users_id', 'projects_id', 'status_id', 'tasktypes_id', 'taskstages_id'], 'integer']
        ];
    }

    public function fields()
    {
        return [
            'id',
            'description',
            'end_date',
            'users',
            'projects',
            'milestones',
            'status',
            'tasktypes',
            'taskstages',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'description' => Yii::t('app', 'Description'),
            'end_date' => Yii::t('app', 'End Date'),
            'priority' => Yii::t('app', 'Priority'),
            'milestones_id' => Yii::t('app', 'Milestones ID'),
            'users_id' => Yii::t('app', 'Users ID'),
            'projects_id' => Yii::t('app', 'Projects ID'),
            'status_id' => Yii::t('app', 'Status ID'),
            'tasktypes_id' => Yii::t('app', 'Tasktypes ID'),
            'taskstages_id' => Yii::t('app', 'Taskstages ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskstages()
    {
        return $this->hasOne(Taskstages::className(), ['id' => 'taskstages_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMilestones()
    {
        return $this->hasOne(Milestones::className(), ['id' => 'milestones_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasOne(Projects::className(), ['id' => 'projects_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::className(), ['id' => 'status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasktypes()
    {
        return $this->hasOne(Tasktypes::className(), ['id' => 'tasktypes_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasOne(Users::className(), ['id' => 'users_id']);
    }
}
