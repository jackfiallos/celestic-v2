<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cases-form',
	'action'=>$this->createUrl('create'),
	'htmlOptions'=>array(
		'name'=>'milestones-form',
		'class'=>'vertical-horizontal',
		'ng-submit'=>'submitForm()',
		'onsubmit'=>'return false'
	),
	'enableAjaxValidation'=>false
)); ?>

	<div class="alert alert-info">
		<h4>Atenci&oacute;n!</h4>
		<?php echo Yii::t('cases','FieldsRequired'); ?>
	</div>

	<?php echo $form->errorSummary($model,null,null,array('class'=>'errorSummary stick'))."<br />"; ?>

	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<?php echo $form->labelEx($model,'case_name'); ?>
				<div class="controls">
					<?php echo $form->textField($model,'case_name', array('class'=>'betterform')); ?>
					<div class="help-inline">
						<?php echo CHtml::label(Yii::t('cases','FormCaseName'), CHtml::activeId($model, 'case_name'), array('class'=>'labelhelper')); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<?php echo $form->labelEx($model,'case_actors'); ?>
				<div class="controls">
					<?php echo $form->textField($model,'case_actors',array('class'=>'betterform')); ?>
					<div class="help-inline">
						<?php echo CHtml::label(Yii::t('cases','FormCaseActors'), CHtml::activeId($model, 'case_actors'), array('class'=>'labelhelper')); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<?php echo $form->labelEx($model,'case_code'); ?>
				<div class="controls">
					<?php echo $form->textField($model,'case_code',array('class'=>'betterform')); ?>
					<div class="help-inline">
						<?php echo CHtml::label(Yii::t('cases','FormCaseCode'), CHtml::activeId($model, 'case_code'), array('class'=>'labelhelper')); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<?php echo $form->labelEx($model,'case_priority'); ?>
				<div class="controls">
					<?php echo $form->dropDownList($model,'case_priority',array(Cases::PRIORITY_LOW=>Yii::t('site','lowPriority'), Cases::PRIORITY_MEDIUM=>Yii::t('site','mediumPriority'), Cases::PRIORITY_HIGH=>Yii::t('site','highPriority')),array('class'=>'betterform', 'empty'=>Yii::t('tasks', 'selectOption'))); ?>
					<div class="help-inline">
						<?php echo CHtml::label(Yii::t('cases','FormCasePiority'), CHtml::activeId($model, 'case_priority'), array('class'=>'labelhelper')); ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<fieldset>
		<legend style="font-weight:bold"><?php echo Yii::t('cases','CaseFunctionality'); ?></legend>
		<div class="row-fluid">
			<div class="control-group">
				<?php echo $form->labelEx($model,'case_description'); ?>
				<div class="controls">
					<?php echo $form->textArea($model,'case_description',array('class'=>'betterform span12')); ?>
					<div class="help-inline">
						<?php echo CHtml::label(Yii::t('cases','FormCaseDescription'), CHtml::activeId($model, 'case_description'), array('class'=>'labelhelper')); ?>
					</div>
				</div>
			</div>
			<div class="control-group">
				<?php echo $form->labelEx($model,'case_requirements'); ?>
				<div class="controls">
					<?php echo $form->textArea($model,'case_requirements',array('class'=>'betterform span12')); ?>
					<div class="help-inline">
						<?php echo CHtml::label(Yii::t('cases','FormCaseRequirements'), CHtml::activeId($model, 'case_requirements'), array('class'=>'labelhelper')); ?>
					</div>
				</div>
			</div>
			<div class="form-actions row">
				<div class="span6">
					<?php echo CHtml::button($model->isNewRecord ? Yii::t('site','create') : Yii::t('site','save'), array('type'=>'submit', 'class'=>'btn btn-primary')); ?>
					<?php echo CHtml::button(Yii::t('site','reset'), array('type'=>'reset', 'class'=>'btn')); ?>
				</div>
				<div class="span6">
					<?php echo CHtml::link(Yii::t('site','return'), $this->createUrl('index', array('#'=>'/home')), array('class'=>'pull-right button', 'ng-click'=>'showHome()')); ?>
				</div>
			</div>
		</div>
	</div>
<?php $this->endWidget(); ?>

</div><!-- form -->