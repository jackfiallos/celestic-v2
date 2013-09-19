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
				<?php echo CHtml::link(Yii::t('documents', 'CreateDocuments'), $this->createUrl('index', array('#'=>'/create')), array('class'=>'button primary')); ?>
			</div>
		</header>
		<section>
			<?php if($model->ItemsCount > 0): ?>
				<?php
				$documents = $model->search();
				$days = array();
				foreach ($documents as $data):
				?>
					<?php
					$timestamp = strtotime($data->document_uploadDate);
					if (!in_array(date('d/m/Y', $timestamp), $days))
					{
						array_push($days, date('d/m/Y', $timestamp));
						echo "<div class=\"groupdate\">".Yii::app()->dateFormatter->format('MMMM d, yyy', $timestamp)."</div>";
					}

					$officeDocs = array(
						'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
						'xltx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
						'potx' => 'application/vnd.openxmlformats-officedocument.presentationml.template',
						'ppsx' => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
						'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
						'sldx' => 'application/vnd.openxmlformats-officedocument.presentationml.slide',
						'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
						'dotx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
						'xlam' => 'application/vnd.ms-excel.addin.macroEnabled.12',
						'xlsb' => 'application/vnd.ms-excel.sheet.binary.macroEnabled.12'
					);

					$type = $data->document_type;

					if (in_array($data->document_type, $officeDocs))
					{
						$key = array_search($data->document_type, $officeDocs);
						$type = 'office/'.$key;
					}
					?>
					<div class="view">
						<span class="icon">
							<img style="width:64px;height:64px" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/icons/<?php echo strtoupper(substr(strrchr($type,'/'),1));?>.png" alt="<?php echo CHtml::encode(Yii::app()->name).' v.'.Yii::app()->params['appVersion']?>">
						</span>
						<span class="description">
							<h3>
								<a href="<?php echo $this->createUrl('index', array('#'=>'/view/'.$data->document_id)); ?>" title="">
									<?php echo "#".$data->document_id." - ".CHtml::encode($data->document_name); ?>
								</a>
							</h3>
							<?php
							$countComments = Logs::getCountComments(Yii::app()->controller->module->id, $data->document_id);
							?>
							<div class="moduleTextDescription corners">
								<?php echo ECHtml::word_split(CHtml::encode($data->document_description), 20)."..."; ?>
							</div>
							<div class="dfooter">
								<span>
									<?php echo Yii::t('documents', 'user_id'); ?> <?php echo CHtml::link(CHtml::encode($data->User->user_name),Yii::app()->createUrl('users/view', array('id'=>Yii::app()->user->id))); ?>
								</span>
								<?php if ($countComments > 0): ?>
					          	<a href="<?php echo $this->createUrl('view', array('id'=>$data->document_id, '#'=>'comments')); ?>">
					          		<span class="label label-info"><?php echo $countComments." ".Yii::t('site','comments'); ?></span>
					          	</a>
					          	<?php endif; ?>
					          	<div>
					          		<a href="<?php echo $this->createUrl('download', array('id'=>$data->document_id)); ?>"><?php echo Yii::t("documents","downloadFile"); ?></a> <?php echo Yii::t('site','or'); ?>
					          		<a href="<?php echo $this->createUrl('index', array('#'=>'/view/'.$data->document_id)); ?>" title="">
										<?php echo Yii::t('documents','ViewDetails'); ?>
									</a>
					          	</div>
							</div>
						</span>
					</div>
				<?php endforeach; ?>
			<?php else: ?>
				<div class="aboutModule">
					<p class="aboutModuleTitle">
						No documents has been created, you want to <?php echo CHtml::link(Yii::t('documents','CreateOneDocument'), $this->createUrl('index', array('#'=>'/create'))); ?> ?
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
			<?php endif; ?>
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