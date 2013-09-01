<?php $this->pageTitle = Yii::app()->name." - Project Manager"; ?>

<div ng-switch on="renderAction">
	<!-- Login Form -->
	<div class="login-widget login-login" ng-switch-when="home">
		<header class="login-header">
			<a href="#">
				<img src="<?php echo Yii::app()->baseUrl; ?>images/celestic.png" alt="<?php echo CHtml::encode(Yii::app()->name).' v.'.Yii::app()->params['appVersion']?>">
			</a>
		</header>
		<h4 class="typo login-title">Login 
			<a href="#/new" class="new-account-w">
				<?php echo Yii::t('site','alreadyToRegister'); ?>
			</a>
		</h4>
		<?php
		$form=$this->beginWidget('CActiveForm', array(
			'id'=>'login-form',
			'action'=>Yii::app()->createUrl('site/login', array('#'=>'/home')),
			'htmlOptions'=>array(
				'name'=>'loginForm'
			),
			'enableAjaxValidation'=>false,
		));
		?>
			<div class="form-separator form-field">
				<div class="field-icon field-icon-left">
					<?php
						echo $form->textField($model, 'username', array(
							'class'=>'form form-full',
							'placeholder'=>Yii::t('users', 'user_email'),
							'required'=>'true'
						));
					?>
					<?php echo $form->error($model,'username', array('class'=>'errorMessage labelhelper')); ?>
				</div>
			</div>
			<div class="form-separator form-field">
				<div class="field-icon field-icon-left">
					<?php
						echo $form->passwordField($model, 'password', array(
							'class'=>'form form-full',
							'placeholder'=>'Password',
							'required'=>'true'
						));
					?>
					<?php echo $form->error($model,'password', array('class'=>'errorMessage labelhelper')); ?>
				</div>
			</div>
			<div class="login-submit">
				<a href="#/forget" class="pass-r-w">
					<?php echo Yii::t('site', 'ForgottenPassword'); ?>
				</a>
				<?php echo CHtml::button(Yii::t('site', 'send'), array('type'=>'submit', 'class'=>'btn btn-submit')); ?>
			</div>
		<?php $this->endWidget(); ?>
		<footer class="login-footer">
			<?php echo Yii::app()->name; ?> <?php echo Yii::t('site','CelesticExplanation'); ?>
		</footer>
	</div>
	<!-- New Account -->
	<div class="login-widget new-account" ng-switch-when="new">
		<header class="login-header">
			<a href="#">
				<img src="<?php echo Yii::app()->baseUrl; ?>images/celestic.png" alt="<?php echo CHtml::encode(Yii::app()->name).' v.'.Yii::app()->params['appVersion']?>">
			</a>
		</header>
		<h4 class="typo login-title">New Account <a href="#/home" class="login-w">Login?</a></h4>
		<?php
		$form=$this->beginWidget('CActiveForm', array(
			'id'=>'login-form',
			'action'=>Yii::app()->createUrl('site/login', array('#'=>'/new')),
			'enableAjaxValidation'=>false,
		));
		?>
			<div class="form-separator form-field">
				<div class="field-icon field-icon-left">
					<input type="text" class="form form-full" placeholder="Your username">
				</div>
			</div>
			<div class="form-separator form-field">
				<div class="field-icon field-icon-left">
					<input type="text" class="form form-full" placeholder="Your email">
				</div>
			</div>
			<div class="form-separator form-field">
				<div class="field-icon field-icon-left">
					<input type="password" class="form form-full" placeholder="Your password">
				</div>
			</div>
			<div class="login-submit">
				<input type="submit" value="Sign-up" class="btn btn-submit">
			</div>
		<?php $this->endWidget(); ?>
		<footer class="login-footer">
			Copyright © 2012-2013 Mahieddine Abdelkader.
		</footer>
	</div>
	<!-- Password Forget -->
	<div class="login-widget forget-pass" ng-switch-when="forget">
		<header class="login-header">
			<a href="#">
				<img src="<?php echo Yii::app()->baseUrl; ?>images/celestic.png" alt="<?php echo CHtml::encode(Yii::app()->name).' v.'.Yii::app()->params['appVersion']?>">
			</a>
		</header>
		<h4 class="typo login-title">Forget Pass? <a href="#/home" class="login-w">Login?</a></h4>
		<?php
		$form=$this->beginWidget('CActiveForm', array(
			'id'=>'login-form',
			'action'=>Yii::app()->createUrl('site/login', array('#'=>'/forget')),
			'enableAjaxValidation'=>false,
		));
		?>
			<div class="form-separator form-field">
				<div class="field-icon field-icon-left">
					<input type="text" class="form form-full" placeholder="Email Recovery!">
				</div>
			</div>
			<div class="login-submit">
				<input value="Recover" type="submit" class="btn btn-submit">
			</div>
		<?php $this->endWidget(); ?>
		<footer class="login-footer">
			Copyright © 2012-2013 Mahieddine Abdelkader.
		</footer>
	</div>
</div>

<?php
$cs=Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/lib/angular.min.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/lib/angular-cookies.min.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/login.configuration.js', CClientScript::POS_END);
$cs->registerScript('loginScript', "
	Celestic.loginUrl = '".Yii::app()->createAbsoluteUrl('site/login')."';
	Celestic.CSRF_Token = '".Yii::app()->request->csrfToken."';
");
?>