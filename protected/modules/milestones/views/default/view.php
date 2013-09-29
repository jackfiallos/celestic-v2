<article class="data-block milestones">
	<header>
		<h3>
			{{milestone.title}}
		</h3>
		<div class="data-header-actions">
			<?php echo CHtml::link("<i class=\"icon-list\"></i>", $this->createUrl('index', array('#'=>'/home')), array('class'=>'btn btn-primary', 'ng-click'=>'showHome()', 'title'=>Yii::t('milestones', 'ListMilestones'))); ?>
			<?php if (Yii::app()->user->IsManager):?>
				<?php echo CHtml::link("<i class=\"icon-edit\"></i>", '', array('class'=>'btn btn-primary', 'ng-hide'=>'milestonesForm', 'ng-click'=>'showUpdate()', 'title'=>Yii::t('milestones', 'UpdateMilestones'))); ?>
			<?php endif;?>
		</div>
	</header>
	<section>
		<?php echo $this->renderPartial('_form', array('model'=>$model, 'users'=>$users)); ?>
		<div ng-hide="milestonesForm">
			<div class="ddescription" ng-bind-html-unsafe="milestone.description"></div>
			<div>
				<span class="text-muted">
					<?php echo Yii::t('milestones', 'milestone_duedate'); ?>: 
				</span>
				{{milestone.duedate}}
			</div>
			<div>
				<span class="text-muted">
					<?php echo Yii::t('milestones', 'user_id'); ?>:
				</span>
				<a href="{{milestone.ownerUrl}}">{{milestone.owner}}</a>
			</div>
			<p>
				<div class="progress progress-striped" title="{{milestone.completed}}%" ng-show="milestone.completed > 0">
					<span class="percent">{{milestone.completed}}%</span>
					<div class="bar" style="width:{{milestone.completed}}%;"></div>
				</div>
			</p>
			Filters: 
			<?php foreach($status as $item): ?>
				<span class="showpointer label" ng-click="status='<?php echo $item->status_name; ?>'">
					<?php echo $item->status_name; ?>
				</span>
			<?php endforeach; ?>
			<span class="label" ng-click="status=''">
				All
			</span>
		</div>
		<hr />
		<ul class="tickets">
			<li class="ticket" ng-repeat="task in milestone.dataProviderTasks | filter:status">
				<a href="{{task.task_url}}">
					<span class="header">
						<span class="title">{{task.task_name}}</span>
						<span class="number">[ #{{task.task_id}} ]</span>
					</span>
					<div class="row-fluid">
						<div class="span6">
							<div>{{task.user}}</div>
							<div class="{{task.task_priority_class}}">
								[ {{task.task_priority}} ]
							</div>
						</div>
						<div class="span6" style="text-align:right">
							<div class="text-muted">Status: <span class="blue">{{task.status}}</span></div>
							<div>{{task.task_startDate}}</div>
						</div>
					</span>	                                                        
				</a>
			</li>
		</ul>
		<div class="result">
			<?php
			// $this->widget('widgets.ListComments',array(
			// 	'resourceid'=>4,
			// 	'moduleid'=>7,
			// ));
			?>
		</div>
	</section>
</article>