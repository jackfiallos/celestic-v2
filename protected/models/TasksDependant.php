<?php

/**
 * TasksDependant
 *
 * @author		Jackfiallos
 * @version		2.0.0
 * @link		http://qbit.com.mx/labs/celestic
 * @copyright 	Copyright (c) 2009-2013 Qbit Mexhico
 * @license		http://qbit.com.mx/labs/celestic/license/
 * @description
 * 
 * This is the model class for table "tb_tasksDependant".
 *
 * The followings are the available columns in table 'tb_tasksDependant':
 * @property integer $taskDependant_id
 * @property integer $taskDependant_task_id
 * @property integer $task_id
 */
class TasksDependant extends CActiveRecord
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
		return 'tb_tasksDependant';
	}

	/**
	 * [rules description]
	 * @return [type] [description]
	 */
	public function rules()
	{
		return array(
			array('taskDependant_task_id, task_id', 'required'),
			array('taskDependant_task_id, task_id', 'numerical', 'integerOnly'=>true)
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
			'taskDependant_id' => 'Task Dependant',
			'taskDependant_task_id' => 'Task Dependant Task',
			'task_id' => 'Task'
		);
	}
}