<?php

/**
 * -----------------------------------------------------------------------------
 * Creado Por     | David Alejandro Domínguez Rivera
 * Fecha Creación | 17/Sep/2018 14:00 
 * -----------------------------------------------------------------------------
 * Empresa        | InOutDelivery 
 * Aplicación     | webfront-yii2
 * Desarrolladores| David Alejandro Domínguez Rivera                      (DADR)
 * -----------------------------------------------------------------------------
 * Historial de modificaciones:
 * (DADR) 17/Sep/2018 14:00 - 17/Sep/2018 14:00 = No Test
 * -    Se agrego el widget de modal de yii y se configuro un registerJs para 
 *      abrir la modal automaticamente al cargar la pagina.
 */
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use app\widgets\map\Map;
use app\widgets\modal\Modal;
use kartik\form\ActiveForm;
use bookin\aws\checkbox\AwesomeCheckbox;
?>
<div class="row m-0">
    <div class="col-sm-5 py-15">
        <h3 class="m-0 gotham-medium">Bienvenido a Six To Go</h3>
        <h5 class="gotham-medium">Por favor escribe tu dirección para validar cobertura</h5>
        <?php
        $form = ActiveForm::begin([
                    'id' => 'addressForm',
                    'type' => ActiveForm::TYPE_VERTICAL
        ]);
        ?>
        <div class="row px-15">
            <div class="col-sm-12 p-0">
                <?php
                echo $form->field($model, 'address')
                        ->textInput(['maxlength' => 255, 'id' => 'addressGeocode', 'class' => 'addressForm']);
                ?>
            </div>
        </div>
        <div class="row px-15">
            <div class="col-sm-12 p-0">
                <?php
                echo $form->field($model, 'description')
                        ->textInput(['maxlength' => 255, 'id' => 'latlngGeocode', 'class' => 'addressForm']);
                ?>
            </div>
        </div>
        <?php
        echo Html::submitButton('CONTINUAR', ['class' => 'btn submit']);

        ActiveForm::end();
        ?>
        <hr class="hr-888">
        <label class="control-label">Para ver tus direcciones por favor inicia sesión</label>
        <div class="row m-0">
            <?php
            $form = ActiveForm::begin([
                        'id' => 'loginForm',
                        'type' => ActiveForm::TYPE_VERTICAL
            ]);
            ?>
            <div class="row table-row px-15">
                <div class="col-sm-8 p-0">
                    <?php
                    echo $form->field($model, 'address', [
                                'template' => '{input}{error}{hint}'
                            ])
                            ->textInput([
                                'maxlength' => 255,
                                'id' => 'addressGeocode',
                                'class' => 'addressForm',
                                'placeholder' => 'Usuario'
                    ]);

                    echo $form->field($model, 'description', [
                                'template' => '{input}{error}{hint}'
                            ])
                            ->textInput([
                                'maxlength' => 255,
                                'id' => 'latlngGeocode',
                                'class' => 'addressForm',
                                'placeholder' => 'Contraseña'
                    ]);
                    ?>
                </div>
                <div class="col-sm-4 p-0">
                    <?php
                    echo Html::submitButton('Facebook<br>Log-In', ['class' => 'btn auth-facebook-btn']);
                    ?>
                </div>
            </div>
            <?php
            echo Html::submitButton('INICIAR SESIÓN', ['class' => 'btn submit-success']);

            ActiveForm::end();
            ?>
        </div>
    </div>
    <div class="col-sm-7 p-0">
        <?= Map::widget(); ?>
    </div>
</div>