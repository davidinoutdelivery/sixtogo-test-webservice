<?php
	use yii\helpers\Html;

	if ($response['status'] == 'success') {
    // HA INICIADO SESION CORRECTAMENTE
  ?>
      <div class="alert alert-success">
              <h5 class="gotham-medium">Exitosa</h5>
              <p class="gotham-medium">
                <?php echo $response['message'];?>
              </p>
          </div>
          <a class="btn-back pull-left" href="../site/register">
            <i class="fa fa-chevron-left"></i> Volver
          </a>
  <?php
    }else{
      // NO PUDO INICIAR SESION
  ?>
      <div class="alert alert-danger">
              <h5 class="gotham-medium">Error</h5>
              <p class="gotham-medium">
                <?php echo $response['message'];?>
              </p>
          </div>
          <a class="btn-back pull-left" href="../site/register">
            <i class="fa fa-chevron-left"></i> Volver
          </a>
  <?php
    }

	$this->registerCssFile("@web/css/account.css", [
      'depends' => [\yii\bootstrap\BootstrapAsset::className()],
  ], 'register');