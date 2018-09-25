<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\Session;

$session = Yii::$app->session;
$session->open();

$this->title = 'Perfil de Usuario';

//echo "<pre>";
//print_r($user);
//echo "</pre>";

$rid = $user['rid'];

if (isset($session['response_facebook'])) {
    echo "<pre>";
    print_r($session['response_facebook']);
    echo "</pre>";
}


?>
<div class="row">
    <div class="col-xs-12 col-md-6" style="margin: auto;text-align: center;float: none;">
        
        <h1 class="gotham-medium"><?php echo $this->title;?></h1>

        <?= Html::img('@web/images/logo.png', ['alt' => 'LogoSixToGo','width' => '199px', 'height' => '150px']) ?>


        <?php $form = ActiveForm::begin(['id' => 'register-form']); ?>
                
            <?= $form->field($model, 'rid')->hiddenInput(['value' => $rid])->label(false) ?>

            <?= $form->field($model, 'name')->textInput(['autofocus' => true,'value' => $user['nameFirst']])->label("Nombre") ?>

            <?= $form->field($model, 'lastname')->textInput(['value' => $user['nameLast']])->label("Apellido") ?>

            <?= $form->field($model, 'email')->textInput(['readonly' => true,'value' => $user['email']])->label("Correo electrónico") ?>

            <?= $form->field($model, 'phone')->textInput(['value' => $user['phone']])->label("Teléfono") ?>

            <?= $form->field($model, 'password')->passwordInput()->label("Contraseña") ?>

            <?= $form->field($model, 'passwordRepeat')->passwordInput()->label("Confirmar Contraseña") ?>


            <div class="form-group">
                <div class="col-lg-12">
                    <?= Html::submitButton('<i class="fa fa-edit"></i> Actualizar', ['class' => 'btn btn-primary btn-update gotham-medium', 'name' => 'login-button']) ?>
                </div>
            </div>

            <div class="col-lg-12">
                    
                <a class="facebook auth-link btn-facebook" href="/account/auth?authclient=facebook" title="Facebook" ><i class="fab fa-facebook"></i> Asociar cuenta de Facebook</a>
                        
            </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
<?php
$this->registerCssFile("@web/css/account.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
], 'register');
