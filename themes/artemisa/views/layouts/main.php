
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>    <html class="lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>    <html class="lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html> <!--<![endif]-->
<head>
	<title>Celestic Project Manager</title>	
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<link href="<?php echo Yii::app()->theme->baseUrl; ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/glyphicons.css" rel="stylesheet" />
	<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/uniform.default.css" rel="stylesheet" media="screen" />
	<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.min.css" rel="stylesheet" />
	<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/widgets.css" rel="stylesheet" />
	<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/font-awesome.min.css" rel="stylesheet" />
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/modernizr.custom.76094.js"></script>
	<link rel="shortcut icon" href="<?php echo Yii::app()->theme->baseUrl; ?>/favicon.ico">
	<!--[if IE]>
    <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/excanvas.js"></script>
    <![endif]-->
</head>
<body>
	<!-- Start Content -->
	<div class="container-fluid fixed">	
		<div class="navbar main">
			<a href="<?php echo Yii::app()->createUrl('/'); ?>" class="appbrand">
				<span>Celestic <span>[Project Name]</span></span>
			</a>
			<ul class="topnav pull-right">
				<li class="dropdown">
					<a href="" data-toggle="dropdown" class="glyphicons cogwheel">
						<i></i>Projects <span class="caret"></span>
					</a>
					<?php
					$this->widget('widgets.projectList');
					?>
				</li>
				<li class="dropdown">
					<a data-toggle="dropdown" href="form_demo.html?lang=en" class="glyphicons user">
						<i></i>Jack <span class="caret"></span>
					</a>
					<ul class="dropdown-menu pull-right">
						<li><a href="form_demo.html?lang=en" class="glyphicons cogwheel">Configuration<i></i></a></li>
						<li class="highlight profile">
							<span>
								<span class="img"></span>
								<span class="details">
									<a href="<?php echo Yii::app()->createUrl('users/view', array('id'=>Yii::app()->user->id)); ?>">Mosaic Pro</a>
									contact@mosaicpro.biz
								</span>
								<span class="clearfix"></span>
							</span>
						</li>
						<li>
							<span>
								<a class="btn btn-default btn-small pull-right" style="padding: 2px 10px; background: #fff;" href="<?php echo Yii::app()->createUrl('site/logout'); ?>">Logout</a>
							</span>
						</li>
					</ul>
				</li>
				<li class="nav-menu-item">
					<a href="#" data-toggle="dropdown">
						<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/lang/<?php echo Yii::app()->params['languages']['en_us']['icon']; ?>" alt="en" />
					</a>
			    	<ul class="dropdown-menu pull-right">
			    		<?php foreach (Yii::app()->params['languages'] as $language): ?>
			      		<li class="<?php echo ($language == $this->locale) ? 'active' : ''; ?>">
			      			<a href="?lang=en" title="<?php echo $language['title']; ?>">
			      				<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/lang/<?php echo $language['icon']; ?>" alt="<?php echo $language['title']; ?>">
			      				<?php echo $language['title']; ?>
			      			</a>
			      		</li>
			      		<?php endforeach;?>
			    	</ul>
				</li>
			</ul>
		</div>
		
		<div id="wrapper">
			<div id="menu" class="nav-menu-item">
				<div id="menuInner">
					<div id="search">
						<input type="text" placeholder="search ..." />
						<button class="glyphicons search"><i></i></button>
					</div>
					<?php
					$this->widget('widgets.modules');
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
		
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.sparkline.min.js" type="text/javascript"></script>
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.uniform.min.js"></script>
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/bootstrap/js/bootbox.min.js" type="text/javascript"></script>

	<?php
  	$cs=Yii::app()->clientScript;
  	Yii::app()->clientScript->registerCoreScript('jquery');
  	Yii::app()->clientScript->registerCoreScript('jquery.ui');
  	$cs->registerScript('mainScript',"
        
    ", CClientScript::POS_READY);
  	?>

</body>
</html>