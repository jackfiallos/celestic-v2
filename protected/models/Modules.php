<?php

/**
 * Modules Model
 * 
 * @author		Jackfiallos
 * @version		2.0.0
 * @link		http://qbit.com.mx/labs/celestic
 * @copyright 	Copyright (c) 2009-2013 Qbit Mexhico
 * @license		http://qbit.com.mx/labs/celestic/license/
 * @description
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
        return 'tb_modules';
    }

    /**
     * [rules description]
     * @return [type] [description]
     */
    public function rules()
    {
        return array(
            array('module_name, module_className, module_title', 'required'),
            array('module_useNotifications, module_useSearchs', 'numerical', 'integerOnly'=>true),
            array('module_name, module_className, module_title', 'length', 'max'=>45)
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
            'module_id' => 'Module',
            'module_name' => 'Module Name',
            'module_className' => 'Module Class Name',
            'module_title' => 'Module Title',
            'module_useNotifications' => 'Module Use Notifications',
            'module_useSearchs' => 'Module Use Searchs'
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
				'attributes' => array('module_name')
			)
		);
	}
}