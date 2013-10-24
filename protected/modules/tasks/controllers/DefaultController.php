<?php
/**
 * DefaultController class file
 * 
 * @author		Jackfiallos
 * @version		2.0.0
 * @link		http://qbit.com.mx/labs/celestic
 * @copyright 	Copyright (c) 2009-2013 Qbit Mexhico
 * @license		http://qbit.com.mx/labs/celestic/license/
 * @description
 *
 **/
class DefaultController extends Controller
{
	/**
	 * [filters description]
	 * @return [type] [description]
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			array(
				'application.filters.YXssFilter',
				'clean'   => '*',
				'tags'    => 'strict',
				'actions' => 'all'
			)
		);
	}

	/**
	 * Especify access control rights
	 * @return array access rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', 
				'actions'=>array(
					'showworkers',
					'jointask',
					'relateddelete',
					'relatedcreate',
					'changestatus',
					'view',
					'create',
					'update',
					'delete',
					'index'
				),
				'users'=>array('@'),
				'expression'=>'!$user->isGuest'
			),
			array('deny',
				'users'=>array('*')
			)
		);
	}

	/**
	 * [getPriority description]
	 * @param  [type] $priorityId [description]
	 * @return [type]             [description]
	 */
	public function getPriority($priorityId)
	{
		$output = array();

		switch($priorityId)
		{
			case Cases::PRIORITY_LOW:
				$output = array(
					'priority' => Yii::t('site','lowPriority'),
					'class' => 'label-info'
				);
				break;
			case Cases::PRIORITY_MEDIUM:
				$output = array(
					'priority' => Yii::t('site','mediumPriority'),
					'class' => 'label-warning'
				);
				break;
			case Cases::PRIORITY_HIGH:
				$output = array(
					'priority' => Yii::t('site','highPriority'),
					'class' => 'label-important'
				);
				break;
			default:
				$output = array(
					'priority' => Yii::t('site','lowPriority'),
					'class' => 'label-info'
				);
				break;
		}

		return $output;
	}

	/**
	 * [actionIndex description]
	 * @return [type] [description]
	 */
	public function actionIndex()
	{
		if(Yii::app()->user->checkAccess('indexTasks'))
		{
			$project_id = (int)Yii::app()->user->getState('project_selected');

			$Milestones = Milestones::model()->with('Projects.Company.Cusers')->together()->findAll(array(
				'condition'=>'Cusers.user_id = :user_id AND t.project_id = :project_id',
				'params'=>array(
					':user_id' => Yii::app()->user->id,
					':project_id' => $project_id
				)
			));

			$Cases = Cases::model()->with('Projects.Company.Cusers')->together()->findAll(array(
				'condition'=>'Cusers.user_id = :user_id AND t.project_id = :project_id',
				'params'=>array(
					':user_id' => Yii::app()->user->id,
					':project_id' => $project_id
				)
			));

			// set model attributes from milestones form
			if (Yii::app()->request->isPostRequest)
			{
				$criteria = new CDbCriteria();
				$criteria->compare('project_id', $project_id);
				$model = Tasks::model()->with('UserReported','Status')->together()->findAll($criteria);
				$tasks = array();

				if ($model !== null)
				{
					foreach ($model as $task) {
						array_push($tasks, array(
							'task_id'=>$task->task_id,
							'task_name'=>$task->task_name,
							'userName'=>ucfirst(CHtml::encode($task->UserReported->completeName)),
							'userUrl'=>$this->createUrl('users/view', array('id'=>$task->user_id)),
							'status_name'=>CHtml::encode($task->Status->status_name),
							'statusCss'=>'label-'.strtolower(str_replace(" ", "", $task->Status->status_name)),
							'task_description'=>$task->task_description,
							'task_priority'=>$this->getPriority($task->task_priority)['priority'],
							'task_priorityCss'=>$this->getPriority($task->task_priority)['class'],
							'countComments'=>Logs::getCountComments('tasks', $task->task_id),
							'due_date_day'=>CHtml::encode(Yii::app()->dateFormatter->format('dd', $task->task_endDate)),
							'due_date_month'=>CHtml::encode(Yii::app()->dateFormatter->format('MMM', $task->task_endDate)),
							'due_date_year'=>CHtml::encode(Yii::app()->dateFormatter->format('yyyy', $task->task_endDate))
						));
					}
				}

				header('Content-type: application/json');
				echo CJSON::encode(array(
					'tasks'=>$tasks
				));
				Yii::app()->end();
			}
		        
			$this->render('index', array(
				'model'=>new Tasks,
				'status'=>Status::model()->findAll(),
				'types'=>TaskTypes::model()->findAll(),
				'stages'=>TaskStages::model()->findAll(),
				'milestones'=>$Milestones,
				'cases'=>$Cases,
				'allowEdit'=>true,
			));
		}
		else
		{
			throw new CHttpException(403, Yii::t('site', '403_Error'));
		}
	}
}