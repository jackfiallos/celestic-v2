<!doctype html>
<html lang="en" ng-app="celestic">
	<head>
		<meta charset="UTF-8">
		<meta name="author" content="Qbit Mexhico">
		<meta name="description" content="">
		<meta name="keywords" content="">
		<meta http-equiv="Pragma" content="no-cache" />
		<meta http-equiv="expires" content="0" />
		<title><?php echo CHtml::encode($this->pageTitle); ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
		<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/login.css" rel="stylesheet" />
		<link href='http://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic|Open+Sans:400italic,700italic,400,700' rel='stylesheet' type='text/css'>
		<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet">
		<link rel="shortcut icon" type="image/x-icon" href="<?php echo Yii::app()->request->baseUrl; ?>/favicon.png" />
	</head>
	<body ng-controller="celestic.login.controller">
		<?php echo $content; ?>
	</body>
</html>