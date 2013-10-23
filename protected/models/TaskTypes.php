<?php

/**
 * TaskTypes
 *
 * @author		Jackfiallos
 * @version		2.0.0
 * @link		http://qbit.com.mx/labs/celestic
 * @copyright 	Copyright (c) 2009-2013 Qbit Mexhico
 * @license		http://qbit.com.mx/labs/celestic/license/
 * @description
 * 
 * This is the model class for table "tb_taskTypes".
 *
 * The followings are the available columns in table 'tb_taskTypes':
 * @property integer $taskTypes_id
 * @property string $taskTypes_name
 *
 * The followings are the available model relations:
 */
class TaskTypes extends CActiveRecord
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
		return 'tb_taskTypes';
	}

	/**
	 * [rules description]
	 * @return [type] [description]
	 */
	public function rules()
	{
		return array(
			array('taskTypes_name', 'required'),
			array('taskTypes_name', 'length', 'max'=>45)
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
			'taskTypes_id' => 'Task Types',
			'taskTypes_name' => 'Task Types Name',
		);
	}
	
	/**
	 * [behaviors description]
	 * @return [type] [description]
	 */
	public function behaviors()
	{
		return array(
			'CSafeContentBehavor' => array( 
				'class' => 'application.components.CSafeContentBehavior',
				'attributes' => array('taskTypes_name')
			)
		);
	}
	
	/**
	 * [afterFind description]
	 * @return [type] [description]
	 */
	public function afterFind()
	{
		$this->taskTypes_name = Yii::t('taskTypes',$this->taskTypes_name);
		return parent::afterFind();
	}
}