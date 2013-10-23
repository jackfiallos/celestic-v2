<?php

/**
 * SecuenceTypes
 * 
 * @author		Jackfiallos
 * @version		2.0.0
 * @link		http://qbit.com.mx/labs/celestic
 * @copyright 	Copyright (c) 2009-2013 Qbit Mexhico
 * @license		http://qbit.com.mx/labs/celestic/license/
 * @description
 * 
 * This is the model class for table "tb_secuenseTypes".
 *
 * The followings are the available columns in table 'tb_secuenceTypes':
 * @property integer $secuenceTypes_id
 * @property string $secuenceTypes_name
 *
 * The followings are the available model relations:
 */
class SecuenceTypes extends CActiveRecord
{
	const NORMAL      = 1;
	const ALTERNATIVE = 2;
	const EXCEPTION   = 3;

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
		return 'tb_secuenceTypes';
	}

	/**
	 * [rules description]
	 * @return [type] [description]
	 */
	public function rules()
	{
		return array(
			array('secuenceTypes_name', 'required'),
			array('secuenceTypes_name', 'length', 'max'=>45)
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
			'secuenceTypes_id' => 'Secuence Types',
			'secuenceTypes_name' => 'Secuence Types Name'
		);
	}
}