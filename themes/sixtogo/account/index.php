<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\web\View;

$this->title = 'RECORDAR CONTRASEÑA';
//$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">
    <div class="col-xs-12 col-md-6" style="margin: auto;text-align: center;float: none;">  
        <h3 class="gotham-medium"><?= Html::encode($this->title) ?></h3>

        <?= Html::img('@web/images/logo.png', ['alt' => 'LogoSixToGo','width' => '199px', 'height' => '150px']) ?>

        <p class="gotham-medium">Ingresa tu <b>Correo electrónico</b> para recordar tu contraseña.</p>

        <div class="row">

            <div class="col-lg-12">
                
                <?php $form = ActiveForm::begin(['id' => 'form-password-reset']); ?>

                    <?= $form->field($model, 'email')->label('Correo electrónico') ?>

                    <div class="form-group">
                        <?= Html::submitButton('<i class="fa fa-envelope"></i> Recordar Contraseña', ['class' => 'btn-send-message gotham-medium', 'name' => 'send-button']) ?>
                    </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    </div>
</div>
<?php
$this->registerCssFile("@web/css/account.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
], 'account');