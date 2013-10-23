<?php

/**
 * Validations
 *
 * @author		Jackfiallos
 * @version		2.0.0
 * @link		http://qbit.com.mx/labs/celestic
 * @copyright 	Copyright (c) 2009-2013 Qbit Mexhico
 * @license		http://qbit.com.mx/labs/celestic/license/
 * @description
 * 
 * This is the model class for table "tb_validations".
 *
 * The followings are the available columns in table 'tb_validations':
 * @property integer $validation_id
 * @property string $validation_field
 * @property string $validation_description
 * @property integer $case_id
 *
 * The followings are the available model relations:
 */
class Validations extends CActiveRecord
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
		return 'tb_validations';
	}

	/**
	 * [rules description]
	 * @return [type] [description]
	 */
	public function rules()
	{
		return array(
			array('validation_field, validation_description, case_id', 'required', 'message'=>Yii::t('inputValidations','RequireValidation')),
			array('case_id', 'numerical', 'integerOnly'=>true),
			array('validation_field', 'length', 'max'=>45, 'message'=>Yii::t('inputValidations','MaxValidation')),
			array('validation_description', 'length', 'max'=>150, 'message'=>Yii::t('inputValidations','MaxValidation'))
		);
	}

	/**
	 * [relations description]
	 * @return [type] [description]
	 */
	public function relations()
	{
		return array(
			'Cases'=>array(self::BELONGS_TO, 'Cases', 'case_id')
		);
	}

	/**
	 * [attributeLabels description]
	 * @return [type] [description]
	 */
	public function attributeLabels()
	{
		return array(
			'validation_id' => Yii::t('validations','validation_id'),
			'validation_field' => Yii::t('validations','validation_field'),
			'validation_description' => Yii::t('validations','validation_description'),
			'case_id' => Yii::t('validations','case_id')
		);
	}
}