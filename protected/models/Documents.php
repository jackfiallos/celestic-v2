<?php

/**
 * Documents Model
 * 
 * @author		Jackfiallos
 * @version		2.0.0
 * @link		http://qbit.com.mx/labs/celestic
 * @copyright 	Copyright (c) 2009-2013 Qbit Mexhico
 * @license		http://qbit.com.mx/labs/celestic/license/
 * @description
 * 
 * This is the model class for table "tb_documents".
 *
 * The followings are the available columns in table 'tb_documents':
 * @property integer $document_id
 * @property integer $project_id
 * @property string $document_name
 * @property string $document_description
 * @property string $document_path
 * @property integer $document_revision
 * @property string $document_uploadDate
 * @property string $document_type
 * @property string $comment_id
 * @property string $user_id
 */
class Documents extends CActiveRecord
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
		return 'tb_documents';
	}

	/**
	 * [rules description]
	 * @return [type] [description]
	 */
	public function rules()
	{
		return array(
			array('project_id, document_name, document_description, image, user_id', 'required', 'message'=>Yii::t('inputValidations','RequireValidation')),
			array('project_id, document_revision, document_baseRevision, comment_id, user_id', 'numerical', 'integerOnly'=>true),
			array('document_name, document_type', 'length', 'max'=>100, 'message'=>Yii::t('inputValidations','MaxValidation')),
			array('document_path', 'length', 'max'=>255, 'message'=>Yii::t('inputValidations','MaxValidation')),
			array('document_name', 'length', 'min'=>8, 'message'=>Yii::t('inputValidations','MinValidation')),
			array('image', 'file', 'types'=>'doc, docx, rtf, ppt, pptx, odt, ods, xls, xlsx, sql, wav, ogg, pdf, psd, ai, txt, bmp, jpg, jpeg, gif, png, svg, zip, rar, bz, bz2, z, tar, vsd', 'message'=>Yii::t('inputValidations','FileTypeValidation'))
		);
	}

	/**
	 * [relations description]
	 * @return [type] [description]
	 */
	public function relations()
	{
		return array(
			'Projects'=>array(self::BELONGS_TO, 'Projects', 'project_id'),
			'Comment'=>array(self::BELONGS_TO, 'Comments', 'comment_id'),
			'User'=>array(self::BELONGS_TO, 'Users', 'user_id')
		);
	}

	/**
	 * [attributeLabels description]
	 * @return [type] [description]
	 */
	public function attributeLabels()
	{
		return array(
			'document_id' => Yii::t('documents','document_id'),
			'project_id' => Yii::t('documents','project_id'),
			'document_name' => Yii::t('documents','document_name'),
			'document_description' => Yii::t('documents','document_description'),
			'document_path' => Yii::t('documents','document_path'),
			'document_revision' => Yii::t('documents','document_revision'),
			'document_uploadDate' => Yii::t('documents','document_uploadDate'),
			'document_type' => Yii::t('documents','document_type'),
			'document_baseRevision' => Yii::t('documents','document_baseRevision'),
			'comment_id' => Yii::t('documents','comment_id'),
			'user_id' => Yii::t('documents','user_id'),
			'image' => Yii::t('documents','image')
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
				'attributes' => array('document_name', 'document_description', 'document_path', 'document_revision', 'document_uploadDate', 'document_type')
			),
		);
	}
	
	/**
	 * [findDocuments description]
	 * @param  [type] $project_id [description]
	 * @return [type]             [description]
	 */
	public function findDocuments($project_id)
    {
		return Documents::model()->findAll(array(
			'condition'=>'t.document_id IN(
					SELECT MAX( t.document_id ) 
					FROM `tb_documents` `t` 
					WHERE t.project_id = :project_id
					GROUP BY t.document_baseRevision
				)',
			'params'=>array(
				':project_id'=>(!empty($project_id)) ? $project_id : 0,
			),
			'order'=>'t.document_id DESC',
			'limit'=>5
		));
    }
    
    /**
     * [countDocumentsByProject description]
     * @param  [type] $document_id [description]
     * @param  [type] $project_id  [description]
     * @return [type]              [description]
     */
	public function countDocumentsByProject($document_id, $project_id)
	{
		return Documents::model()->count(array(
			'condition'=>'t.project_id = :project_id AND t.document_id = :document_id',
			'params'=>array(
				':project_id' => $project_id,
				':document_id' => $document_id
			)
		));
	}
}