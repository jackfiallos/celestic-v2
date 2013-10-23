<?php

/**
 * Accounts Model
 * 
 * @author		Jackfiallos
 * @version		2.0.0
 * @link		http://qbit.com.mx/labs/celestic
 * @copyright 	Copyright (c) 2009-2013 Qbit Mexhico
 * @license		http://qbit.com.mx/labs/celestic/license/
 * @description
 * 
 * This is the model class for table "stb_accounts".
 */
class Accounts extends CActiveRecord
{
	public $image;
	
	/**
	 * The followings are the available columns in table 'stb_accounts':
	 * @var integer $account_id
	 * @var string $account_name
	 * @var string $account_logo
	 * @var string $account_colorscheme
	 * @var string $account_uniqueId
	 * @var string $account_companyName
	 * @var string $account_projectNumbers
	 * @var string $account_storageSize
	 * @var int $address_id
	 * @var int $timezone_id
	 */

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
		return 'stb_accounts';
	}

	/**
	 * [rules description]
	 * @return [type] [description]
	 */
	public function rules()
	{
		return array(
			array('account_name', 'required', 'message'=>Yii::t('inputValidations','RequireValidation')),
			array('account_name, account_companyName', 'length', 'max'=>45, 'message'=>Yii::t('inputValidations','MaxValidation')),
			array('account_uniqueId', 'length', 'max'=>20, 'message'=>Yii::t('inputValidations','MaxValidation')),
			array('account_logo', 'length', 'max'=>255, 'message'=>Yii::t('inputValidations','MaxValidation')),
			array('timezone_id, account_projectNumbers, account_storageSize', 'numerical', 'integerOnly'=>true)
		);
	}

	/**
	 * [relations description]
	 * @return [type] [description]
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'Users'=>array(self::HAS_MANY, 'Users', 'account_id'),
			'Address'=>array(self::BELONGS_TO, 'Address', 'address_id')
		);
	}

	/**
	 * [attributeLabels description]
	 * @return [type] [description]
	 */
	public function attributeLabels()
	{
		return array(
			'account_id' => Yii::t('accounts','account_id'),
			'account_name' => Yii::t('accounts','account_name'),
			'account_logo' => Yii::t('accounts','account_logo'),
			'account_colorscheme' => Yii::t('accounts','account_colorscheme'),
			'account_companyName' => Yii::t('accounts','account_companyName'),
			'account_projectNumbers' => Yii::t('accounts','account_projectNumbers'), 
			'account_storageSize' => Yii::t('accounts','account_storageSize'),
			'account_uniqueId' => Yii::t('accounts','account_uniqueId'),
			'address_id' => Yii::t('accounts','address_id'),
			'timezone_id'=> Yii::t('accounts','timezone_id')
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
				'attributes' => array('account_name', 'account_companyName')
			),
		);
	}
}