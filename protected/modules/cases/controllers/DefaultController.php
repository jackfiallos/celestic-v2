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
			// create Cases form search
			$model = new CasesSearchForm;
			$model->search();
			$model->unsetAttributes();  // clear any default values
			
			// set model attributes from Cases form
			if(isset($_GET['CasesSearchForm']))
			{
				$model->attributes=$_GET['CasesSearchForm'];
			}
			
			$this->render('index',array(
				'model'=>$model,
				'status'=>Status::model()->findAllRequired(true)
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