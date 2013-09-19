<?php
$this->pageTitle = Yii::app()->name." - ".Yii::t('documents', 'TitleDocuments');
?>

<div ng-controller="celestic.documents.home.controller">
	<article class="data-block documents" ng-show="ishome">
		<header>
			<h1>
				<?php echo Yii::t('documents', 'TitleDocuments'); ?>
			</h1>
			<div class="data-header-actions">
				<?php echo CHtml::link("<i class=\"icon-plus-sign\"></i> ".Yii::t('documents', 'CreateDocuments'), $this->createUrl('index', array('#'=>'/create')), array('class'=>'btn')); ?>
			</div>
		</header>
		<section>
			<input type="text" class="search-query" placeholder="Filter Search" ng-model="search">
			<div class="view" ng-show="hasDocuments" ng-repeat="document in documents | filter:search">
				<div class="groupdate" ng-show="CreateHeader(document.timestamp)">
					{{document.timestamp}}
				</div>
				<span class="icon">
					<img style="width:64px;height:64px" src="{{document.imageType}}">
				</span>
				<span class="description">
					<h3>
						<a href="{{document.url}}" title="{{document.name}}">
							#{{document.id}} - {{document.name}}
						</a>
					</h3>
					<div class="moduleTextDescription corners">
						{{document.description}}
					</div>
					<div class="dfooter">
						<span>
							<?php echo Yii::t('documents', 'user_id'); ?> <a href="{{document.userUrl}}">{{document.userName}}</a>
						</span>
						<div>
							<a href="{{document.downloadLink}}">{{labels.downloadLabel}}</a> {{labels.orLabel}}
							<a href="{{document.url}}" title="{{document.name}}">
								{{labels.viewDetailsLabel}}
							</a>
						</div>
					</div>
				</span>
			</div>
			<div class="aboutModule" ng-hide="hasDocuments">
				<p class="aboutModuleTitle">
					No documents has been created, you want to <?php echo CHtml::link("<i class=\"icon-plus-sign\"></i> ".Yii::t('documents','CreateOneDocument'), $this->createUrl('index', array('#'=>'/create'))); ?> ?
				</p>
				<div class="aboutModuleInformation shadow corners">
					<h3 class="aboutModuleInformationBoxTitle">
						<?php echo Yii::t('documents','AboutDocuments'); ?>
					</h3>
					<ul class="aboutModuleInformationList">
						<li>
							<?php echo CHtml::image(Yii::app()->request->baseUrl.'/images/tick.png', '', array('class'=>'aboutModuleInformationIcon')); ?>
							<span class="aboutModuleInformationTitle"><?php echo Yii::t('documents','DocumentInformation_l1'); ?></span>
							<span class="aboutModuleInformationDesc"><?php echo Yii::t('documents','DocumentDescription_l1'); ?></span>
						</li>
						<li>
							<?php echo CHtml::image(Yii::app()->request->baseUrl.'/images/tick.png', '', array('class'=>'aboutModuleInformationIcon')); ?>
							<span class="aboutModuleInformationTitle"><?php echo Yii::t('documents','DocumentInformation_l2'); ?></span>
							<span class="aboutModuleInformationDesc"><?php echo Yii::t('documents','DocumentDescription_l2'); ?></span>
						</li>
						<li>
							<?php echo CHtml::image(Yii::app()->request->baseUrl.'/images/tick.png', '', array('class'=>'aboutModuleInformationIcon')); ?>
							<span class="aboutModuleInformationTitle"><?php echo Yii::t('documents','DocumentInformation_l3'); ?></span>
							<span class="aboutModuleInformationDesc"><?php echo Yii::t('documents','DocumentDescription_l3'); ?></span>
						</li>
					</ul>
				</div>
			</div>			
		</section>
	</article>
</div>

<ng-view></ng-view>

<?php
$assets = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.modules.documents.static.js'));

$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/lib/angular.min.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/documents.module.js', CClientScript::POS_END);
$cs->registerScript('documentsScript', "
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