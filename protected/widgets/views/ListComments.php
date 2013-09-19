<div class="form">
	<?php
	$model=new Comments;
	$form=$this->beginWidget('CActiveForm', array(
		'id'=>'comment-form',
		'enableAjaxValidation'=>false,
		//'action'=>'?r=comments/create&module='.$this->moduleid.'&action='.Yii::app()->controller->getAction()->getId().'&id='.$this->resourceid,
		'action'=>Yii::app()->createUrl('comments/create',array('module'=>$this->moduleid,'action'=>Yii::app()->controller->getAction()->getId(),'id'=>$this->resourceid)),
		'method'=>'post',
		'htmlOptions'=>array(
			'enctype'=>'multipart/form-data',
		),
	));
	?>

	<?php echo $form->hiddenField($model,'comment_date',array('value'=>date("Y-m-d G:i:s"))); ?>
	<?php echo $form->hiddenField($model,'comment_resourceid',array('value'=>$this->resourceid)); ?>
	<?php echo $form->hiddenField($model,'module_id',array('value'=>$this->moduleid)); ?>
	<?php echo $form->hiddenField($model,'user_id',array('value'=>Yii::app()->user->id)); ?>

	<div class="row-fluid">
		<div class="control-group">
			<?php echo $form->labelEx($model,'comment_text'); ?>
			<div class="controls">
				<?php echo $form->textArea($model,'comment_text',array('class'=>'betterform','rows'=>5,'style'=>'width:98%','tabindex'=>99)); ?>
				<div class="help-inline">
					<?php echo CHtml::label(Yii::t('documents','FormDocumentImage'), CHtml::activeId($model, 'image'), array('class'=>'labelhelper','style'=>'width:95%')); ?>
				</div>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::image(Yii::app()->theme->baseUrl."/images/attach.png");?> <?php echo Yii::t('comments','AttachFiles'); ?>
			<?php
				$this->widget('CMultiFileUpload',array(
					//'name'=>'files',
					'duplicate'=>Yii::t('comments','FileAlready'),
					'remove'=>CHtml::image(Yii::app()->request->baseUrl."/images/icons/cross-12.png"),
					'model'=>$model,
					'attribute'=>'image',
				));
			?>
		</div>
		<div class="form-actions row">
			<?php
				echo CHtml::submitButton(Yii::t('site','comment'),array(
					'class'=>'btn btn-primary'
				));
			?>
		</div>
	</div>
	<?php $this->endWidget(); ?>
</div>
<ol class="comments" id="comments">
<?php
	$lastItemComment;
	$i = 1;
?>
<?php foreach($this->getComments($this->moduleid) as $comment): ?>
	<?php $i++; ?>
	<li id="comment-<?php echo CHtml::encode($comment->comment_id); ?>" class="corners <?php echo ($i%2 == 0) ? "odd" : "even"; ?>">
		<ul class="meta">
			<li class="image">
				<?php 
					$this->widget('application.extensions.VGGravatarWidget.VGGravatarWidget', 
						array(
							'email' => CHtml::encode($comment->User->user_email),
							'hashed' => false,
							'default' => 'http://'.$_SERVER['SERVER_NAME'].Yii::app()->request->baseUrl.'/images/bg-avatar.png',
							'size' => 62,
							'rating' => 'PG',
							'htmlOptions' => array('class'=>'borderCaption','alt'=>CHtml::encode($comment->User->CompleteName),'width'=>'62', 'height'=>'62'),
						)
					);
				?>
			</li>
			<li class="author">
				<?php echo CHtml::link("#".$comment->comment_id, Yii::app()->createUrl("tasks/view", array("id"=>$this->resourceid,"#"=>"comment-".$comment->comment_id))); ?>
				<?php echo CHtml::link(CHtml::encode($comment->User->CompleteName), Yii::app()->createUrl('users/view',array('id'=>$comment->User->user_id))); ?>
			</li>
			<li class="date">
				<abbr class="timeago" title="<?php echo $comment->comment_date; ?>"><?php echo CHtml::link(CHtml::encode(Yii::app()->dateFormatter->format('dd.MM.yyyy', $comment->comment_date)), '#comment-'.CHtml::encode($comment->comment_id)); ?></abbr>
			</li>
		</ul>
		<div class="body">
			<?php
				$mystring = $comment->comment_text;
				$findme   = Status::STATUS_COMMENT;
				$pos = strpos($mystring, $findme);
				// Es un comentario escrito por el usuario
				if ($pos === false)
				{
					echo Yii::app()->format->html(nl2br(ECHtml::createLinkFromString(CHtml::encode($comment->comment_text))));
				}
				// Es un comentario generado por el sistema
				else
				{
					$patterns = array();
					$patterns[0] = '/'.Status::STATUS_COMMENT.'/';
					$replacements = array();
					$replacements[0] = Yii::t('tasks','StatusChanged');
					$newStringComment = preg_replace($patterns, $replacements, $mystring);
					echo substr($newStringComment,0,-1);
					
					$statusString = strstr($newStringComment, ': ');
					$status = substr($statusString, 2, strlen($statusString));
					echo "<span class=\"status st".$status."\">".Status::model()->findByPk($status)->status_name."</span>";
				}
			?>
		</div>
		<?php
			$documents = $this->getAttachments($comment->comment_id);
			if (count($documents)>0){
				echo "<span><p class=\"attachs corners\"><b>".Yii::t('comments','Attachments')."</b><br />";
				foreach($this->getAttachments($comment->comment_id) as $attach) {
					echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl."/images/icons/download.png", Yii::t('comments','DownloadFile'))." ".$attach->document_name, Yii::app()->createUrl('documents/download', array('id'=>$attach->document_id)), array('target'=>'_blank',"class"=>(in_array($attach->document_type,array("image/png","image/jpeg","image/gif","image/bmp")))?"lnkdownloadimage":"lnkdownloadfile"))."<br />";
				}
				echo "</p></span>";
			}
		?>
	</li>
	<?php $lastItemComment=$comment->comment_id;?>
<?php endforeach; ?>
</ol>

<?php
$mystring = isset($mystring) ? $mystring : null;
$lastItemComment = !empty($lastItemComment) ? $lastItemComment : 0;
$tofind   = "StatusChanged";
$finded = strpos($mystring, $tofind);
Yii::app()->clientScript->registerScript(
	'CommentMessage',
	'$(".info").animate({opacity: 1.0}, 3000);',
   CClientScript::POS_READY
);
?>