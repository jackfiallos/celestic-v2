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
		// check if user has permission to indexMilestones
		if(Yii::app()->user->checkAccess('indexMilestones'))
		{
			// create Milestones form search
			$model = new MilestonesSearchForm;
			$milestones = $model->search();
			
			// set model attributes from milestones form
			if(Yii::app()->request->isPostRequest)
			{
				$milestone = array();
				foreach($milestones as $item)
				{
					array_push($milestone, array(
						'id'=>$item->milestone_id,
						'title'=>CHtml::encode($item->milestone_title),
						'description'=>CHtml::encode($item->milestone_description),
						'url'=>$this->createUrl('index', array('#'=>'/view/'.$item->milestone_id)),
						'countComments'=>Logs::getCountComments($this->module->id, $item->milestone_id),
						'userOwner'=>ucfirst(CHtml::encode($item->Users->user_name)),
						'userOwnerUrl'=>$this->createUrl('users/view', array('id'=>$item->Users->user_id)),
						'due_date'=>CHtml::encode($item->milestone_duedate),
						'due_dateFormatted'=>CHtml::encode(Yii::app()->dateFormatter->format('dd.MM.yyyy', $item->milestone_duedate)),
						'completed'=>round($item->percent, 2)
					));
				}

				header('Content-type: application/json');
				echo CJSON::encode(array(
					'milestones'=>$milestone
				));
				Yii::app()->end();
			}
				
			$this->render('index');
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
		// check if user has permissions to createMilestones
		if(Yii::app()->user->checkAccess('createMilestones'))
		{
			// create Milestones object model
			$model = new Milestones;
			
			// find all project managers
			$Users = Projects::model()->findManagersByProject(Yii::app()->user->getState('project_selected'));

			// if Milestones form exist
			if(isset($_POST['Milestones']))
			{
				// set form elements to Milestones model attributes
				$model->attributes = $_POST['Milestones'];
				$model->project_id = Yii::app()->user->getState('project_selected');
				
				// validate milestone model
				if ($model->validate())
				{
					// find milestones dates
					$milestone_startdate = date("Ymd", strtotime($model->milestone_startdate));
					$milestone_duedate = date("Ymd", strtotime($model->milestone_duedate));
					
					// get project data
					$project = Projects::model()->findByPk($model->project_id);
					
					// find project dates
					$project_startDate = date("Ymd", strtotime($project->project_startDate));
					$project_endDate = date("Ymd", strtotime($project->project_endDate));
					
					// If milestone dates are not within project dates ERROR!!
					if (($milestone_startdate >= $project_startDate) && ($milestone_startdate <= $project_endDate))
					{
						if (($milestone_duedate <= $project_endDate) && ($milestone_duedate >= $project_startDate))
						{
							// validate and save
							if($model->save())
							{
								// save log
								$attributes = array(
									'log_date' => date("Y-m-d G:i:s"),
									'log_activity' => 'MilestoneCreated',
									'log_resourceid' => $model->primaryKey,
									'log_type' => Logs::LOG_CREATED,
									'user_id' => Yii::app()->user->id,
									'module_id' => $this->module->getName(),
									'project_id' => $model->project_id,
								);
								Logs::model()->saveLog($attributes);
								
								// notify to user that has a milestone to attend
								Yii::import('application.extensions.phpMailer.yiiPhpMailer');
								$mailer = new yiiPhpMailer;
								$subject = Yii::t('email','MilestoneAssigned')." :: ".$model->milestone_title;
								
								// user you will be notified
								$User = Users::model()->findByPk($model->user_id);
								$recipientsList = array(
									'name'=>$User->CompleteName,
									'email'=>$User->user_email,
								);
								
								// render template
								$str = $this->renderPartial('//templates/milestones/assigned',array(
									'milestone' => $model,
									'urlToMilestone' => Yii::app()->createAbsoluteUrl('milestones/view',array('id'=>$model->milestone_id)),
									'applicationName' => Yii::app()->name,
									'applicationUrl' => "http://".$_SERVER['SERVER_NAME'].Yii::app()->request->baseUrl,
								),true);
								$mailer->pushMail($subject, $str, $recipientsList, Emails::PRIORITY_NORMAL);
								
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
						// error on milestone_duedate
						else
						{
							$model->addError('milestone_duedate', Yii::t('milestones','DueDateError'));
						}
					}
					// error on milestone_startdate
					else
					{
						$model->addError('milestone_startdate', Yii::t('milestones','StartDateError'));
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
				'users'=>$Users,
			));
		}
		else
		{
			throw new CHttpException(403, Yii::t('site', '403_Error'));
		}
	}
}