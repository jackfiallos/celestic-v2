<div class="form well" ng-show="uploadform">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'documents-form',
	'action'=>$this->createUrl('create'),
	'htmlOptions'=>array(
		'name'=>'documents-form',
		'enctype'=>'multipart/form-data',
		'class'=>'vertical-horizontal',
		'ng-submit'=>'submitForm()',
		'onsubmit'=>'return false'
	),
	'enableAjaxValidation'=>false
)); ?>
	
	<div class="row-fluid">
		<div class="control-group">
			<?php echo $form->labelEx($model,'image', array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::activeFileField($model, 'image', array('class'=>'filestyle', 'data-classInput'=>'input-small', 'data-buttonText'=>'Find file', 'data-classIcon'=>'icon-plus')); ?>
				<div class="help-inline">
					<?php echo CHtml::label(Yii::t('documents','FormDocumentImage'), CHtml::activeId($model, 'image'), array('class'=>'labelhelper','style'=>'width:95%')); ?>
				</div>
			</div>
		</div>

		<div class="control-group">
			<?php echo $form->labelEx($model,'document_description', array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->textArea($model,'document_description',array('class'=>'span12')); ?>
				<div class="help-inline">
					<?php echo CHtml::label(Yii::t('documents','FormDocumentDescription'), CHtml::activeId($model, 'document_description'), array('class'=>'labelhelper')); ?>
				</div>
			</div>
		</div>

		<div class="form-actions">
			<div class="span6">
				<?php echo CHtml::htmlButton("<i class=\"icon-plus-sign\"></i> ".Yii::t('documents','upload'), array('type'=>'submit', 'class'=>'btn btn-primary')); ?>
				<?php echo CHtml::button(Yii::t('site','reset'), array('type'=>'reset', 'class'=>'btn')); ?>
			</div>
			<div class="span6">
				<?php echo CHtml::link(Yii::t('site','return'), $this->createUrl('index', array('#'=>'/home')), array('class'=>'pull-right button', 'ng-click'=>'uploadform=false', 'ng-show'=>'uploadform')); ?>
			</div>
		</div>
	</div>
<?php $this->endWidget(); ?>
</div>