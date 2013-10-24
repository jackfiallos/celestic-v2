<div class="form well" ng-show="milestonesForm">

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
	
	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<?php echo $form->labelEx($model, 'milestone_title', array('class'=>'control-label', 'for'=>$id.'_'.CHtml::activeId($model, 'milestone_title'))); ?>
				<div class="controls">
					<?php echo $form->textField($model,'milestone_title',array('class'=>'betterform', 'value'=>'{{milestone.title}}', 'id'=>$id.'_'.CHtml::activeId($model, 'milestone_title'))); ?>
					<div class="help-inline">
						<?php echo CHtml::label(Yii::t('milestones','FormMilestoneTitle'), $id.'_'.CHtml::activeId($model, 'milestone_title'), array('class'=>'labelhelper')); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<?php echo $form->labelEx($model, 'user_id', array('class'=>'control-label', 'for'=>$id.'_'.CHtml::activeId($model, 'user_id'))); ?>
				<div class="controls">
					<?php echo $form->dropDownList($model, 'user_id', CHtml::listData($users, 'user_id', 'completeName'),array('class'=>'betterform','empty'=>Yii::t('milestones', 'selectOption'), 'ng-model'=>'milestone.ownerId', 'id'=>$id.'_'.CHtml::activeId($model, 'user_id'))); ?>
					<div class="help-inline">
						<?php echo CHtml::label(Yii::t('milestones','FormMilestoneUser'), $id.'_'.CHtml::activeId($model, 'user_id'), array('class'=>'labelhelper')); ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<?php echo $form->labelEx($model,'milestone_startdate', array('class'=>'control-label', 'for'=>$id.'_'.CHtml::activeId($model, 'milestone_startdate'))); ?>
				<div class="controls">
					<?php
						$this->widget('zii.widgets.jui.CJuiDatePicker', array(
							'options'=>array(
								'showAnim'=>'fold',
							),
							'name'=>$id.'_'.CHtml::activeId($model, 'milestone_startdate'),
							'model'=>$model,
							'attribute'=>'milestone_startdate',
							'htmlOptions'=>array(
								'class'=>'betterform',
								'value'=>'{{milestone.start_date}}'
							),
							'options'=>array(
								'dateFormat'=>'yy-mm-dd',
								'showButtonPanel'=>true,
								'changeMonth'=>true,
								'changeYear'=>true,
								'defaultDate'=>'+1w',
								'onSelect'=>'js:function(selectedDate){
									var option = "minDate",
									instance = $(this).data("datepicker");
									date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
									$("#'.$id.'_'.CHtml::activeId($model, 'milestone_startdate').'").datepicker("option", option, date);
								}'
							),
						));
					?>
					<div class="help-inline">
						<?php echo CHtml::label(Yii::t('milestones','FormMilestoneStartDate'), $id.'_'.CHtml::activeId($model, 'milestone_startdate'), array('class'=>'labelhelper')); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<?php echo $form->labelEx($model,'milestone_duedate', array('class'=>'control-label', 'for'=>$id.'_'.CHtml::activeId($model, 'milestone_duedate'))); ?>
				<div class="controls">
					<?php
						$this->widget('zii.widgets.jui.CJuiDatePicker', array(
							'options'=>array(
								'showAnim'=>'fold',
							),
							'name'=>$id.'_'.CHtml::activeId($model, 'milestone_duedate'),
							'model'=>$model,
							'attribute'=>'milestone_duedate',
							'htmlOptions'=>array(
								'class'=>'betterform',
								'value'=>'{{milestone.due_date}}'
							),
							'options'=>array(
								'dateFormat'=>'yy-mm-dd',
								'showButtonPanel'=>true,
								'changeMonth'=>true,
								'changeYear'=>true,
								'defaultDate'=>'+1w',
								'onSelect'=>'js:function(selectedDate){
									var option = "maxDate",
									instance = $(this).data("datepicker");
									date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
									$("#'.$id.'_'.CHtml::activeId($model, 'milestone_startdate').'").datepicker("option", option, date);
								}'
							),
						));
					?>
					<div class="help-inline">
						<?php echo CHtml::label(Yii::t('milestones','FormMilestoneDueDate'), $id.'_'.CHtml::activeId($model, 'milestone_duedate'), array('class'=>'labelhelper')); ?>
					</div>
				</div>
			</div>
		</div>		
	</div>

	<div class="row-fluid">
		<div class="control-group">
			<?php echo $form->labelEx($model,'milestone_description', array('class'=>'control-label', 'for'=>$id.'_'.CHtml::activeId($model, 'milestone_description'))); ?>
			<div class="controls">
				<?php echo $form->textArea($model,'milestone_description',array('style'=>'width:100%', 'value'=>'{{milestone.description}}', 'id'=>$id.'_'.CHtml::activeId($model, 'milestone_description'))); ?>
				<div class="help-inline">
					<?php echo CHtml::label(Yii::t('milestones','FormMilestoneDescription'), $id.'_'.CHtml::activeId($model, 'milestone_description'), array('class'=>'labelhelper')); ?>
				</div>
			</div>
		</div>

		<div class="form-actions">
			<div class="span6">
				<?php echo CHtml::htmlButton("<i class=\"icon-plus-sign\"></i> ".Yii::t('site','save'), array('type'=>'submit', 'class'=>'btn btn-primary')); ?>
				<?php echo CHtml::button(Yii::t('site','reset'), array('type'=>'reset', 'class'=>'btn')); ?>
			</div>
			<div class="span6">
				<?php echo CHtml::link(Yii::t('site','return'), '', array('class'=>'showpointer pull-right', 'ng-click'=>'milestonesForm=false')); ?>
			</div>
		</div>

	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->