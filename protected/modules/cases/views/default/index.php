<?php
$this->pageTitle = Yii::app()->name." - ".Yii::t('cases', 'TitleCases');
?>

<div ng-controller="celestic.cases.home.controller">
	<article class="data-block cases" ng-show="ishome">
		<header>
			<h1>
				<?php echo Yii::t('cases', 'TitleCases'); ?>
			</h1>
			<div class="data-header-actions">
				<?php echo CHtml::link(Yii::t('cases', 'CreateCases'), $this->createUrl('index', array('#'=>'/create')), array('class'=>'button primary')); ?>
			</div>
		</header>
		<section>
			<?php if($model->ItemsCount > 0):?>
				<?php
				$cases = $model->search();
				foreach ($cases as $data):
				?>
					<div class="view">
						<span class="description">
							<h3>
								<a href="<?php echo $this->createUrl('index', array('#'=>'/view/'.$data->case_id)); ?>">
									<?php echo CHtml::encode($data->$data->case_name); ?>
								</a>
							</h3>
							<span class="icon">
								<img style="width:64px;height:64px" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/icons/PNG.png" alt="">
							</span>
							<?php
							$countComments = Logs::getCountComments(Yii::app()->controller->module->id, $data->case_id);
							?>
							<blockquote>
								<div class="moduleTextDescription corners">
									<?php echo ECHtml::word_split(CHtml::encode($data->case_description), 20)."..."; ?><br />
								</div>
								<div class="dfooter">
									<?php if ($countComments > 0): ?>
						          	<a href="<?php echo $this->createUrl('view', array('id'=>$data->case_id, '#'=>'comments')); ?>">
						          		<span class="label label-info"><?php echo $countComments." ".Yii::t('site','comments'); ?></span>
						          	</a>
						          	<?php endif; ?>
						          	<div>
						          		<a href="<?php echo $this->createUrl('index', array('#'=>'/view/'.$data->case_id)); ?>">
											<?php echo Yii::t('cases','ViewDetails'); ?>
										</a>
						          	</div>
								</div>
							</blockquote>
						</span>
					</div>
				<?php endforeach; ?>
			<?php else: ?>
				<div class="aboutModule">
					<p class="aboutModuleTitle">
						No cases has been created, you want to <?php echo CHtml::link(Yii::t('cases','CreateOneCase'), $this->createUrl('index', array('#'=>'/create'))); ?> ?
					</p>
					<div class="aboutModuleInformation shadow corners">
						<h2 class="aboutModuleInformationBoxTitle"><?php echo Yii::t('cases','AboutCases'); ?></h2>
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
			<?php endif; ?>
		</section>
	</article>
</div>

<ng-view></ng-view>

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