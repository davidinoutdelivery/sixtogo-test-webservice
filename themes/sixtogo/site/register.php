<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\widgets\modal\Modal;

$this->title = 'Crear Cuenta';


//if($modalRender !== ''){

    Modal::begin([
        'header' => false,
        'closeButton' => [
            'class' => 'close pos-tr'
        ],
        'bodyOptions' => [
            'class' => 'modal-body p-0'
        ],
        'footer' => false,
        'id' => 'modalTerms',
        'size' => 'modal-lg',
        'clientOptions' => [
            'show' => false
        ],
        'toggleButtonList' => ['btnModalTerms'],
    ]);

    echo $modalTerms;

    Modal::end();


    Modal::begin([
        'header' => false,
        'closeButton' => [
            'class' => 'close pos-tr'
        ],
        'bodyOptions' => [
            'class' => 'modal-body p-0'
        ],
        'footer' => false,
        'id' => 'modalPolicy',
        'size' => 'modal-lg',
        'clientOptions' => [
            'show' => false
        ],
        'toggleButtonList' => ['btnModalPolicy'],
    ]);

    echo $modalPolicy;

    Modal::end();
//}



?>
<div class="row">
    <div class="col-xs-12 col-md-6" style="margin: auto;text-align: center;float: none;">
        
        <h1 class="gotham-medium"><?php echo $this->title;?></h1>

        <?= Html::img('@web/images/logo.png', ['alt' => 'LogoSixToGo','width' => '199px', 'height' => '150px']) ?>


        <?php $form = ActiveForm::begin(['id' => 'register-form']); ?>

            <?= $form->field($model, 'name')->textInput(['autofocus' => true])->label("Nombre") ?>

            <?= $form->field($model, 'lastname')->label("Apellido") ?>

            <?= $form->field($model, 'email')->label("Correo electrónico") ?>

            <?= $form->field($model, 'phone')->label("Teléfono") ?>

            <?= $form->field($model, 'password')->passwordInput()->label("Contraseña") ?>

            <?= $form->field($model, 'passwordRepeat')->passwordInput()->label("Confirmar Contraseña") ?>

            <?= $form->field($model, 'checkAge')->checkbox([
                'template' => "<div class=\"col-lg-12\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",'checked' => false,'required' => true])->label("Acepto que soy mayor de 18 años.") ?>

            <?= $form->field($model, 'termsAndConditions')->checkbox([
                'template' => "<div class=\"col-lg-12\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",'checked' => false,'required' => true])->label("Acepto los <a href='javascript:void(0)' id='btnModalTerms'>Términos y Condiciones</a> y <a href='javascript:void(0)' id='btnModalPolicy'>Políticas de Privacidad</a>") ?>

            <div class="form-group">
                <div class="col-lg-12">
                    <?= Html::submitButton('<i class="fa fa-user-plus"></i> Registrarse', ['class' => 'btn btn-primary btn-login gotham-medium', 'name' => 'login-button']) ?>
                </div>
            </div>

        <?php ActiveForm::end(); ?>
        
        <div class="col-12" style="float: left;width: 100%;padding-top: 10px;">
            <p class="gotham-medium">Ya tienes una cuenta?, <a href="login">Ingresa</a></p>
        </div>
    </div>
</div>
<?php
$this->registerCssFile("@web/css/account.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
], 'register');
