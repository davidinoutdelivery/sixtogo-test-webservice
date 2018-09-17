<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = ($response['validateEmailToken']) ? 'ACTUALIZA TU CONTRASEÑA' : 'TOKEN INVÁLIDO';

?>
<div class="row">
    <div class="col-xs-12 col-md-6" style="margin: auto;text-align: center;float: none;">  
        <?php
    		if ($response['validateEmailToken']) 
    		{
    			# 	GENERAMOS EL FORMULARIO DE ACTUALIZACION DE CONTRASEÑA
    	?>
		        <h3 class="gotham-medium"><?= Html::encode($this->title) ?></h3>
			
				<?= Html::img('@web/images/logo.png', ['alt' => 'LogoSixToGo','width' => '199px', 'height' => '150px']) ?>

				<p class="gotham-medium">A continuación actualiza tu contraseña.</p>

		        <div class="row">

		            <div class="col-12">
		            	
								<?php $form = ActiveForm::begin(['id' => 'form-password-change']); ?>

				                    <?= $form->field($model, 'password')->input('password')->label('Nueva Contraseña') ?>
				                    <?= $form->field($model, 'repeat_password')->input('password')->label('Repetir Contraseña') ?>

				                    <div class="form-group">
				                        <?= Html::submitButton('<i class="fa fa-envelope"></i> Actualizar Contraseña', ['class' => 'btn-send-message gotham-medium', 'name' => 'send-button']) ?>
				                    </div>

				                <?php ActiveForm::end(); ?>
		            	
		            </div>
		        </div>
        <?php
    		}
    		else
    		{
    			#	VALIDACION INVALIDA
    	?>
				<h3 class="gotham-medium"><?= Html::encode($this->title) ?></h3>
				<p class="gotham-medium">Lo sentimos, algo salió mal con el token de validación.</p>
    	<?php
    		}
    	?>
    </div>
</div>
<?php
$this->registerCssFile("@web/css/account.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
], 'account');