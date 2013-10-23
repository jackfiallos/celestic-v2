<?php

/**
 * Companies Model
 * 
 * @author		Jackfiallos
 * @version		2.0.0
 * @link		http://qbit.com.mx/labs/celestic
 * @copyright 	Copyright (c) 2009-2013 Qbit Mexhico
 * @license		http://qbit.com.mx/labs/celestic/license/
 * @description
 * 
 * This is the model class for table "tb_companies".
 */
class Companies extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'tb_companies':
	 * @var integer $company_id
	 * @var string $company_name
	 * @var string $company_url
	 * @var string $company_uniqueId
	 * @var double $company_latitude
	 * @var double $company_longitude
	 * @var integer $address_id
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
		return 'tb_companies';
	}

	/**
	 * [rules description]
	 * @return [type] [description]
	 */
	public function rules()
	{
		return array(
			array('company_name', 'required', 'message'=>Yii::t('inputValidations','RequireValidation')),
			array('company_uniqueId', 'required', 'on'=>'update', 'message'=>Yii::t('inputValidations','RequireValidation')),
			array('address_id', 'numerical', 'integerOnly'=>true),
			array('company_latitude, company_longitude', 'numerical'),
			array('company_name', 'length', 'max'=>100, 'message'=>Yii::t('inputValidations','MaxValidation')),
			array('company_name', 'length', 'min'=>9, 'message'=>Yii::t('inputValidations','MinValidation')),
			array('company_uniqueId', 'length', 'max'=>20, 'message'=>Yii::t('inputValidations','MaxValidation')),
			array('company_url', 'length', 'max'=>100, 'message'=>Yii::t('inputValidations','MaxValidation'))
		);
	}

	/**
	 * [relations description]
	 * @return [type] [description]
	 */
	public function relations()
	{
		return array(
			'Users'=>array(self::MANY_MANY, 'Users', 'tb_companies_has_tb_users(user_id,company_id)'),
			'Cusers'=>array(self::MANY_MANY, 'Users', 'tb_companies_has_tb_users(company_id,user_id)'),
			'Address'=>array(self::BELONGS_TO, 'Address', 'address_id'),
			'Projects'=>array(self::HAS_MANY, 'Projects', 'company_id')
		);
	}

	/**
	 * [attributeLabels description]
	 * @return [type] [description]
	 */
	public function attributeLabels()
	{
		return array(
			'company_id' => Yii::t('companies','company_id'),
			'company_name' => Yii::t('companies','company_name'),
			'company_url' => Yii::t('companies','company_url'),
			'company_uniqueId' => Yii::t('companies','company_uniqueId'),
			'company_latitude' => Yii::t('companies','company_latitude'),
			'company_longitude' => Yii::t('companies','company_longitude'),
			'address_id' => Yii::t('companies','address_id')
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
				'attributes' => array('company_name', 'company_url', 'company_uniqueId', 'company_latitude', 'company_longitude')
			),
		);
	}
	
	/**
	 * [findCompanyList description]
	 * @param  [type] $user_id [description]
	 * @return [type]          [description]
	 */
	public function findCompanyList($user_id)
	{
		return Companies::model()->with('Cusers.Accounts')->together()->findAll(array(
			'condition'=>'Cusers.user_id= :user_id',
			'params'=>array(
				':user_id' => $user_id
			)
		));
	}
	
	/**
	 * [hasCompanyRelation description]
	 * @param  [type]  $user_id    [description]
	 * @param  [type]  $company_id [description]
	 * @return boolean             [description]
	 */
	public function hasCompanyRelation($user_id, $company_id)
	{
		return Companies::model()->with('Cusers.Accounts')->count(array(
			'condition'=>'Cusers.user_id= :user_id AND t.company_id = :company_id',
			'params'=>array(
				':user_id' => $user_id,
				':company_id' => $company_id,
			),
			'together' => true
		));
	}
	
	/**
	 * [countCompaniesByAccount description]
	 * @param  [type] $company_id [description]
	 * @param  [type] $account_id [description]
	 * @return [type]             [description]
	 */
	public function countCompaniesByAccount($company_id, $account_id)
	{
		return Companies::model()->count(array(
			'condition'=>'t.company_id = :company_id AND Cusers.account_id = :account_id',
			'params'=>array(
				':account_id' => $account_id,
				':company_id' => $company_id
			),
			'with' => array(
				'Cusers'
			),
		));
	}
}