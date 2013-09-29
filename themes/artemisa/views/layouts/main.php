<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>    <html class="lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>    <html class="lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en" ng-app="celestic"> <!--<![endif]-->
<head>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<meta charset="UTF-8" />
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="expires" content="0" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
	<link href="<?php echo Yii::app()->theme->baseUrl; ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?php echo Yii::app()->theme->baseUrl; ?>/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
	<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/glyphicons.css" rel="stylesheet" />
	<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.min.css" rel="stylesheet" />
	<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/widgets.css" rel="stylesheet" />
	<!-- <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/font-awesome.min.css" rel="stylesheet" /> -->
	<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
	<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
	<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/global.css" rel="stylesheet" />
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo Yii::app()->request->baseUrl; ?>/favicon.png" />
	<!--[if IE]>
    <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/libs/excanvas.js"></script>
    <![endif]-->
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/lib/modernizr.js"></script>
</head>
<body>
	<!-- Start Content -->
	<div class="container-fluid fixed">
		<div class="navbar main">
			<a href="<?php echo Yii::app()->createUrl('/'); ?>" class="appbrand">
				<span>
					<?php echo Yii::app()->name; ?> 
					<span><?php echo Yii::app()->user->getState('project_selectedName'); ?></span>
				</span>
			</a>
			<?php if (!Yii::app()->user->isGuest): ?>
				<div id="info">
					<h4><?php echo Yii::t('site','WelcomeMessage'); ?></h4>
					<p>
						<?php echo Yii::t('site','LoggedAs')." ".CHtml::link(CHtml::encode(Yii::app()->user->CompleteName),Yii::app()->createUrl('users/view', array('id'=>Yii::app()->user->id))); ?>
						<br />
						<?php
							if (strtotime(Yii::app()->user->getState('user_lastLogin')) != null)
							{
								echo Yii::t('users','user_lastLogin')." ".Yii::app()->dateFormatter->format('dd.MM.yyyy', Yii::app()->user->getState('user_lastLogin'));
							}
						?>
					</p>
					<?php 
						// $this->widget('application.extensions.VGGravatarWidget.VGGravatarWidget', 
						// 	array(
						// 		'email' => CHtml::encode(Yii::app()->user->getState('user_email')),
						// 		'hashed' => false,
						// 		'default' => 'http://'.$_SERVER['SERVER_NAME'].Yii::app()->request->baseUrl.'/images/bg-avatar.png',
						// 		'size' => 65,
						// 		'rating' => 'PG',
						// 		'htmlOptions' => array('class'=>'borderCaption','alt'=>'Gravatar Icon' ),
						// 	)
						// );
					?>
				</div>
			<?php endif; ?>
			<!-- <ul class="topnav pull-right">
				<li class="nav-menu-item">
					<a href="#" data-toggle="dropdown">
						<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/lang/<?php echo Yii::app()->params['languages']['en_us']['icon']; ?>" alt="en" />
					</a>
			    	<ul class="dropdown-menu pull-right">
			    		<?php foreach (Yii::app()->params['languages'] as $key => $value): ?>
			      		<li>
			      			<a href="?lang=en" title="<?php echo Yii::app()->params['languages'][$key]['title']; ?>">
			      				<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/lang/<?php echo Yii::app()->params['languages'][$key]['icon']; ?>" alt="<?php echo Yii::app()->params['languages'][$key]['title']; ?>">
			      				<?php echo Yii::app()->params['languages'][$key]['title']; ?>
			      			</a>
			      		</li>
			      		<?php endforeach;?>
			    	</ul>
				</li>
			</ul> -->
		</div>
		
		<div id="wrapper">
			<div id="menu" class="nav-menu-item">
				<div id="menuInner">
					<div id="search">
						<input type="text" placeholder="search ..." />
						<button class="glyphicons search"><i></i></button>
					</div>
					<?php
						$this->widget('widgets.applicationModules');
					?>
				</div>
			</div>			
			<div id="content">
				<?php
					$this->widget('zii.widgets.CBreadcrumbs', array(
						'links'=>$this->breadcrumbs,
						'encodeLabel'=>false
					));
				?>
				<?php echo $content; ?>
				<br/>
			</div>
		</div>
	</div>

	<?php
  	$cs=Yii::app()->clientScript;
  	Yii::app()->clientScript->registerCoreScript('jquery');
  	Yii::app()->clientScript->registerCoreScript('jquery.ui');
  	$cs->registerScriptFile(Yii::app()->theme->baseUrl.'/bootstrap/js/bootstrap.min.js', CClientScript::POS_END);
  	$cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/lib/jquery.timeago.js',CClientScript::POS_END);
  	$cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/site.js', CClientScript::POS_END);
  	$cs->registerScript('mainScript',"
        jQuery('.dropdown-toggle').dropdown();

		".Yii::t('site','jquery.timeago.configuration')."
        jQuery.timeago.settings.allowFuture = true;
        jQuery('abbr.timeago').timeago();
    ", CClientScript::POS_READY);
  	?>

</body>
</html>