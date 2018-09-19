<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Iniciar Sesión';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xs-12 col-md-6" style="margin: auto;text-align: center;float: none;">
        
        
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
            </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
<?php
$this->registerCssFile("@web/css/account.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
], 'account');
