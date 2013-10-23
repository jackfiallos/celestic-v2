<?php

/**
 * Projects Model
 * 
 * @author		Jackfiallos
 * @version		2.0.0
 * @link		http://qbit.com.mx/labs/celestic
 * @copyright 	Copyright (c) 2009-2013 Qbit Mexhico
 * @license		http://qbit.com.mx/labs/celestic/license/
 * @description
 * 
 * This is the model class for table "tb_projects".
 *
 * The followings are the available columns in table 'tb_projects':
 * @property integer $project_id
 * @property string $project_name
 * @property string $project_description
 * @property string $project_scope
 * @property string $project_restrictions
 * @property string $project_plataform
 * @property string $project_swRequirements
 * @property string $project_hwRequirements
 * @property string $project_startDate
 * @property string $project_endDate
 * @property integer $project_active
 * @property string project_functionalReq
 * @property string project_performanceReq
 * @property string project_additionalComments
 * @property string project_userInterfaces
 * @property string project_hardwareInterfaces
 * @property string project_softwareInterfaces
 * @property string project_communicationInterfaces
 * @property string project_backupRecovery
 * @property string project_dataMigration
 * @property string project_userTraining
 * @property string project_installation
 * @property string project_assumptions
 * @property string project_outReach
 * @property string project_responsibilities
 * @property string project_warranty
 * @property string project_additionalCosts
 * @property integer currency_id
 * @property integer $company_id
 */
class Projects extends CActiveRecord
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
		return 'tb_projects';
	}

	/**
	 * [rules description]
	 * @return [type] [description]
	 */
	public function rules()
	{
		return array(
			array('project_name, project_description, project_plataform, project_startDate, project_endDate, company_id, currency_id', 'required', 'message'=>Yii::t('inputValidations','RequireValidation')),
			array('project_active', 'numerical', 'integerOnly'=>true),
			array('company_id', 'numerical', 'integerOnly'=>true),
			array('currency_id', 'numerical', 'integerOnly'=>true),
			array('project_name', 'length', 'max'=>100, 'message'=>Yii::t('inputValidations','MaxValidation')),
			array('project_name', 'length', 'min'=>10, 'message'=>Yii::t('inputValidations','MinValidation')),
			array('project_restrictions, project_scope, project_swRequirements, project_hwRequirements, project_functionalReq, project_performanceReq, project_additionalComments, project_userInterfaces, project_hardwareInterfaces, project_softwareInterfaces, project_communicationInterfaces, project_backupRecovery, project_dataMigration, project_userTraining, project_installation, project_assumptions, project_outReach, project_responsibilities, project_warranty, project_additionalCosts', 'length', 'max'=>4000, 'message'=>Yii::t('inputValidations','MaxValidation'))
		);
	}

	/**
	 * [relations description]
	 * @return [type] [description]
	 */
	public function relations()
	{
		return array(
			'Company'=>array(self::BELONGS_TO, 'Companies', 'company_id'),
			'Currency'=>array(self::BELONGS_TO, 'Currencies', 'currency_id'),
			'Users'=>array(self::MANY_MANY, 'Users', 'tb_projects_has_tb_users(user_id,project_id)'),
			'Cusers'=>array(self::MANY_MANY, 'Users', 'tb_projects_has_tb_users(project_id,user_id)'),
			'Budgets'=>array(self::HAS_MANY, 'Budgets', 'project_id')
		);
	}

	/**
	 * [attributeLabels description]
	 * @return [type] [description]
	 */
	public function attributeLabels()
	{
		return array(
			//Analysis Parameters
			'project_id' => Yii::t('projects','project_id'),
			'project_name' => Yii::t('projects','project_name'),
			'project_description' => Yii::t('projects','project_description'),
			'project_scope' => Yii::t('projects','project_scope'),
			'project_restrictions' => Yii::t('projects','project_restrictions'),
			'project_plataform' => Yii::t('projects','project_plataform'),
			'project_swRequirements' => Yii::t('projects','project_swRequirements'),
			'project_hwRequirements' => Yii::t('projects','project_hwRequirements'),
			'project_startDate' => Yii::t('projects','project_startDate'),
			'project_endDate' => Yii::t('projects','project_endDate'),
			'project_active' => Yii::t('projects','project_active'),
			'company_id' => Yii::t('projects','company_id'),
			'currency_id' => Yii::t('projects','currency_id'),
			'project_additionalCosts' => Yii::t('projects','project_additionalCosts'),
			'project_responsibilities' => Yii::t('projects','project_responsibilities'),
			//External Interfaces
			'project_userInterfaces' => Yii::t('projects','project_userInterfaces'),
			'project_hardwareInterfaces' => Yii::t('projects','project_hardwareInterfaces'),
			'project_softwareInterfaces' => Yii::t('projects','project_softwareInterfaces'),
			'project_communicationInterfaces' => Yii::t('projects','project_communicationInterfaces'),
			//Specific Requirements
			'project_functionalReq' => Yii::t('projects','project_functionalReq'),
			'project_performanceReq' => Yii::t('projects','project_performanceReq'),
			'project_additionalComments' => Yii::t('projects','project_additionalComments'),
			//Special User Requirements
			'project_backupRecovery' => Yii::t('projects','project_backupRecovery'),
			'project_dataMigration' => Yii::t('projects','project_dataMigration'),
			'project_userTraining' => Yii::t('projects','project_userTraining'),
			'project_installation' => Yii::t('projects','project_installation'),
			//Special Considerations
			'project_assumptions' => Yii::t('projects','project_assumptions'),
			'project_outReach' => Yii::t('projects','project_outReach'),
			'project_warranty' => Yii::t('projects','project_warranty')
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
				'attributes' => array(
					'project_name',
					'project_description',
					'project_scope',
					'project_restrictions',
					'project_plataform',
					'project_swRequirements',
					'project_hwRequirements',
					'project_startDate',
					'project_endDate',
					'project_userInterfaces',
					'project_hardwareInterfaces',
					'project_softwareInterfaces',
					'project_communicationInterfaces',
					'project_functionalReq',
					'project_performanceReq',
					'project_additionalComments',
					'project_backupRecovery',
					'project_dataMigration',
					'project_userTraining',
					'project_installation',
					'project_assumptions',
					'project_outReach',
					'project_responsibilities',
					'project_warranty',
					'project_additionalCosts'
				)
			)
		);
	}
	
	/**
	 * [countProjects description]
	 * @param  [type] $project_id [description]
	 * @return [type]             [description]
	 */
	public function countProjects($project_id)
	{
		return Projects::model()->count(array(
			'condition'=>'t.project_id = :project_id',
			'params'=>array(
				':project_id' => $project_id
			)	
		));
	}
	
	/**
	 * [findMyProjects description]
	 * @param  [type] $userId [description]
	 * @return [type]         [description]
	 */
	public function findMyProjects($userId)
    {
    	$projects = Projects::model()->with('Company.Cusers')->together()->findAll(array(
			'condition'=>'Cusers.user_id = :user_id AND t.project_active = 1',
			'params'=>array(
				':user_id' => $userId
			),
			'group'=>'t.project_id'
		));
		
		if (count($projects) <= 0)
		{
			return array();
		}
		
		return $projects;
    }
	
	/**
	 * [hasProject description]
	 * @param  [type]  $user_id    [description]
	 * @param  [type]  $project_id [description]
	 * @return boolean             [description]
	 */
	public function hasProject($user_id, $project_id)
	{
		$criteria = new CDbCriteria;
		$criteria->condition = "Cusers.user_id = :user_id AND t.project_id = :project_id AND t.project_active = 1";
		$criteria->params = array(
			':user_id' => $user_id,
			':project_id' => $project_id
		);
		
		return Projects::model()->with('Company.Cusers')->together()->find($criteria);
	}
	
	/**
	 * [getProjectCost description]
	 * @param  [type] $project_id [description]
	 * @return [type]             [description]
	 */
	public function getProjectCost($project_id)
	{
		return Budgets::model()->with('BudgetsConcepts')->together()->find(array(
			'select'=>'t.budget_id AS c, SUM(BudgetsConcepts.budgetsConcept_amount) AS total',
			'condition'=>'t.project_id = :project_id AND t.status_id IN ('.implode(',', array(Status::STATUS_ACCEPTED, Status::STATUS_PENDING)).')',
			'params'=>array(
				':project_id' => $project_id
			),
			'group'=>'t.budget_id'
		));
	}
	
	/**
	 * [getProjectProgress description]
	 * @param  [type] $project_id [description]
	 * @return [type]             [description]
	 */
	public function getProjectProgress($project_id)
	{
		// ( total_tasks_per_status / total_tasks ) / status_value
		$criteria = new CDbCriteria;
		$criteria->select = '(ROUND((COUNT(t.task_id)/(SELECT COUNT(*) FROM tb_tasks tb WHERE tb.project_id = :project_id))*Status.status_value)) AS progress';
		$criteria->condition = 't.project_id = :project_id';
		$criteria->params = array(
			':project_id' => $project_id
		);
		$criteria->group = 't.status_id';
		$criteria->order = 't.task_startDate ASC';
		
		return Tasks::model()->with('Status')->together()->find($criteria);
	}
	
	/**
	 * [findManagersByProject description]
	 * @param  [type] $project_id [description]
	 * @return [type]             [description]
	 */
	public function findManagersByProject($project_id)
	{
		return Users::model()->with('ClientsManagers')->together()->findAll(array(
			'condition'=>'ClientsManagers.project_id = :project_id',//AND ClientsManagers_ClientsManagers.isManager = 1',
			'params'=>array(
				':project_id' => $project_id
			),
			'order'=>'t.user_name'
		));
	}
	
	/**
	 * [findAvailablesManagersByProject description]
	 * @param  [type] $project_id [description]
	 * @return [type]             [description]
	 */
	public function findAvailablesManagersByProject($project_id)
	{
		$Managers = $this->findManagersByProject($project_id);
		
		$managerList = array();

		if(count($Managers) > 0)
		{
			foreach($Managers as $users)
			{
				array_push($managerList, $users->user_id);
			}
		}
		else
		{
			array_push($managerList, -1);
		}
		
		return Users::model()->with('Companies')->together()->findAll(array(
			'condition'=>'Companies.company_id = :company_id AND t.user_id NOT IN ('.implode(",", $managerList).')',
			'params'=>array(
				':company_id'=>Projects::model()->findByPk(Yii::app()->user->getState('project_selected'))->company_id,
			),
			'order'=>'t.user_name ASC'
		));
	}
	
	/**
	 * [findAllUsersByProject description]
	 * @param  [type] $project_id [description]
	 * @return [type]             [description]
	 */
	public function findAllUsersByProject($project_id)
	{
		return Users::model()->with('ClientsManagers')->together()->findAll(array(
			'condition'=>'ClientsManagers.project_id = :project_id',
			'params'=>array(
				':project_id' => $project_id
			),
			'group'=>'t.user_id'
		));
	}
}