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
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;
	
	/**
	 * @var resourceFolder saved inside all uploaded images
	 */
	const FOLDERIMAGES = 'resources/';
	
	/**
	 * @var string temporal filename
	 */
	private $tmpFileName = '';

	public function actionIndex()
	{
		// verify if user has permissions to indexDownloads
		if(Yii::app()->user->checkAccess('indexDownloads'))
		{
		
			$view = (Yii::app()->user->getState('view') != null) ? Yii::app()->user->getState('view') : 'list'; 
			if((isset($_GET['view'])) && (!empty($_GET['view'])))
			{
				if ($_GET['view'] == 'grid')
					$view = 'grid';
				else
					$view = 'list';
			}
			Yii::app()->user->setState('view',$view);
		
			// create object Documents search form
			$model=new DocumentsSearchForm;
			$model->search();
			$model->unsetAttributes();  // clear any default values
			
			// if form DocumentsSearchForm was used
			if(isset($_GET['DocumentsSearchForm']))
				$model->attributes=$_GET['DocumentsSearchForm'];
			
			$this->render('index',array(
				'model'=>$model,
			));
		}
		else
		{
			throw new CHttpException(403, Yii::t('site', '403_Error'));
		}
	}

	/**
	 * [actionCreate description]
	 * @return [type] [description]
	 */
	public function actionCreate()
	{
		// verify if user has permissions to createDownloads
		if(Yii::app()->user->checkAccess('createDownloads'))
		{
			// create object model Documents
			$model=new Documents;
			
			// verify _POST['Documents'] exist
			if (isset($_POST['Documents']))
			{
				// set form elements to Documents model attributes
				$model->attributes=$_POST['Documents'];
				$model->project_id = Yii::app()->user->getState('project_selected');
				$model->user_id = Yii::app()->user->id;
				
				// verify file upload exist
				if ((isset($_FILES['Documents']['name']['image'])) && (!empty($_FILES['Documents']['name']['image'])))
				{
					// create an instance of uploaded file
					$model->image = CUploadedFile::getInstance($model,'image');
					if (!$model->image->getError())
					{
						// name is formed by date(day+month+year+hour+minutes+seconds+dayofyear+microtime())
						$this->tmpFileName = str_replace(" ","",date('dmYHis-z-').microtime());
						// get the file extension
						$extension=$model->image->getExtensionName();
						if($model->image->saveAs(DocumentsController::FOLDERIMAGES.$this->tmpFileName.'.'.$extension))
						{
							// set other attributes
							$model->document_path = DocumentsController::FOLDERIMAGES.$this->tmpFileName.'.'.$extension;
							$model->document_revision = '1';
							$model->document_uploadDate = date("Y-m-d");
							$model->document_type = $model->image->getType();
							$model->document_baseRevision = date('dmYHis');
							$model->user_id = Yii::app()->user->id;
						}
					}
					else
						$model->addError('image',$model->image->getError());
				}
				
				// validate and save
				if($model->save())
				{
					// save log
					$attributes = array(
						'log_date' => date("Y-m-d G:i:s"),
						'log_activity' => 'DocumentCreated',
						'log_resourceid' => $model->primaryKey,
						'log_type' => 'created',
						'user_id' => Yii::app()->user->id,
						'module_id' => Yii::app()->controller->id,
						'project_id' => $model->project_id,
					);
					Logs::model()->saveLog($attributes);
					
					// create email object
					Yii::import('application.extensions.phpMailer.yiiPhpMailer');
					$mailer = new yiiPhpMailer;
					$subject = Yii::t('email','newDocumentUpload')." - ".$model->document_name;

					// find users managers to send email
					$Users = Projects::model()->findManagersByProject($model->project_id);
					
					// create array of users destinations
					$recipientsList = array();
					foreach($Users as $client)
					{			
						$recipientsList[] = array(
							'name'=>$client->CompleteName,
							'email'=>$client->user_email,
						);				
					}
					
					// set layout then send
					$str = $this->renderPartial('//templates/documents/newUpload',array(
						'document' => $model,
						'urlToDocument' => "http://".$_SERVER['SERVER_NAME'].Yii::app()->createUrl('documents/view',array('id'=>$model->document_id)),
						'applicationName' => Yii::app()->name,
						'applicationUrl' => "http://".$_SERVER['SERVER_NAME'].Yii::app()->request->baseUrl,
					),true);
					
					$mailer->pushMail($subject, $str, $recipientsList, Emails::PRIORITY_NORMAL);
					
					$this->redirect(array('view','id'=>$model->document_id));
				}					
			}
			$this->layout = false;

			// response with render view
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