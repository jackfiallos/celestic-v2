<?php
/**
 * SiteController class file
 * 
 * @author		Jackfiallos
 * @link		http://qbit.com.mx/labs/celestic
 * @copyright 	Copyright (c) 2009-2013 Qbit Mexhico
 * @license		http://qbit.com.mx/labs/celestic/license/
 * @description
 *
 **/
class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// redirec to login page is user is guest
		if (Yii::app()->user->isGuest)
		{
			$this->redirect(Yii::app()->createUrl('site/login'));
		}
		else
		{
			// verify infoproject exist
			if ((isset($_GET['infoproject'])) && (is_numeric($_GET['infoproject'])))
			{ 
				// verify is user has project send via GET params
				$Project = Projects::model()->hasProject(Yii::app()->user->id, Yii::app()->request->getParam('infoproject', 0));
				// project_id has relation with user_id then, save project information inside session
				if (isset($Project->project_id))
				{
					Yii::app()->user->setState('project_selected', $Project->project_id);
					Yii::app()->user->setState('project_selectedName', $Project->project_name);
				}
			}
			$this->render('index');
		}
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		// redirec to dashboard page is user is registered
		if (!Yii::app()->user->isGuest)
		{
			$this->render('dashboard');
		}
		else
		{
			// create LoginForm object
			$model = new LoginForm;
			
			// if it is ajax validation request
			if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
			{

				header('Content-type: application/json');
				echo CActiveForm::validate($model);
				Yii::app()->end();
			}

			// collect user input data
			if(isset($_POST['LoginForm']))
			{
				$model->attributes=$_POST['LoginForm'];
				// validate user input and redirect to the previous page if valid
				if($model->validate() && $model->login())
				{
					$this->redirect((Yii::app()->user->getState('refer')==null) ? Yii::app()->controller->createUrl('site/index') : Yii::app()->user->getState('refer'));
				}
			}
			$this->layout = "login";
			// display the login form
			$this->render('login',array('model'=>$model));
		}
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	/**
	 * [actionError description]
	 * @return [type] [description]
	 */
	public function actionError()
	{
		$this->layout = 'error';
		if ($error = Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
			{
				echo $error['message'];
			}
			else
			{
				$this->render('error', $error);
			}
		}
	}
}