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
	 * [actionIndex description]
	 * @return [type] [description]
	 */
	public function actionIndex()
	{
		if(Yii::app()->user->checkAccess('indexTasks'))
		{

			$view = (Yii::app()->user->getState('view') != null) ? Yii::app()->user->getState('view') : 'list'; 

			if ((isset($_GET['view'])) && (!empty($_GET['view'])))
			{
		        if ($_GET['view'] == 'grid')
				{
					$view = 'grid';
				}
		        elseif ($_GET['view'] == 'kanban')
				{
					$view = 'kanban';
				}
		        else
				{
					$view = 'list';
				}
			}

			Yii::app()->user->setState('view', $view);

			$criteria = new CDbCriteria();
			$criteria->compare('project_id', (int)Yii::app()->user->getState('project_selected'));
			$model = Tasks::model()->findAll($criteria);

			$Milestones = Milestones::model()->with('Projects.Company.Cusers')->together()->findAll(array(
				'condition'=>'Cusers.user_id = :user_id AND t.project_id = :project_id',
				'params'=>array(
					':user_id' => Yii::app()->user->id,
					':project_id' => Yii::app()->user->getState('project_selected')
				)
			));

			$Cases = Cases::model()->with('Projects.Company.Cusers')->together()->findAll(array(
				'condition'=>'Cusers.user_id = :user_id AND t.project_id = :project_id',
				'params'=>array(
					':user_id' => Yii::app()->user->id,
					':project_id' => Yii::app()->user->getState('project_selected')
				),
			));

			if(isset($_GET['TasksSearchForm']))
			{
				$model->attributes=$_GET['TasksSearchForm'];
			}

			if ($view == 'kanban')
			{
				$this->layout = 'column1';
			}
		        
			$this->render('index', array(
				'model'=>$model,
				'status'=>Status::model()->findAllOrdered(),
				'types'=>TaskTypes::model()->findAll(),
				'stages'=>TaskStages::model()->findAll(),
				'milestones'=>$Milestones,
				'cases'=>$Cases,
				'users'=>Projects::model()->findAllUsersByProject(Yii::app()->user->getState('project_selected')),
			));
		}
		else
		{
			throw new CHttpException(403, Yii::t('site', '403_Error'));
		}
	}
}