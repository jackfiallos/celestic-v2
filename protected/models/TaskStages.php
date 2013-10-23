<?php

/**
 * TaskStages
 *
 * @author		Jackfiallos
 * @version		2.0.0
 * @link		http://qbit.com.mx/labs/celestic
 * @copyright 	Copyright (c) 2009-2013 Qbit Mexhico
 * @license		http://qbit.com.mx/labs/celestic/license/
 * @description
 * 
 * This is the model class for table "tb_taskStages".
 *
 * The followings are the available columns in table 'tb_taskStages':
 * @property integer $taskStage_id
 * @property string $taskStage_name
 */
class TaskStages extends CActiveRecord
{
	/**
	 * [model description]
	 * @param  [type] $className [description]
	 * @return [type]            [description]
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * [tableName description]
	 * @return [type] [description]
	 */
	public function tableName()
	{
		return 'tb_taskStages';
	}

	/**
	 * [rules description]
	 * @return [type] [description]
	 */
	public function rules()
	{
		return array(
			array('taskStage_name', 'required'),
			array('taskStage_name', 'length', 'max'=>45)
		);
	}

	/**
	 * [relations description]
	 * @return [type] [description]
	 */
	public function relations()
	{
		return array(
		);
	}

	/**
	 * [attributeLabels description]
	 * @return [type] [description]
	 */
	public function attributeLabels()
	{
		return array(
			'taskStage_id' => 'Task Stage',
			'taskStage_name' => 'Task Stage Name'
		);
	}
	
	/**
	 * [afterFind description]
	 * @return [type] [description]
	 */
	public function afterFind()
	{
		$this->taskStage_name = Yii::t('taskStage',$this->taskStage_name);
		return parent::afterFind();
	}
}