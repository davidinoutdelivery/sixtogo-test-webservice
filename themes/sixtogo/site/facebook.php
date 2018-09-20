<?php
	use yii\helpers\Html;
	use yii\web\Session;
	
	$session = Yii::$app->session;
	$session->open();

	if (isset($session['facebook'])) {
		echo "<pre>";
		print_r($session['facebook']);
		print_r($session['user']);
		echo "</pre>";
	}

	