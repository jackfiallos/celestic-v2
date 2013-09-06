<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>
<div class="error_main">
<!--Place Your Logo Here--> 
	<div class="logo">
		<a href="#" title="Place your logo here">
			<img src="<?php echo Yii::app()->baseUrl; ?>images/celestic.png" alt="<?php echo CHtml::encode(Yii::app()->name).' v.'.Yii::app()->params['appVersion']?>">
		</a>
	</div>
	<!--Displays UFO -->
	<div class="ufo ufo-image">
	</div>
	<!--You can change this text to any type of error you need (401, 403, 404, 500, 503, etc...) -->  
	<h2 class="text_1">
		<span class="error_text_span"><?php echo $code; ?> error</span>
	</h2>

	<h1 class="text_2">
		<span class="big_error_text_span custom_font">We've got a problem</span>
	</h1>

	<div class="text_3">
		<p class="reasons_small custom_font">
			<?php echo CHtml::encode($message); ?>
		</p>
	</div>

	<div class="text_4">
		<p class="solutions_text custom_font">As always we are offering you solutions</p>
	</div>

	<div class="links_1">
		<ul class="custom_font">
			<li><a href="#">Home</a></li>
			<li><a href="#">Services</a></li>
			<li><a href="#">Blog</a></li>
			<li><a href="#">Products</a></li>
			<li><a href="#">About Us</a></li>
			<li><a href="#">Contact Us</a></li>
		</ul>
	</div>
</div>