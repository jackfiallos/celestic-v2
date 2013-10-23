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
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

	/**
	 * Lists all models.
	 * @return index view
	 */
	public function actionIndex()
	{
		// check if user has permission to indexCases
		if(Yii::app()->user->checkAccess('indexCases'))
		{
			$criteria = new CDbCriteria();
			$criteria->compare('project_id', (int)Yii::app()->user->getState('project_selected'));

			// create Cases form search
			$cases = Cases::model()->findAll($criteria);

			if(Yii::app()->request->isPostRequest)
			{
				$case = array();
				foreach($cases as $item)
				{
					$timestamp = strtotime($item->case_date);
					$priority = '';
					$class = '';

					switch($item->case_priority)
                   	{
						case Cases::PRIORITY_LOW:
							$priority = Yii::t('site','lowPriority');
							$class = 'label-info';
							break;
						case Cases::PRIORITY_MEDIUM:
							$priority = Yii::t('site','mediumPriority');
							$class = 'label-warning';
							break;
						case Cases::PRIORITY_HIGH:
							$priority = Yii::t('site','highPriority');
							$class = 'label-important';
							break;
						default:
							$priority = Yii::t('site','lowPriority');
							$class = 'label-info';
							break;
                    }

					array_push($case, array(
						'id'=>$item->case_id,
						'name'=>CHtml::encode($item->case_name),
						'code'=>CHtml::encode($item->case_code),
						'status'=>CHtml::encode($item->Status->status_name),
						'statusCss'=>'label-'.strtolower(str_replace(" ", "", $item->Status->status_name)),
						'actors'=>CHtml::encode($item->case_actors),
						'description'=>CHtml::encode($item->case_description),
						'url'=>$this->createUrl('index', array('#'=>'/view/'.$item->case_id)),
						'timestamp'=>Yii::app()->dateFormatter->format('MMMM d, yyy', $timestamp),
						'countComments'=>Logs::getCountComments('cases', $item->case_id),
						'priority'=>$priority,
						'cssClass'=>$class
					));
				}
				
				header('Content-type: application/json');
				echo CJSON::encode(array(
					'cases'=>$case
				));
				Yii::app()->end();
			}
			
			$this->render('index', array(
				'model'=>new Cases
			));
		}
		else
		{
			throw new CHttpException(403, Yii::t('site', '403_Error'));
		}
	}

	/**
	 * Creates a new model.
	 * @return create view
	 */
	public function actionCreate()
	{
		// check if user has permissions to createCases
		if (Yii::app()->user->checkAccess('createCases'))
		{
			// create Cases object model
			$model = new Cases;

			// if Cases form exist and was sent
			if (isset($_POST['Cases']))
			{
				// set form elements to Budgets model attributes
				$model->attributes=$_POST['Cases'];
				$model->case_date = date("Y-m-d");
				$model->project_id = Yii::app()->user->getState('project_selected');
				
				// validate milestone model
				if ($model->validate())
				{
					// validate and save
					if ($model->save())
					{
						// save log
						$attributes = array(
							'log_date' => date("Y-m-d G:i:s"),
							'log_activity' => 'CaseCreated',
							'log_resourceid' => $model->primaryKey,
							'log_type' => Logs::LOG_CREATED,
							'user_id' => Yii::app()->user->id,
							'module_id' => Yii::app()->controller->id,
							'project_id' => $model->project_id,
						);
						Logs::model()->saveLog($attributes);

						header('Content-type: application/json');
						echo CJSON::encode(array(
							'success'=>true,
							'id'=>$model->milestone_id,
							'milestone_title'=>$model->milestone_title,
							'milestone_description'=>$model->milestone_description,
							'milestone_startdate'=>$model->milestone_startdate,
							'milestone_duedate'=>$model->milestone_duedate,
						));
						Yii::app()->end();
					}
				}

				header('Content-type: application/json');
				echo CJSON::encode(array(
					'error'=>json_decode(CActiveForm::validate($model))
				));
				Yii::app()->end();
			}

			$this->layout = false;
			$this->render('create',array(
				'model'=>$model,
			));
		}
		else
		{
			throw new CHttpException(403, Yii::t('site', '403_Error'));
		}
	}

	/**
	 * [actionView description]
	 * @return [type] [description]
	 */
	public function actionView()
	{
		// check if user has permissions to viewCases
		if (Yii::app()->user->checkAccess('viewCases'))
		{	
			$model = new Cases();

			if (($_POST) && (Yii::app()->request->isPostRequest))
			{
				// DataProvider for Normal Secuence
				$NormalSecuense = Secuences::model()->with('SecuenceTypes')->together()->findAll(array(
					'condition'=>'t.case_id = :case_id AND SecuenceTypes.secuenceTypes_id = '.SecuenceTypes::NORMAL,
					'params'=>array(
						':case_id'=>Yii::app()->request->getParam('id', 0),
					),
					'order'=>'t.secuence_id'
				));
				
				// DataProvider for Alternative Secuence
				$AlternativeSecuense = Secuences::model()->with('SecuenceTypes')->together()->findAll(array(
					'condition'=>'t.case_id = :case_id AND SecuenceTypes.secuenceTypes_id = '.SecuenceTypes::ALTERNATIVE,
					'params'=>array(
						':case_id'=>Yii::app()->request->getParam('id', 0),
					),
					'order'=>'t.secuence_id'
				));
				
				// DataProvider for Exception Secuence
				$ExceptionSecuense = Secuences::model()->with('SecuenceTypes')->together()->findAll(array(
					'condition'=>'t.case_id = :case_id AND SecuenceTypes.secuenceTypes_id = '.SecuenceTypes::EXCEPTION,
					'params'=>array(
						':case_id'=>Yii::app()->request->getParam('id', 0),
					),
					'order'=>'t.secuence_id'
				));
				
				// DataProvider for Validations
				$Validations = Validations::model()->findAll(array(
					'condition'=>'t.case_id = :case_id',
					'params'=>array(
						':case_id'=>Yii::app()->request->getParam('id', 0),
					),
					'order'=>'t.validation_id'
				));

			
				// DataProvider for Tasks relateds
				$dataProviderTasks = Tasks::model()->findAll(array(
					'condition'=>'t.case_id = :case_id',
					'params'=>array(
						':case_id'=>Yii::app()->request->getParam('id', 0)
					),
					'order'=>'t.task_id'
				));

				$tasks = array();
				foreach ($dataProviderTasks as $data)
				{
					$class = '';
					switch ($data->task_priority) {
						case Tasks::PRIORITY_LOW:
							$class = 'label-info';
							break;
						case Tasks::PRIORITY_MEDIUM:
							$class = 'label-warning';
							break;
						case Tasks::PRIORITY_HIGH:
							$class = 'label-important';
							break;
						default:
							$class = 'label-info';
							break;
					}

					$tasks[] = array(
						'status'=>$data->Status->status_name,
						'class_status'=>'label-'.strtolower(str_replace(" ", "", $data->Status->status_name)),
						'taskTypes_id'=>$data->taskTypes_id,
						'task_startDate'=>Yii::app()->dateFormatter->format('MMMM d, yyy', strtotime($data->task_startDate)),
						'task_endDate'=>$data->task_endDate,
						'task_id'=>$data->task_id,
						'task_url'=>$this->createUrl('/tasks/view', array('id'=>$data->task_id)),
						'task_name'=>$data->task_name,
						'task_priority'=>Tasks::getNameOfTaskPriority($data->task_priority),
						'task_priority_class'=>$class,
						'user'=>$data->UserReported->CompleteName
					);
				}

				$model = $this->loadModel();

				header('Content-type: application/json');
				echo CJSON::encode(array(
					'case'=>array(
						'case_id'=>$model->case_id,
						'case_actors'=>$model->case_actors,
						'case_code'=>$model->case_code,
						'case_creationDate'=>$model->case_date,
						'case_description'=>$model->case_description,
						'case_name'=>$model->case_name,
						'case_priority'=>$model->case_priority,
						'case_requirements'=>$model->case_requirements,
						'case_status'=>$model->Status->status_name,
						'secuences'=>array(
							'normal'=>$NormalSecuense,
							'alternative'=>$AlternativeSecuense,
							'exception'=>$ExceptionSecuense
						),
						'validations'=>$Validations,
						'tasks'=>$tasks
					)
				));
				Yii::app()->end();
			}

			$this->layout = false;
			$this->render('view', array(
				'model'=>$model,
				'status'=>Status::model()->findAll()
			));
		}
		else
		{
			throw new CHttpException(403, Yii::t('site', '403_Error'));
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param $id to compare with budget_id
	 * @return CActiveRecord Cases
	 */
	public function loadModel()
	{		
		if ($this->_model === null)
		{
			if (isset($_REQUEST['id']))
			{
				$this->_model = Cases::model()->findByPk((int)Yii::app()->request->getParam('id', 0));
			}

			if ($this->_model === null)
			{
				throw new CHttpException(404, Yii::t('site', '404_Error'));
			}
		}

		return $this->_model;
	}
}