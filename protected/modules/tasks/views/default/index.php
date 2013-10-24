<?php
$this->pageTitle = Yii::app()->name." - ".Yii::t('tasks', 'TitleTasks');

$createIdForm = 'tasks-form-create';
$updateIdForm = 'tasks-form-update';
$formFields = array(
	'task_priority'=>CHtml::activeId($model, 'task_priority'),
	'milestone_id'=>CHtml::activeId($model, 'milestone_id'),
	'taskStage_id'=>CHtml::activeId($model, 'taskStage_id'),
	'case_id'=>CHtml::activeId($model, 'case_id'),
	'taskTypes_id'=>CHtml::activeId($model, 'taskTypes_id'),
	'task_name'=>CHtml::activeId($model, 'task_name')
);
?>

<div ng-controller="celestic.tasks.home.controller">
	<article class="widget widget-4 data-block tasks" ng-show="ishome">
		<header class="widget-head">
			<h3 class="module-title"><i class="icon-tasks icon-2"></i><?php echo Yii::t('tasks', 'TitleTasks'); ?></h3>
			<div class="data-header-actions">
				<?php echo CHtml::link("<i class=\"icon-plus-sign\"></i>", $this->createUrl('index', array('#'=>'/create')), array('class'=>'btn btn-primary', 'ng-click'=>'tasksForm=true', 'ng-hide'=>'tasksForm', 'title'=>Yii::t('tasks', 'CreateTasks'))); ?>
			</div>
		</header>
		<section class="widget-body">
			<?php
				echo $this->renderPartial('_form', array(
					'model'=>$model,
					'status'=>$status,
					'types'=>$types,
					'stages'=>$stages,
					'milestones'=>$milestones,
					'cases'=>$cases,
					'allowEdit'=>$allowEdit,
					'id'=>$createIdForm
				));
			?>
			<div class="aboutModule" ng-hide="hasTasks">
				<p class="aboutModuleTitle">
					No tasks has been created, you want to <?php echo CHtml::link(Yii::t('tasks','CreateOneTask'), Yii::app()->controller->createUrl('create')); ?> ?
				</p>
			</div>
			<div class="input-append" ng-show="hasTasks">
				<input type="text" class="" placeholder="Filter Search" ng-model="search"> 
				<i class="add-on icon-search"></i>
			</div>
			<hr />
			<section class="panel-body">
				<article class="media" ng-show="hasTasks" ng-repeat="task in tasks | filter:search">
					<span class="pull-left thumb-sm">
						<i class="icon-user icon-2x text-muted"></i>
					</span>
					<div class="media-body">
						<div class="pull-right media-xs text-center text-muted">
							<strong class="h4">{{task.due_date_day}} {{task.due_date_month}}</strong><br />
							<small class="label bg-light">
								{{task.due_date_year}}
							</small>
						</div>
						<a href="#{{task.task_id}}" class="h4">{{task.task_name}}</a>
						<small class="block">
							<a href="{{task.userUrl}}" class="">{{task.userName}}</a>
							<span class="label {{task.statusCss}}">
								{{task.status_name}}
							</span>
						</small>
						<small class="block m-t-sm">
							{{task.task_description}}<br />
							<span class="label {{task.task_priorityCss}}">
								{{task.task_priority}}
							</span>
							<span class="label label-info" ng-show="task.countComments>0">
								{{task.countComments}} Comments <i class="icon-comment"></i>
							</span><br />
						</small>
					</div>
					<div class="line pull-in"></div>
				</article>
			</section>
		</section>
	</article>
</div>

<ng-view></ng-view>

<?php
$assets = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.modules.milestones.static.js'));

$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/lib/angular.min.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/tasks.module.js', CClientScript::POS_END);
$cs->registerScript('tasksScript', "
	(function(window) {
    	'use strict';
    	var CelesticParams = window.CelesticParams || {};
    	CelesticParams.URL = {
			'home':'".$this->createUrl('index')."',
			'create':'".$this->createUrl('create')."',
			'view':'".$this->createUrl('view')."'
	    };
	    CelesticParams.Forms = {
	    	'CSRF_Token':'".Yii::app()->request->csrfToken."',
	    	'createForm': '".$createIdForm."',
	    	'updateForm': '".$updateIdForm."',
	    	'fields': ".CJSON::encode($formFields)."
	    };
	    window.CelesticParams = CelesticParams;
    }(window));
", CClientScript::POS_BEGIN);
?>