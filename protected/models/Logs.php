<?php

/**
 * Logs Model
 * 
 * @author		Jackfiallos
 * @version		2.0.0
 * @link		http://qbit.com.mx/labs/celestic
 * @copyright 	Copyright (c) 2009-2013 Qbit Mexhico
 * @license		http://qbit.com.mx/labs/celestic/license/
 * @description
 * 
 * This is the model class for table "tb_logs".
 *
 * The followings are the available columns in table 'tb_logs':
 * @property integer $log_id
 * @property string $log_date
 * @property string $log_activity
 * @property integer $log_resourceid
 * @property integer $log_type
 * @property integer $log_commentid
 * @property integer $user_id
 * @property integer $module_id
 * @property integer $project_id
 *
 * The followings are the available model relations:
 */
class Logs extends CActiveRecord
{
	const LOG_CREATED   = 'created';
	const LOG_UPDATED   = 'updated';
	const LOG_DELETED   = 'deleted';
	const LOG_COMMENTED = 'comment';
	const LOG_ASSIGNED  = 'assigned';
	const LOG_REVOKED   = 'revoked';
	
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
		return 'tb_logs';
	}

	/**
	 * [rules description]
	 * @return [type] [description]
	 */
	public function rules()
	{
		return array(
			array('log_date, log_activity, log_resourceid, log_type, user_id, module_id', 'required'),
			array('log_commentid, log_resourceid, user_id, module_id, project_id', 'numerical', 'integerOnly'=>true),
			array('log_activity', 'length', 'max'=>45),
			array('log_type', 'length', 'max'=>20)
		);
	}

	/**
	 * [relations description]
	 * @return [type] [description]
	 */
	public function relations()
	{
		return array(
			'User'=>array(self::BELONGS_TO, 'Users', 'user_id'),
			'Module'=>array(self::BELONGS_TO, 'Modules', 'module_id'),
			'Project'=>array(self::BELONGS_TO, 'Projects', 'project_id')
		);
	}

	/**
	 * [attributeLabels description]
	 * @return [type] [description]
	 */
	public function attributeLabels()
	{
		return array(
			'log_id' => 'Log',
			'log_date' => 'Date',
			'log_activity' => 'Activity',
			'log_resourceid' => 'Resource id',
			'log_type' => 'Type',
			'log_commentid' => 'Comment id',
			'user_id' => 'User',
			'module_id' => 'Module',
			'project_id'=>'Project'
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
				'attributes' => array('log_date', 'log_activity', 'log_resourceid', 'log_type', 'user_id', 'module_id', 'project_id')
			),
		);
	}
	
	/**
	 * [findActivity description]
	 * @param  [type]  $module      [description]
	 * @param  [type]  $projectList [description]
	 * @param  integer $limit       [description]
	 * @return [type]               [description]
	 */
	public function findActivity($module, $projectList, $limit = 7)
    {
		if (count($projectList) <= 0)
		{
			$projectList = array(-1);
		}
		
    	return Logs::model()->with('Module')->together()->findAll(array(
			'condition'=>'t.log_activity NOT LIKE "%Comment%" AND t.project_id <> 0 AND t.project_id IN ('.implode(",", $projectList).')', //AND Module.module_name LIKE ("'.$module.'")',
			'params'=>array(
				':module_name'=>$module,
				':project_id'=>implode(",", $projectList)
			),
			'order'=>'t.log_id DESC',
			'limit'=>$limit
		));
    }
	
	/**
	 * [saveLog description]
	 * @param  [type]  $modelAttributes [description]
	 * @param  boolean $sendMail        [description]
	 * @return [type]                   [description]
	 */
	public function saveLog($modelAttributes, $sendMail = false)
	{	
		$module = Modules::model()->find(array(
			'condition'=>'t.module_name = :module_name',
			'params'=>array(
				':module_name'=>$modelAttributes['module_id']
			)
		));
		
		$modelAttributes['module_id'] = $module->module_id;
		
		$model=new Logs;
		$model->attributes=$modelAttributes;
		
		if($model->save())
		{
			/*if ($sendMail)
				$this->sendEmailAlert($modelAttributes);*/
		}
	}
	
	/**
	 * [sendEmailAlert description]
	 * @param  [type] $attributes [description]
	 * @return [type]             [description]
	 */
	private function sendEmailAlert($attributes)
	{
		$recipients = Users::model()->with('Companies.Projects')->together()->findAll(array(
			'condition'=>'Projects.project_id = '.$attributes['project_id']
		));
		
		$recipientsList = array();
		foreach($recipients as $user)
		{
			array_push($recipientsList, $user->user_email);
		}
			
		$str;
		Yii::import('application.extensions.miniTemplator.miniTemplator');
		$t = new miniTemplator;
		$t->readTemplateFromFile("templates/ActivityCreation.tpl");
		$t->setVariable ("applicationName",Yii::app()->name);
		$t->setVariable ("project",Projects::model()->findByPk($attributes['project_id'])->project_name);
		$t->setVariable ("logActivity",$attributes['log_activity']);
		$t->setVariable ("activityCreatedByUser",Users::model()->findByPk($attributes['user_id'])->CompleteName);
		$t->setVariable ("date",$attributes['log_date']);
		$t->setVariable ("applicationUrl", "http://".$_SERVER['SERVER_NAME'].Yii::app()->request->baseUrl);
		$t->generateOutputToString($str);
		
		$subject = "Activity Notification";
		
		Yii::import('application.extensions.phpMailer.yiiPhpMailer');
		$mailer = new yiiPhpMailer;
		$mailer->Ready($subject, $str, $recipientsList);
	}
	
	/**
	 * [getCountComments description]
	 * @param  [type] $module_name [description]
	 * @param  [type] $resource_id [description]
	 * @return [type]              [description]
	 */
	public static function getCountComments($module_name, $resource_id)
	{
		return (int)Logs::model()->with('Module')->together()->count(array(
			'condition'=>'Module.module_name = :module_name AND t.log_resourceid = :resource_id AND t.log_commentid <> 0',
			'params'=>array(
				':module_name' => $module_name,
				':resource_id' => (int)$resource_id
			)
		));
	}

	/**
	 * [getTitleFromLogItem description]
	 * @param  [type] $id        [description]
	 * @param  [type] $className [description]
	 * @param  [type] $itemTitle [description]
	 * @return [type]            [description]
	 */
	public function getTitleFromLogItem($id, $className, $itemTitle)
	{
		if (class_exists($className))
		{
			$class = new $className;
			return $class->findByPk($id)->$itemTitle;
		}
		
		return "";
	}
}