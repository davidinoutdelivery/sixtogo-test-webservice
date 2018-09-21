<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\base\View;
use yii\bootstrap\ActiveForm;
use yii\web\Session;

$session = Yii::$app->session;
$session->open();

$this->title = 'Iniciar Sesión';

//$this->params['breadcrumbs'][] = $this->title;

if (isset($session['facebook']) && $session['facebook']) {
?>
    <div class="alert alert-success">
        Felicitaciones, has iniciado sesión con facebook correctamente.
    </div>
<?php
}elseif(isset($session['facebook']) && !$session['facebook']){
    //  LA CUENTA EN FACEBOOK NO ESTA ASOCIADA AL INICIO DE SESION
?>
    <div class="alert alert-danger">
        Lo sentimos, tu cuenta de Facebook no esta asociada al inicio de sesión.<br>
        Por favor accede a tu cuenta y vincula tu ingreso con Facebook.<br>
    </div>
<?php
}
?>
<div class="row">
    <div class="col-xs-12 col-md-6" style="margin: auto;text-align: center;float: none;">
        
        <h1 class="gotham-medium"><?php echo $this->title;?></h1>
        
        <?= Html::img('@web/images/logo.png', ['alt' => 'LogoSixToGo','width' => '199px', 'height' => '150px']) ?>


        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label("Correo electrónico") ?>

            <?= $form->field($model, 'password')->passwordInput()->label("Contraseña") ?>

            <?= $form->field($model, 'rememberMe')->checkbox([
                'template' => "<div class=\"col-lg-12\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
            ])->label("Recordarme al volver") ?>

            <div class="form-group">
                <div class="col-lg-12">
                    <?= Html::submitButton('<i class="fa fa-sign-in-alt"></i> Iniciar sesión', ['class' => 'btn btn-primary btn-login gotham-medium', 'name' => 'login-button']) ?>
                </div>
                <div class="col-12">
                    <?= yii\authclient\widgets\AuthChoice::widget([
                        'baseAuthUrl' => ['site/auth'],
                        'popupMode' => false
                ]) ?>  
                </div>
            </div>

        <?php ActiveForm::end(); ?>

        <div class="col-12" style="float: left;width: 100%;padding-top: 10px;">
            <p class="gotham-medium">No tienes una cuenta?, <a href="register">Regístrate</a></p>
            <p class="gotham-medium">Has olvidado tu contraseña?, <a href="../account/index">Recuperar Contraseña</a></p>
        </div>

    </div>
</div>
<?php
$this->registerCssFile("@web/css/account.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
], 'account');
