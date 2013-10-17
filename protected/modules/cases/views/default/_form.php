<div class="form well" ng-show="casesForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>$id,
	'action'=>$action,
	'htmlOptions'=>array(
		'name'=>$id,
		'class'=>'vertical-horizontal',
		'ng-submit'=>'submitForm()',
		'onsubmit'=>'return false'
	),
	'enableAjaxValidation'=>false
)); ?>

	<?php echo $form->errorSummary($model,null,null,array('class'=>'errorSummary stick'))."<br />"; ?>

	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<?php echo $form->labelEx($model,'case_name', array('class'=>'control-label', 'for'=>$id.'_'.CHtml::activeId($model, 'case_name'))); ?>
				<div class="controls">
					<?php echo $form->textField($model,'case_name', array('class'=>'betterform', 'id'=>$id.'_'.CHtml::activeId($model, 'case_name'))); ?>
					<div class="help-inline">
						<?php echo CHtml::label(Yii::t('cases','FormCaseName'), $id.'_'.CHtml::activeId($model, 'case_name'), array('class'=>'labelhelper')); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<?php echo $form->labelEx($model,'case_actors', array('class'=>'control-label', 'for'=>$id.'_'.CHtml::activeId($model, 'case_actors'))); ?>
				<div class="controls">
					<?php echo $form->textField($model,'case_actors',array('class'=>'betterform', 'id'=>$id.'_'.CHtml::activeId($model, 'case_actors'))); ?>
					<div class="help-inline">
						<?php echo CHtml::label(Yii::t('cases','FormCaseActors'), $id.'_'.CHtml::activeId($model, 'case_actors'), array('class'=>'labelhelper')); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<?php echo $form->labelEx($model,'case_code', array('class'=>'control-label', 'for'=>$id.'_'.CHtml::activeId($model, 'case_code'))); ?>
				<div class="controls">
					<?php echo $form->textField($model,'case_code',array('class'=>'betterform', 'id'=>$id.'_'.CHtml::activeId($model, 'case_code'))); ?>
					<div class="help-inline">
						<?php echo CHtml::label(Yii::t('cases','FormCaseCode'), $id.'_'.CHtml::activeId($model, 'case_code'), array('class'=>'labelhelper')); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<?php echo $form->labelEx($model,'case_priority', array('class'=>'control-label', 'for'=>$id.'_'.CHtml::activeId($model, 'case_priority'))); ?>
				<div class="controls">
					<?php echo $form->dropDownList($model,'case_priority',array(Cases::PRIORITY_LOW=>Yii::t('site','lowPriority'), Cases::PRIORITY_MEDIUM=>Yii::t('site','mediumPriority'), Cases::PRIORITY_HIGH=>Yii::t('site','highPriority')),array('class'=>'betterform', 'empty'=>Yii::t('tasks', 'selectOption'), 'id'=>$id.'_'.CHtml::activeId($model, 'case_priority'))); ?>
					<div class="help-inline">
						<?php echo CHtml::label(Yii::t('cases','FormCasePiority'), $id.'_'.CHtml::activeId($model, 'case_priority'), array('class'=>'labelhelper')); ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<hr />

	<fieldset>
		<legend style="font-weight:bold"><?php echo Yii::t('cases','CaseFunctionality'); ?></legend>
		<div class="row-fluid">
			<div class="control-group">
				<?php echo $form->labelEx($model,'case_description', array('class'=>'control-label', 'for'=>$id.'_'.CHtml::activeId($model, 'case_description'))); ?>
				<div class="controls">
					<?php echo $form->textArea($model,'case_description', array('class'=>'betterform span12', 'id'=>$id.'_'.CHtml::activeId($model, 'case_description'))); ?>
					<div class="help-inline">
						<?php echo CHtml::label(Yii::t('cases','FormCaseDescription'), $id.'_'.CHtml::activeId($model, 'case_description'), array('class'=>'labelhelper')); ?>
					</div>
				</div>
			</div>
			<div class="control-group">
				<?php echo $form->labelEx($model,'case_requirements', array('class'=>'control-label', 'for'=>$id.'_'.CHtml::activeId($model, 'case_requirements'))); ?>
				<div class="controls">
					<?php echo $form->textArea($model,'case_requirements',array('class'=>'betterform span12', 'id'=>$id.'_'.CHtml::activeId($model, 'case_requirements'))); ?>
					<div class="help-inline">
						<?php echo CHtml::label(Yii::t('cases','FormCaseRequirements'), $id.'_'.CHtml::activeId($model, 'case_requirements'), array('class'=>'labelhelper')); ?>
					</div>
				</div>
			</div>
			<div class="form-actions row">
				<div class="span6">
					<?php echo CHtml::htmlButton("<i class=\"icon-plus-sign\"></i> ".Yii::t('site','save'), array('type'=>'submit', 'class'=>'btn btn-primary')); ?>
					<?php echo CHtml::button(Yii::t('site','reset'), array('type'=>'reset', 'class'=>'btn')); ?>
				</div>
				<div class="span6">
					<?php echo CHtml::link(Yii::t('site','return'), '', array('class'=>'showpointer pull-right', 'ng-click'=>'casesForm=false')); ?>
				</div>
			</div>
		</div>
	</fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->