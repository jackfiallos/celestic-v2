<?php
$this->pageTitle = Yii::app()->name." - ".Yii::t('milestones', 'TitleMilestones');
?>

<div ng-controller="celestic.milestones.home.controller">
	<article class="widget widget-4 data-block milestones" ng-show="ishome">
		<header class="widget-head">
			<h3 class="module-title"><i class="icon-calendar-empty icon-2"></i><?php echo Yii::t('milestones', 'TitleMilestones'); ?></h3>
			<div class="data-header-actions">
				<?php echo CHtml::link("<i class=\"icon-plus-sign\"></i> ".Yii::t('milestones', 'CreateMilestones'), $this->createUrl('index', array('#'=>'/create')), array('class'=>'btn btn-primary', 'ng-click'=>'milestonesForm=true', 'ng-hide'=>'milestonesForm', 'title'=>Yii::t('milestones', 'CreateMilestones'))); ?>
			</div>
		</header>
		<section class="widget-body">
			<?php echo $this->renderPartial('_form', array(
				'model'=>$model, 
				'users'=>$users,
				'action'=>$this->createUrl('create'),
				'id'=>'milestones-form-create'
			)); ?>
			<div class="aboutModule" ng-hide="hasMilestones">
				<p class="aboutModuleTitle">
					No milestones has been created, you want to <?php echo CHtml::link(Yii::t('milestones','CreateOneMilestone'), $this->createUrl('index', array('#'=>'/create'))); ?> ?
				</p>
				<div class="aboutModuleInformation shadow corners">
					<h2 class="aboutModuleInformationBoxTitle"><?php echo Yii::t('milestones','AboutMilestones'); ?></h2>
					<ul class="aboutModuleInformationList">
						<li>
							<?php echo CHtml::image(Yii::app()->request->baseUrl.'/images/tick.png', '', array('class'=>'aboutModuleInformationIcon')); ?>
							<span class="aboutModuleInformationTitle"><?php echo Yii::t('milestones','MilestoneInformation_l1'); ?></span>
							<span class="aboutModuleInformationDesc"><?php echo Yii::t('milestones','MilestoneDescription_l1'); ?></span>
						</li>
						<li>
							<?php echo CHtml::image(Yii::app()->request->baseUrl.'/images/tick.png', '', array('class'=>'aboutModuleInformationIcon')); ?>
							<span class="aboutModuleInformationTitle"><?php echo Yii::t('milestones','MilestoneInformation_l2'); ?></span>
							<span class="aboutModuleInformationDesc"><?php echo Yii::t('milestones','MilestoneDescription_l2'); ?></span>
						</li>
						<li>
							<?php echo CHtml::image(Yii::app()->request->baseUrl.'/images/tick.png', '', array('class'=>'aboutModuleInformationIcon')); ?>
							<span class="aboutModuleInformationTitle"><?php echo Yii::t('milestones','MilestoneInformation_l3'); ?></span>
							<span class="aboutModuleInformationDesc"><?php echo Yii::t('milestones','MilestoneDescription_l3'); ?></span>
						</li>
					</ul>
				</div>
			</div>
			<div class="input-append" ng-show="hasMilestones">
				<input type="text" class="" placeholder="Filter Search" ng-model="search"> 
				<i class="add-on icon-search"></i>
			</div>
			<hr ng-show="hasMilestones" />
			<div class="view" ng-show="hasMilestones" ng-repeat="milestone in milestones | filter:search">
				<span class="description">
					<div class="row-fluid">
						<div class="span8">
							<h3>
								<a href="{{milestone.url}}">
									{{milestone.title}}
								</a>
							</h3>
						</div>
						<div class="span4">
							<div class="progress progress-striped" title="{{milestone.completed}}%" ng-show="milestone.completed > 0">
								<span class="percent">{{milestone.completed}}%</span><div class="bar" style="width:{{milestone.completed}}%;"></div>
							</div>
						</div>
					</div>
					<span class="icon">
						<!-- <i class="icon-calendar icon-3x"></i> -->
						<div class="aU5">
							<span class="aRh">{{milestone.due_date_month}}</span>
							<span class="aRg">{{milestone.due_date_day}}</span>
							<span class="aRj">{{milestone.due_date_dayWeek}}</span>
						</div>
					</span>
					<blockquote>
						<div class="moduleTextDescription corners">
							<span ng-bind-html-unsafe="milestone.description"></span>
						</div>
						<div class="dfooter">
							<span>
								<?php echo Yii::t('milestones', 'user_id'); ?> <a href="{{milestone.userOwnerUrl}}">{{milestone.userOwner}}</a>
								<span>
									- Due date <abbr class="timeago" title="{{milestone.due_date}}">
										{{milestone.due_dateFormatted}}
									</abbr>
								</span>
							</span>
							<a href="{{milestone.url}}" ng-show="milestone.countComments > 0">
								<span class="label label-info">{{milestone.countComments}} <?php echo Yii::t('site','comments'); ?> <i class="icon-comment"></i> </span>
							</a>
							<div>
								<a href="{{milestone.url}}">
									<?php echo Yii::t('milestones','ViewDetails'); ?>
								</a>
							</div>
						</div>
					</blockquote>
				</span>
			</div>
		</section>
	</article>
</div>

<ng-view></ng-view>

<?php
$assets = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.modules.milestones.static.js'));

$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/lib/angular.min.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/milestones.module.js', CClientScript::POS_END);
$cs->registerScript('milestonesScript', "
	(function(window) {
    	'use strict';
    	var CelesticParams = window.CelesticParams || {};
    	CelesticParams.URL = {
	        'create':'".$this->createUrl('create')."',
	        'update':'".$this->createUrl('update')."',
	        'view':'".$this->createUrl('view')."',
	        'home':'".$this->createUrl('index')."'
	    };
	    CelesticParams.Forms = {
	    	'CSRF_Token':'".Yii::app()->request->csrfToken."'
	    };
	    window.CelesticParams = CelesticParams;
    }(window));

", CClientScript::POS_BEGIN);
?>