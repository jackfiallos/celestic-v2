<?php
$this->pageTitle = Yii::app()->name." - ".Yii::t('cases', 'TitleCases');
?>

<div ng-controller="celestic.cases.home.controller">
	<article class="widget widget-4 data-block cases" ng-show="ishome">
		<header class="widget-head">
			<h3 class="module-title"><i class="icon-gear icon-2"></i><?php echo Yii::t('cases', 'TitleCases'); ?></h3>
			<div class="data-header-actions">
				<?php echo CHtml::link("<i class=\"icon-plus-sign\"></i> ".Yii::t('cases','CreateCases'), $this->createUrl('index', array('#'=>'/create')), array('ng-click'=>'casesForm=true', 'ng-hide'=>'casesForm', 'class'=>'btn btn-primary', 'title'=>Yii::t('cases', 'CreateCases'))); ?>
			</div>
		</header>
		<section class="widget-body">
			<?php echo $this->renderPartial('_form', array(
				'model'=>$model, 
				'action'=>$this->createUrl('create'),
				'id'=>'cases-form-create'
			)); ?>
			<div class="aboutModule" ng-hide="hasCases">
				<p class="aboutModuleTitle">
					No cases has been created, you want to <?php echo CHtml::link("<i class=\"icon-plus-sign\"></i> ".Yii::t('cases','CreateOneCase'), $this->createUrl('index', array('#'=>'/create'))); ?> ?
				</p>
				<div class="aboutModuleInformation shadow corners">
					<h3 class="aboutModuleInformationBoxTitle">
						<?php echo Yii::t('cases','AboutCases'); ?>
					</h3>
					<ul class="aboutModuleInformationList">
						<li>
							<?php echo CHtml::image(Yii::app()->request->baseUrl.'/images/tick.png', '', array('class'=>'aboutModuleInformationIcon')); ?>
							<span class="aboutModuleInformationTitle"><?php echo Yii::t('cases','CaseInformation_l1'); ?></span>
							<span class="aboutModuleInformationDesc"><?php echo Yii::t('cases','CaseDescription_l1'); ?></span>
						</li>
						<li>
							<?php echo CHtml::image(Yii::app()->request->baseUrl.'/images/tick.png', '', array('class'=>'aboutModuleInformationIcon')); ?>
							<span class="aboutModuleInformationTitle"><?php echo Yii::t('cases','CaseInformation_l2'); ?></span>
							<span class="aboutModuleInformationDesc"><?php echo Yii::t('cases','CaseDescription_l2'); ?></span>
						</li>
						<li>
							<?php echo CHtml::image(Yii::app()->request->baseUrl.'/images/tick.png', '', array('class'=>'aboutModuleInformationIcon')); ?>
							<span class="aboutModuleInformationTitle"><?php echo Yii::t('cases','CaseInformation_l3'); ?></span>
							<span class="aboutModuleInformationDesc"><?php echo Yii::t('cases','CaseDescription_l3'); ?></span>
						</li>
					</ul>
				</div>
			</div>
			<div class="input-append" ng-show="hasCases">
				<input type="text" class="" placeholder="Filter Search" ng-model="search"> 
				<i class="add-on icon-search"></i>
			</div>
			<div class="view" ng-show="hasCases" ng-repeat="case in cases | filter:search">
				<div class="groupdate">
					{{case.timestamp}}
				</div>
				<span class="description">
					<div class="row-fluid">
						<div class="span8">
							<h3>
								<a href="{{case.url}}">
									{{case.name}}
								</a>
							</h3>
						</div>
						<div class="span4" style="text-align:right" ng-show="case.code.length > 0">
							{{case.code}}
						</div>
					</div>
					<span class="icon">
						<i class="icon-gear icon-3x"></i>
					</span>
					<blockquote>
						<div class="moduleTextDescription corners">
							<span ng-bind-html-unsafe="case.description"></span>
						</div>
						<div class="dfooter">
							<span>
								<?php echo Yii::t('cases','case_actors'); ?>: {{case.actors}}
							</span><br />
							<div class="label {{case.cssClass}}">
								{{case.priority}}
							</div>
							<a href="{{case.url}}" ng-show="case.countComments > 0">
								<span class="label label-info">{{case.countComments}} <?php echo Yii::t('site','comments'); ?> <i class="icon-comment"></i> </span>
							</a>
							<div>
								<a href="{{case.url}}">
									<?php echo Yii::t('cases','ViewDetails'); ?>
								</a>
							</div>
						</div>
					</blockquote>
				</span>
			</div>
		</section>
	</article>
</div>

<ng-view>Loading...</ng-view>

<?php
$assets = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.modules.cases.static.js'));

$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/lib/angular.min.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/cases.module.js', CClientScript::POS_END);
$cs->registerScript('casesScript', "
	(function(window) {
    	'use strict';
    	var CelesticParams = window.CelesticParams || {};
    	CelesticParams.URL = {
			'home':'".$this->createUrl('index')."',
			'create':'".$this->createUrl('create')."',
			'view':'".$this->createUrl('view')."'
	    };
	    CelesticParams.Forms = {
	    	'CSRF_Token':'".Yii::app()->request->csrfToken."'
	    };
	    window.CelesticParams = CelesticParams;
    }(window));
", CClientScript::POS_BEGIN);
?>