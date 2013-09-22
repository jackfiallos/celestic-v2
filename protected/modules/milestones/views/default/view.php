<article class="data-block documents">
	<header>
		<h3>
			{{milestone.title}}
		</h3>
		<div class="data-header-actions">
			<?php echo CHtml::link("<i class=\"icon-list\"></i> ".Yii::t('milestones', 'ListMilestones'), $this->createUrl('index', array('#'=>'/home')), array('class'=>'btn', 'ng-click'=>'showHome()')); ?>
			<?php echo CHtml::link("<i class=\"icon-plus-sign\"></i> ".Yii::t('milestones', 'CreateMilestones'), $this->createUrl('index', array('#'=>'/create')), array('class'=>'btn')); ?>
			<a href="milestone_editUrl" ng-show="canEditMilestone">
				<?php echo Yii::t('milestones', 'UpdateMilestones'); ?>
			</a>
		</div>
	</header>
	<section>
		<div>
			<span>
				<img src="" />
			</span>
			<div class="ddescription">{{milestone.description}}</div>
			<div><?php echo Yii::t('milestones', 'milestone_duedate'); ?>: {{milestone.duedate}}</div>
			<div>
				<?php echo Yii::t('milestones', 'user_id'); ?>:
				<a href="{{milestone.ownerUrl}}">{{milestone.owner}}</a>
			</div>
			<div class="progress progress-striped" title="{{milestone.completed}}%" ng-show="milestone.completed > 0">
				<div class="bar" style="width:23%;"></div>
			</div>
			<div>{{milestone.percent}}</div>
		</div>
		<ul>
			<li ng-repeat="task in milestone.dataProviderTasks">
				{{task.task_name}}
			</li>
		</ul>
		<hr />
		<div class="result">
			<?php $this->widget('widgets.ListComments',array(
				'resourceid'=>4,
				'moduleid'=>7,
			)); ?>
		</div>
	</section>
</article>