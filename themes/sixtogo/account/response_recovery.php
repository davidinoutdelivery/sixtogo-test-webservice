<?php
use yii\helpers\Html;

$this->title = 'ACTUALIZACIÓN DE CONTRASEÑA';


?>

<div class="row">
    <div class="col-xs-12 col-md-6" style="margin: auto;text-align: center;float: none;">  
        <h3 class="gotham-medium"><?= Html::encode($this->title) ?></h3>

        <div class="row">

            <div class="col-12">
                
              <?php 
                  /*echo "<pre>";
                  print_r($response);
                  echo "</pre>";*/
                  if ($response['response']['changePassword']) {
                    // SE HA VALIDADO EL EMAIL, GENERADO EL TOKEN Y ENVIO DE CORREO ELECTRÒNICO
                ?>
                    <div class="alert alert-success">
                      <h5 class="gotham-medium">Exitosa</h5>
                      <p class="gotham-medium">
                        Tu contraseña ha sido actualizada correctamente.
                      </p>
                    </div>
              <?php
                  }else{
                    // EL EMAIL INGRESADO NO ESTA REGISTRADO EN LA BASE DE DATOS
                ?>
                    <div class="alert alert-danger">
                      <h5 class="gotham-medium">Ha ocurrido un error</h5>
                      <p class="gotham-medium">
                        Lo sentimos, no se pudo actualizar la contraseña
                      </p>
                    </div>
                <?php
                  }

                ?>		

            </div>

            <a class="btn-back pull-left" href="../site/index">
              <i class="fa fa-chevron-left"></i> Volver
            </a>

        </div>

    </div>
</div>
<?php
$this->registerCssFile("@web/css/account.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
], 'account');