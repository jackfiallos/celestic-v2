<?php

/**
 * Comments Model
 * 
 * @author		Jackfiallos
 * @version		2.0.0
 * @link		http://qbit.com.mx/labs/celestic
 * @copyright 	Copyright (c) 2009-2013 Qbit Mexhico
 * @license		http://qbit.com.mx/labs/celestic/license/
 * @description
 * 
 * This is the model class for table "tb_comments".
 *
 * The followings are the available columns in table 'tb_comments':
 * @property integer $comment_id
 * @property string $comment_date
 * @property string $comment_text
 * @property string $comment_resourceid 
 * @property integer $module_id
 * @property integer $project_id
 * @property integer $user_id
 *
 * The followings are the available model relations:
 */
class Comments extends CActiveRecord
{
	public $image;

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
		return 'tb_comments';
	}

	/**
	 * [rules description]
	 * @return [type] [description]
	 */
	public function rules()
	{
		return array(
			array('comment_date, comment_text, user_id, module_id, comment_resourceid', 'required', 'message'=>Yii::t('inputValidations','RequireValidation')),
			array('user_id, module_id, comment_resourceid, project_id', 'numerical', 'integerOnly'=>true)
		);
	}

	/**
	 * [relations description]
	 * @return [type] [description]
	 */
	public function relations()
	{
		return array(
			'User'=>array(self::BELONGS_TO, 'Users', 'user_id'),
			'Module'=>array(self::BELONGS_TO, 'Modules', 'module_id'),
			'Project'=>array(self::BELONGS_TO, 'Projects', 'project_id'),
			'Documents'=>array(self::HAS_MANY, 'Documents', 'comment_id', 'joinType'=>'INNER JOIN')
		);
	}

	/**
	 * [attributeLabels description]
	 * @return [type] [description]
	 */
	public function attributeLabels()
	{
		return array(
			'comment_id' => Yii::t('comments','Comment'),
			'comment_date' => Yii::t('comments','Date'),
			'comment_text' => Yii::t('comments','Text'),
			'comment_resourceid' => Yii::t('comments','Resource'),
			'project_id' => Yii::t('comments','Project'),
			'user_id' => Yii::t('comments','User'),
			'module_id' => Yii::t('comments','Module')
		);
	}
	
	/**
	 * [findComments description]
	 * @param  [type] $module   [description]
	 * @param  [type] $resource [description]
	 * @return [type]           [description]
	 */
	public function findComments($module, $resource)
    {
        return Comments::model()->with('Module')->together()->findAll(array(
            'condition'=>'Module.module_name = :module AND t.comment_resourceid = :resource',
			'params'=>array(
				':module'=>$module,
				':resource'=>$resource
			),
            'order'=>'t.comment_id ASC'
        ));
    }
	
	/**
	 * [findAttachments description]
	 * @param  [type] $comment_id [description]
	 * @return [type]             [description]
	 */
	public function findAttachments($comment_id)
	{
		return Documents::model()->findAll(array(
			'condition'=>'t.comment_id = :comment_id',
			'params'=>array(
				'comment_id'=>$comment_id
			),
            'order'=>'t.document_id'
        ));
	}
	
	/**
	 * [CommentPropietary description]
	 * @param [type] $user_id    [description]
	 * @param [type] $comment_id [description]
	 */
	public function CommentPropietary($user_id, $comment_id)
	{
		$isPropietary = self::model()->count(array(
			'condition'=>'user_id = :user_id AND comment_id = :comment_id',
			'params'=>array(
				':user_id'=>$user_id,
				':comment_id'=>$comment_id,
			),
			'limit'=>1
		));
		return (bool)$isPropietary;
	}
	
	/**
	 * [findActivity description]
	 * @param  [type]  $project_id [description]
	 * @param  integer $limit      [description]
	 * @return [type]              [description]
	 */
	public function findActivity($project_id, $limit = 10)
	{
		if (isset($project_id) || !empty($project_id))
		{
			$comments = Comments::model()->findAll(array(
	            'condition'=>'t.project_id = :project_id AND t.comment_text NOT LIKE "%Status%"',
				'limit'=>$limit,
				'order'=>'t.comment_date DESC',
				'together'=>true,
				'params'=>array(
					':project_id'=>$project_id,
				)
	        ));
		}
		else
		{
			$projects = Yii::app()->user->getProjects();
			$InProjects = array(0);

			foreach ($projects as $project)
			{
				array_push($InProjects, $project->project_id);
			}
			
			$comments = Comments::model()->with('Module')->findAll(array(
	            'condition'=>'t.project_id IN ('.implode(",", $InProjects).') AND t.comment_text NOT LIKE "%Status%"',
				'limit'=>$limit,
				'order'=>'t.comment_date DESC',
				'together'=>true
	        ));
		}
			
		return $comments;
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
				'attributes' => array('comment_date', 'comment_text', 'comment_resourceid', 'user_id', 'module_id')
			),
		);
	}
}