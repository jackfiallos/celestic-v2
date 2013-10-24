<section class="form paneltab" ng-show="tasksForm">
	<div class="paneltab-body row-fluid">

		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>$id,
			'htmlOptions'=>array(
				'name'=>$id,
				'class'=>'vertical-horizontal',
				'ng-submit'=>'submitForm()',
				'onsubmit'=>'return false'
			),
			'enableAjaxValidation'=>false
		)); ?>
		
		<?php
		if (!$model->isNewRecord && !$allowEdit)
			echo CHtml::tag("div", array('class'=>'notification_warning'),Yii::t('tasks', 'NowAllowedToEdit'));
		?>
		
		<fieldset>
			<legend style="font-weight:bold;"><?php echo Yii::t('tasks','Relations'); ?></legend>
			<div class="row-fluid">
				<div class="span6">
					<div class="control-group">
						<?php echo $form->labelEx($model,'milestone_id', array('class'=>'control-label')); ?>
						<div class="controls">
							<?php echo $form->dropDownList($model,'milestone_id',CHtml::listData($milestones, 'milestone_id', 'milestone_title'), array('empty'=>Yii::t('tasks', 'selectOption'),'disabled'=>!$allowEdit)); ?>
							<div class="help-inline">
								<?php echo CHtml::label(Yii::t('tasks','FormTaskMilestone'), CHtml::activeId($model, 'milestone_id'), array('class'=>'labelhelper')); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span6">
					<div class="control-group">
						<?php echo $form->labelEx($model,'taskStage_id', array('class'=>'control-label')); ?>
						<div class="controls">
							<?php echo $form->dropDownList($model,'taskStage_id', CHtml::listData($stages, 'taskStage_id', 'taskStage_name'), array('empty'=>Yii::t('tasks', 'selectOption'), 'disabled'=>!$allowEdit)); ?>
							<div class="help-inline">
								<?php echo CHtml::label(Yii::t('tasks','FormTaskTaskStage'), CHtml::activeId($model, 'taskStage_id'), array('class'=>'labelhelper')); ?>
							</div>
						</div>
					</div>
				</div>
				<div class="span6">
					<div class="control-group">
						<?php echo $form->labelEx($model,'case_id', array('class'=>'control-label')); ?>
						<div class="controls">
							<?php echo $form->dropDownList($model,'case_id', CHtml::listData($cases, 'case_id', 'CaseTitle'), array('empty'=>Yii::t('tasks', 'selectOption'),'disabled'=>!$allowEdit)); ?>
							<div class="help-inline">
								<?php echo CHtml::label(Yii::t('tasks','FormTaskCase'), CHtml::activeId($model, 'case_id'), array('class'=>'labelhelper')); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span6">
					<div class="control-group">
						<?php echo $form->labelEx($model,'taskTypes_id', array('class'=>'control-label')); ?>
						<div class="controls">
							<?php echo $form->dropDownList($model,'taskTypes_id', CHtml::listData($types, 'taskTypes_id', 'taskTypes_name'), array('empty'=>Yii::t('tasks', 'selectOption'), 'disabled'=>!$allowEdit)); ?>
							<div class="help-inline">
								<?php echo CHtml::label(Yii::t('tasks','FormTaskTaskTypes'), CHtml::activeId($model, 'taskTypes_id'), array('class'=>'labelhelper')); ?>
							</div>
						</div>
					</div>
				</div>
				<div class="span6">
					<div class="control-group">
						<?php echo $form->labelEx($model,'task_buildNumber', array('class'=>'control-label')); ?>
						<div class="controls">
							<?php echo $form->textField($model,'task_buildNumber',array('disabled'=>!$allowEdit)); ?>
							<div class="help-inline">
								<?php echo CHtml::label(Yii::t('tasks','FormTaskBuildNumber'), CHtml::activeId($model, 'task_buildNumber'), array('class'=>'labelhelper')); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</fieldset>

		<fieldset>
			<legend style="font-weight:bold;"><?php echo Yii::t('tasks','Summary'); ?></legend>
			<div class="row-fluid">
				<div class="span6">
					<div class="control-group">
						<?php echo $form->labelEx($model,'task_name', array('class'=>'control-label')); ?>
						<div class="controls">
							<?php echo $form->textField($model,'task_name', array('disabled'=>!$allowEdit)); ?>
							<div class="help-inline">
								<?php echo CHtml::label(Yii::t('tasks','FormTaskName'), CHtml::activeId($model, 'task_name'), array('class'=>'labelhelper')); ?>
							</div>
						</div>
					</div>
				</div>
				<div class="span6">
					<div class="control-group">
						<?php echo $form->labelEx($model,'task_priority', array('class'=>'control-label')); ?>
						<div class="controls">
							<div class="btn-group" data-toggle="buttons-radio">
								<button type="button" value="1" class="btn btn-primary active"><?php echo Yii::t('site','lowPriority'); ?></button>
								<button type="button" value="2" class="btn btn-primary"><?php echo Yii::t('site','mediumPriority'); ?></button>
								<button type="button" value="3" class="btn btn-primary"><?php echo Yii::t('site','highPriority'); ?></button>
							</div>
							<?php echo $form->hiddenField($model,'task_priority'); ?>
							<div class="help-inline">
								<?php echo CHtml::label(Yii::t('tasks','FormTaskPiority'), CHtml::activeId($model, 'task_priority'), array('class'=>'labelhelper')); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row-fluid">
				<div class="control-group">
					<?php echo $form->labelEx($model,'task_description', array('class'=>'control-label')); ?>
					<div class="controls">
						<?php echo $form->textArea($model,'task_description',array('class'=>'betterform','style'=>'width:95%','rows'=>10,'cols'=>50,'disabled'=>!$allowEdit)); ?>
						<div class="help-inline">
							<?php echo CHtml::label(Yii::t('tasks','FormTaskDescription'), CHtml::activeId($model, 'task_description'), array('class'=>'labelhelper')); ?>
						</div>
					</div>
				</div>
				<div class="form-actions">
					<div class="span6">
						<?php echo CHtml::htmlButton("<i class=\"icon-plus-sign\"></i> ".Yii::t('site','save'), array('type'=>'submit', 'class'=>'btn btn-primary')); ?>
						<?php echo CHtml::button(Yii::t('site','reset'), array('type'=>'reset', 'class'=>'btn')); ?>
					</div>
					<div class="span6">
						<?php echo CHtml::link(Yii::t('site','return'), '', array('class'=>'showpointer pull-right', 'ng-click'=>'tasksForm=false')); ?>
					</div>
				</div>
			</div>
		</fieldset>
		<?php $this->endWidget(); ?>
	</div>
</section>
