<?php

/**
 * Timezones Model
 * 
 * @author		Jackfiallos
 * @link		http://qbit.com.mx/labs/celestic
 * @copyright 	Copyright (c) 2009-2013 Qbit Mexhico
 * @license		http://qbit.com.mx/labs/celestic/license/
 * @version		2.0.0
 * 
 * This is the model class for table "tb_timezones".
 *
 * The followings are the available columns in table 'tb_timezones':
 * @property integer $timezone_id
 * @property string $timezone_name
 */
class Timezones extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Timezones the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tb_timezones';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('timezone_name', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('timezone_id, timezone_name', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'Accounts'=>array(self::HAS_MANY, 'Accounts', 'timezone_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'timezone_id' => 'Timezone',
			'timezone_name' => 'Timezone Name',
		);
	}
	
	/**
	 * [getTimezoneSelected description]
	 * @param  [type] $account_id [description]
	 * @return [type]             [description]
	 */
	public static function getTimezoneSelected($account_id)
	{
		$criteria = new CDbCriteria;
		$criteria->condition = 'Accounts.account_id = 1';
		$criteria->params = array(
			':account_id'=>$account_id,
		);
		
		return Timezones::model()->with('Accounts')->together()->find($criteria);
	}
}