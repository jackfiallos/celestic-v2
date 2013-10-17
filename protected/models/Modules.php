<?php

/**
 * Modules Model
 * 
 * @author		Jackfiallos
 * @link		http://qbit.com.mx/labs/celestic
 * @copyright 	Copyright (c) 2009-2013 Qbit Mexhico
 * @license		http://qbit.com.mx/labs/celestic/license/
 * @version		2.0.0
 * 
 * This is the model class for table "tb_modules".
 *
 * The followings are the available columns in table 'tb_modules':
 * @property integer $module_id
 * @property string $module_name
 * @property string $module_className
 * @property string $module_title
 * @property integer $module_useNotifications
 * @property integer $module_useSearchs
 */
class Modules extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Modules the static model class
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
        return 'tb_modules';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('module_name, module_className, module_title', 'required'),
            array('module_useNotifications, module_useSearchs', 'numerical', 'integerOnly'=>true),
            array('module_name, module_className, module_title', 'length', 'max'=>45),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('module_id, module_name, module_className, module_title, module_useNotifications, module_useSearchs', 'safe', 'on'=>'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'module_id' => 'Module',
            'module_name' => 'Module Name',
            'module_className' => 'Module Class Name',
            'module_title' => 'Module Title',
            'module_useNotifications' => 'Module Use Notifications',
            'module_useSearchs' => 'Module Use Searchs',
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
				'attributes' => array('module_name'),
			),
		);
	}
}