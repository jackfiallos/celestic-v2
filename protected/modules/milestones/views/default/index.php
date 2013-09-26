<?php
$this->pageTitle = Yii::app()->name." - ".Yii::t('milestones', 'TitleMilestones');
?>

<div ng-controller="celestic.milestones.home.controller">
	<article class="data-block milestones" ng-show="ishome">
		<header>
			<h1>
				<?php echo Yii::t('milestones', 'TitleMilestones'); ?>
			</h1>
			<div class="data-header-actions">
				<?php echo CHtml::link("<i class=\"icon-plus-sign\"></i> ".Yii::t('milestones', 'CreateMilestones'), $this->createUrl('index', array('#'=>'/create')), array('class'=>'btn')); ?>
			</div>
		</header>
		<section>
			<input type="text" class="search-query" placeholder="Filter Search" ng-model="search">
			<hr />
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
						<img style="width:64px;height:64px" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/icons/PNG.png">
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
									 ({{milestone.due_date}})
								</span>
							</span>
							<a href="{{milestone.url}}" ng-show="milestone.countComments > 0">
								<span class="label label-info">{{milestone.countComments}}<?php Yii::t('site','comments'); ?></span>
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