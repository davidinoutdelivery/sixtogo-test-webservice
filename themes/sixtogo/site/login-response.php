<?php
	use yii\helpers\Html;
	use yii\web\Session;

	$session = Yii::$app->session;
	$session->open();

	if ($response->status == 'success') {
		// HA INICIADO SESION CORRECTAMENTE
?>
		<div class="alert alert-success">
          	<h5 class="gotham-medium">Exitosa</h5>
          	<p class="gotham-medium">
            	Has iniciado sesión correctamente.
          	</p>
        </div>
        <a class="btn-back pull-left" href="../site/login">
          <i class="fa fa-chevron-left"></i> Volver
        </a>
<?php
	}else{
		// NO PUDO INICIAR SESION
?>
		<div class="alert alert-danger">
          	<h5 class="gotham-medium">Error</h5>
          	<p class="gotham-medium">
            	No has podido iniciar sesión, verifica tu email y contraseña.
          	</p>
        </div>
        <a class="btn-back pull-left" href="../site/login">
          <i class="fa fa-chevron-left"></i> Volver
        </a>
<?php
	}


	$this->registerCssFile("@web/css/account.css", [
	    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
	], 'account');