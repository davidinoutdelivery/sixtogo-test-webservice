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
$this->registerCss(".btn-send-message { 
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
    width: 100%;
    line-height: 42px;
    border-radius: 500px;
    font-family: Gotham-Medium;
}
#form-password-reset{
    text-align:center;
}");
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