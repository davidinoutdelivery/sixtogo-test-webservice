<?php
use yii\helpers\Html;

$this->title = 'RESPUESTA DE SOLICITUD';
$this->registerCss(".btn-back { 
    box-sizing: border-box;
    padding: 0 30px;
    text-align: center; 
    color: #fff;
    font-size: 15px;
    font-family: 'GothamRoundedBook';
    background: #ff3d2f;
    border: none;
    transition: 0.4s;
    height: 42px;
    line-height: 42px;
    border-radius: 500px;
    font-family: Gotham-Medium;
}
");

?>

<div class="row">
    <div class="col-xs-12 col-md-6" style="margin: auto;text-align: center;float: none;">  
        <h3><?= Html::encode($this->title) ?></h3>

        <div class="row">

            <div class="col-12">
                
               	<?php 

               		if ($response['validate']) {
               			# SE HA VALIDADO EL EMAIL, GENERADO EL TOKEN Y ENVIO DE CORREO ELECTRÒNICO
               	?>
						<div class="alert alert-success">
							<h5 class="gotham-medium">Exitosa</h5>
							<p class="gotham-medium">
								Te hemos enviado un enlace para el cambio de contraseña, por favor revisa la bandeja de entradas de tu correo electrónico <b><?php echo $response['email'];?></b>.
							</p>
						</div>
				<?php
               		}else{
               			# EL EMAIL INGRESADO NO ESTA REGISTRADO EN LA BASE DE DATOS
               	?>
						<div class="alert alert-danger">
							<h5 class="gotham-medium">Ha ocurrido un error</h5>
							<p class="gotham-medium">
								Lo sentimos, el email ingresado <b><?php echo $response['email'];?></b> no se encuentra registrado en nuestro sistema.
							</p>
						</div>
               	<?php
               		}

               	?>
				
				<a class="btn-back pull-left" href="../site/index">
					<i class="fa fa-chevron-left"></i> Volver
				</a>

            </div>

        </div>

    </div>
</div>