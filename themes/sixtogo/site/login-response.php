<?php
	use yii\helpers\Html;
	use yii\web\Session;

	$session = Yii::$app->session;
	$session->open();

	/*if (isset($session['nombre'])) {
		echo "Hola, soy <b>" . $session['nombre'] . "</b>";
	}else{*/
		echo "<pre>";
		//print_r($response);
		print_r($session['user']);
		echo "</pre>";	
	//}
	