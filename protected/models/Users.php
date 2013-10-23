<?php

/**
 * Users Model
 * 
 * @author		Jackfiallos
 * @version		2.0.0
 * @link		http://qbit.com.mx/labs/celestic
 * @copyright 	Copyright (c) 2009-2013 Qbit Mexhico
 * @license		http://qbit.com.mx/labs/celestic/license/
 * @description
 * 
 * This is the model class for table "tb_users".
 */
class Users extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'tb_users':
	 * @var integer $user_id
	 * @var string $user_name
	 * @var string $user_lastname
	 * @var string $user_email
	 * @var string $user_phone
	 * @var integer $user_admin
	 * @var integer $user_password
	 * @var integer $user_active
	 * @var integer $account_id
	 * @var integer $address_id
	 * @var integer $user_accountManager
	 * @var datetime $user_lastLogin
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
		return 'tb_users';
	}

	/**
	 * [rules description]
	 * @return [type] [description]
	 */
	public function rules()
	{
		return array(
			array('user_name, user_lastname, user_email, user_admin, user_active, account_id, user_accountManager, user_password', 'required', 'message'=>Yii::t('inputValidations','RequireValidation')),
			array('user_name, user_lastname', 'length', 'min'=>3, 'message'=>Yii::t('inputValidations','MinValidation')),
			array('user_admin, user_active, account_id, address_id, user_accountManager', 'numerical', 'integerOnly'=>true),
			array('user_name, user_lastname, user_email', 'length', 'max'=>45, 'message'=>Yii::t('inputValidations','MaxValidation')),
			array('user_phone', 'length', 'max'=>30, 'message'=>Yii::t('inputValidations','MaxValidation')),
			array('user_password', 'length', 'max'=>20, 'min'=>6, 'on'=>array('create'), 'message'=>Yii::t('inputValidations','BetweenValidation')),
			array('user_password', 'length', 'min'=>6, 'on'=>array('update'), 'message'=>Yii::t('inputValidations','MinValidation')),
			array('user_email', 'email', 'message'=>Yii::t('inputValidations','EmailValidation')),
			array('user_email', 'unique', 'message'=>Yii::t('inputValidations','UniqueValidation'))
		);
	}

	/**
	 * [relations description]
	 * @return [type] [description]
	 */
	public function relations()
	{
		return array(
			'Clients'=>array(self::HAS_ONE, 'Clients', 'user_id'),
			'Accounts'=>array(self::BELONGS_TO, 'Accounts', 'account_id'),
			'Companies'=>array(self::MANY_MANY, 'Companies', 'tb_companies_has_tb_users(user_id,company_id)'),
			'Cuser'=>array(self::HAS_MANY, 'CompaniesHasUsers', 'user_id'),
			'Managers'=>array(self::MANY_MANY, 'ProjectsHasUsers', 'tb_projects_has_tb_users(user_id,project_id)'),
			'ClientsManagers'=>array(self::MANY_MANY, 'Projects', 'tb_projects_has_tb_users(user_id,project_id)'),
			'Tasks'=>array(self::MANY_MANY, 'Tasks', 'tb_users_has_tb_tasks(user_id,task_id)'),
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
			'user_id' => Yii::t('users','user_id'),
			'user_name' => Yii::t('users','user_name'),
			'user_lastname' => Yii::t('users','user_lastname'),
			'user_email' => Yii::t('users','user_email'),
			'user_phone' => Yii::t('users','user_phone'),
			'user_admin' => Yii::t('users','user_admin'),
			'user_password' => Yii::t('users','user_password'),
			'user_active' => Yii::t('users','user_active'),
			'account_id' => Yii::t('users','account_id'),
			'address_id' => Yii::t('users','address_id'),
			'user_accountManager' => Yii::t('users','user_accountManager'),
			'user_lastLogin' => Yii::t('users','user_lastLogin')
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
				'attributes' => array('user_name', 'user_lastname', 'user_email', 'user_phone')
			)
		);
	}
	
	/**
	 * [findUsersAndClientsByAccount description]
	 * @param  [type] $account_id [description]
	 * @return [type]             [description]
	 */
	public function findUsersAndClientsByAccount($account_id)
	{
		return Users::model()->with('Accounts')->together()->findAll(array(
			'condition'=>'t.account_id = :account_id',
			'params'=>array(
				':account_id' => $account_id
			)
		));
	}
	
	/**
	 * [findUserWithoutAccountManager description]
	 * @return [type] [description]
	 */
	public function findUserWithoutAccountManager()
	{
		return Users::model()->findAll(array(
			'condition'=>'t.account_id = :account_id AND t.user_accountManager <> 1',
			'params'=>array(
				':account_id' => Yii::app()->user->Accountid
			),
		));
	}
	
	/**
	 * [findUsersByAccount description]
	 * @param  [type] $account_id [description]
	 * @param  [type] $company_id [description]
	 * @return [type]             [description]
	 */
	public function findUsersByAccount($account_id, $company_id)
    {
        return Users::model()->with('Clients','Companies')->together()->findAll(array(
			'select'=>'t.user_id, t.user_name, t.user_lastname',
			'condition'=>'t.account_id = :account_id 
				AND Clients.client_id IS NULL 
				/*AND Companies_Companies.company_id != :company_id */
				AND t.user_id NOT IN (
					SELECT tbc.user_id  
					FROM tb_companies_has_tb_users tbc
					WHERE tbc.company_id = :company_id 
				)',
			'params'=>array(
				':account_id'=>$account_id,
				':company_id'=>$company_id
			),
			'order'=>'t.user_name',
			'group'=>'t.user_id'
		));
    }
	
	/**
	 * [findClientsByAccount description]
	 * @param  [type] $account_id [description]
	 * @param  [type] $company_id [description]
	 * @return [type]             [description]
	 */
	public function findClientsByAccount($account_id, $company_id)
    {
        return Users::model()->with('Clients','Companies')->together()->findAll(array(
			'select'=>'t.user_id, t.user_name, t.user_lastname',
			'condition'=>'t.account_id = :account_id 
				AND Clients.client_id IS NOT NULL 
				AND t.user_id NOT IN (
					SELECT tbc.user_id  
					FROM tb_companies_has_tb_users tbc
					WHERE tbc.company_id = :company_id 
				)',
			'params'=>array(
				':account_id'=>$account_id,
				':company_id'=>$company_id
			),
			'order'=>'t.user_name',
			'group'=>'t.user_id'
		));
    }
	
	/**
	 * [findUsersByProject description]
	 * @param  [type] $project_id [description]
	 * @return [type]             [description]
	 */
	public function findUsersByProject($project_id)
	{
		return Users::model()->with('Clients','Companies.Projects')->together()->findAll(array(
			'condition'=>'Projects.project_id = :project_id AND Clients.client_id IS NULL',
			'params'=>array(
				':project_id' => $project_id
			),
			'order'=>'t.user_name'
		));
	}
	
	/**
	 * [findClientsByProject description]
	 * @param  [type] $project_id [description]
	 * @return [type]             [description]
	 */
	public function findClientsByProject($project_id)
	{
		return Users::model()->with('Clients','Companies.Projects')->together()->findAll(array(
			'condition'=>'Projects.project_id = :project_id AND Clients.client_id IS NOT NULL',
			'params'=>array(
				':project_id' => $project_id
			),
			'order'=>'t.user_name'
		));
	}
	
	/**
	 * [findUsersAndClientsByProject description]
	 * @param  [type] $project_id [description]
	 * @return [type]             [description]
	 */
	public function findUsersAndClientsByProject($project_id)
	{
		return Users::model()->with('Companies.Projects')->together()->findAll(array(
			'addCondition'=>'Projects.project_id = :project_id',
			'params'=>array(
				':project_id' => $project_id
			),
			'order'=>'t.user_name',
		));
	}
	
	/**
	 * Scope
	 * @param  [type] $list [description]
	 * @return [type]       [description]
	 */
	public function filterManagers($list)
	{
        $this->getDbCriteria()->mergeWith(array(
            'condition' => 't.user_id NOT IN ('.implode(',',$list).')',
        ));
        
        return $this;
    }
	
	/**
	 * [getCompleteName description]
	 * @return [type] [description]
	 */
	public function getCompleteName()
	{
		return $this->user_name." ".$this->user_lastname;
	}
	
	/**
	 * [verifyUserInProject description]
	 * @param  [type] $project_id [description]
	 * @param  [type] $user_id    [description]
	 * @return [type]             [description]
	 */
	public function verifyUserInProject($project_id, $user_id)
	{
		$count = Users::model()->with('ClientsManagers')->together()->count(array(
			'condition'=>'ClientsManagers.project_id = :project_id AND t.user_id = :user_id AND 1=1',
			'params'=> array(
				':project_id'=>$project_id,
				':user_id'=>$user_id
			)
		));
		
		if ($count > 0)
		{
			return true;
		}
		
		return false;
	}
	
	/**
	 * [findWorkersByTask description]
	 * @param  [type] $task_id [description]
	 * @return [type]          [description]
	 */
	public function findWorkersByTask($task_id)
	{
		return Users::model()->with('Tasks')->together()->findAll(array(
			'condition'=>'Tasks.task_id = :task_id',
			'params'=>array(
				':task_id' => $task_id
			),
			'group'=>'t.user_id'
		));
	}
	
	/**
	 * [countWorkersByTask description]
	 * @param  [type] $task_id [description]
	 * @return [type]          [description]
	 */
	public function countWorkersByTask($task_id)
	{
		return Users::model()->with('Tasks')->together()->count(array(
			'select'=>'t.user_id',
			'condition'=>'Tasks.task_id = :task_id',
			'params'=>array(
				':task_id' => $task_id
			),
			'group'=>'t.user_id'
		));
	}
	
	/**
	 * [countUsersByAccount description]
	 * @param  [type] $user_id    [description]
	 * @param  [type] $account_id [description]
	 * @return [type]             [description]
	 */
	public function countUsersByAccount($user_id, $account_id)
	{
		return Users::model()->count(array(
			'condition'=>'t.user_id = :user_id AND t.account_id = :account_id',
			'params'=>array(
				':account_id' => $account_id,
				':user_id' => $user_id
			)
		));
	}

	/**
	 * [availablesUsersToTakeTask description]
	 * @param  [type] $project_id [description]
	 * @param  [type] $task_id    [description]
	 * @return [type]             [description]
	 */
	public function availablesUsersToTakeTask($project_id, $task_id)
	{
		$Users = Users::model()->with('Tasks')->findAll(array(
			'condition'=>'Tasks.task_id = :task_id',
			'params'=>array(
				':task_id'=>$task_id
			)
		));
		
		$usersArray = array(0);
		
		foreach($Users as $user)
		{
			array_push($usersArray, $user->user_id);
		}
		
		return Users::model()->with('ClientsManagers')->together()->findAll(array(
			'condition'=>'ClientsManagers.project_id = :project_id AND t.user_id NOT IN ('.implode(",",$usersArray).')',
			'params'=>array(
				':project_id'=>$project_id
			)
		));
	}
}