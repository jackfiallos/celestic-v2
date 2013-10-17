<?php
/**
 * DefaultController class file
 * 
 * @author		Jackfiallos
 * @link		http://qbit.com.mx/labs/celestic
 * @copyright 	Copyright (c) 2009-2013 Qbit Mexhico
 * @license 	http://qbit.com.mx/labs/celestic/license/
 * @description
 *
 **/
class DefaultController extends Controller
{
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
		if(Yii::app()->user->checkAccess('createCases'))
		{
			// create Cases object model
			$model = new Cases;

			// if Cases form exist and was sent
			if(isset($_POST['Cases']))
			{
				// set form elements to Budgets model attributes
				$model->attributes=$_POST['Cases'];
				$model->case_date = date("Y-m-d");
				$model->project_id = Yii::app()->user->getState('project_selected');
				
				// validate milestone model
				if ($model->validate())
				{
					// validate and save
					if($model->save())
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
}