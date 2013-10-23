<?php

/**
 * Secuences
 *
 * @author		Jackfiallos
 * @version		2.0.0
 * @link		http://qbit.com.mx/labs/celestic
 * @copyright 	Copyright (c) 2009-2013 Qbit Mexhico
 * @license		http://qbit.com.mx/labs/celestic/license/
 * @description
 * 
 * This is the model class for table "tb_secuences".
 *
 * The followings are the available columns in table 'tb_secuences':
 * @property integer $secuence_id
 * @property integer $secuence_step
 * @property string $secuence_action
 * @property integer $case_id
 * @property integer $secuenceTypes_id
 *
 * The followings are the available model relations:
 */
class Secuences extends CActiveRecord
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
		return 'tb_secuences';
	}

	/**
	 * [rules description]
	 * @return [type] [description]
	 */
	public function rules()
	{
		return array(
			array('secuence_step, secuence_action, case_id, secuenceTypes_id', 'required', 'message'=>Yii::t('inputValidations','RequireValidation')),
			array('secuence_step, case_id, secuenceTypes_id', 'numerical', 'integerOnly'=>true),
			array('secuence_action, secuence_responsetoAction', 'length', 'max'=>100, 'message'=>Yii::t('inputValidations','MaxValidation')),
			array('secuence_action', 'length', 'min'=>5, 'message'=>Yii::t('inputValidations','MinValidation'))
		);
	}

	/**
	 * [relations description]
	 * @return [type] [description]
	 */
	public function relations()
	{
		return array(
			'SecuenceTypes'=>array(self::BELONGS_TO, 'SecuenceTypes', 'secuenceTypes_id'),
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
			'secuence_id' => Yii::t('secuences','secuence_id'),
			'secuence_step' => Yii::t('secuences','secuence_step'),
			'secuence_action' => Yii::t('secuences','secuence_action'),
			'secuence_responsetoAction' => Yii::t('secuences','secuence_responsetoAction'),
			'case_id' => Yii::t('secuences','case_id'),
			'secuenceTypes_id' => Yii::t('secuences','secuenceTypes_id')
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
				'attributes' => array('secuence_step', 'secuence_action', 'secuence_responsetoAction')
			),
		);
	}
}