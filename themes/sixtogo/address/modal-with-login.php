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
use kartik\form\ActiveForm;
use bookin\aws\checkbox\AwesomeCheckbox;
use richardfan\widget\JSRegister;

/**
 * @var $modelAddress app\models\Address
 */
JSRegister::begin([
    'key' => 'modal-whit-login',
    'position' => View::POS_READY
]);
?>
<script>
    $('.btn-circle-xl').click(function () {
        let name = $(this).data('name');
        $('.btn-circle-xl').removeClass('btn-circle-xl-active');
        $(this).addClass('btn-circle-xl-active');
        if (name !== 'others') {
            $('#txtName').val(name);
            $('#divName').addClass('hidden');
            $('#submitButton').removeClass('col-sm-4');
            $('#submitButton').addClass('col-sm-12');
        } else {
            $('#txtName').val('');
            $('#divName').removeClass('hidden');
            $('#submitButton').removeClass('col-sm-12');
            $('#submitButton').addClass('col-sm-4');
        }
    });
</script>
<?php
JSRegister::end();
?>
<div class="row m-0">
    <div class="col-sm-5 py-15">
        <h3 class="m-0 gotham-medium">Bienvenido a Six To Go</h3>
        <h5 class="gotham-medium">Por favor escribe tu dirección para validar cobertura</h5>
        <?php
        $form = ActiveForm::begin([
                'id' => 'addressForm',
                'type' => ActiveForm::TYPE_VERTICAL,
                'action' => ['address/save']
        ]);
        ?>
        <div class="row px-15">
            <div class="col-sm-12 p-0">
                <?php
                echo $form->field($modelAddress, 'address')
                    ->textInput([
                        'maxlength' => 255,
                        'id' => 'addressGeocode',
                        'class' => 'addressForm'
                ]);
                echo $form->field($modelAddress, 'city')
                    ->hiddenInput(['id' => 'cityGeocode'])
                    ->label(false);
                echo $form->field($modelAddress, 'country')
                    ->hiddenInput(['id' => 'countryGeocode'])
                    ->label(false);
                echo $form->field($modelAddress, 'location')
                    ->hiddenInput(['id' => 'locationGeocode'])
                    ->label(false);
                ?>
            </div>
        </div>
        <div class="row px-15">
            <div class="col-sm-8 p-0">
                <?php
                echo $form->field($modelAddress, 'description')
                    ->textInput([
                        'maxlength' => 255,
                        'id' => 'latlngGeocode',
                        'class' => 'addressForm'
                ]);
                ?>
            </div>
            <div class="col-sm-4 p-0">
                <?php
                echo $form->field($modelAddress, 'saved', [
                    'labelOptions' => ['class' => 'col-sm-8'],
                    'template' => '{label}<div class="col-sm-4">{input}{error}{hint}</div>'
                ])->widget(AwesomeCheckbox::classname(), [
                    'type' => AwesomeCheckbox::TYPE_CHECKBOX,
                    'style' => [
                        AwesomeCheckbox::STYLE_SUCCESS
                    ],
                    'options' => [
                        'label' => ' '
                    ]
                ]);
                ?>
            </div>
        </div>
        <hr class="hr-888 mt-5">
        <label class="control-label">Tus Direcciones</label>
        <div class="row m-0">
            <div class="col-sm-3 p-0">
                <button type="button" class="btn btn-circle-xl center-block" data-name="Casa">
                    <i class="glyphicon glyphicon-home"></i>
                </button>
                <label class="address-list-label">Casa</label>
            </div>
            <div class="col-sm-3 p-0">
                <button type="button" class="btn btn-circle-xl center-block" data-name="Oficina">
                    <i class="glyphicon glyphicon-briefcase"></i>
                </button>
                <label class="address-list-label">Oficina</label>
            </div>
            <div class="col-sm-3 p-0">
                <button type="button" class="btn btn-circle-xl center-block" data-name="Novi@">
                    <i class="glyphicon glyphicon-heart"></i>
                </button>
                <label class="address-list-label">Novi@</label>
            </div>
            <div class="col-sm-3 p-0">
                <button type="button" class="btn btn-circle-xl center-block" data-name="others">
                    <i class="glyphicon glyphicon-plus-sign"></i>
                </button>
                <label class="address-list-label">Otras Direcciones</label>
            </div>
            <div id="divName" class="col-sm-8 p-0 hidden">
                <?php
                echo $form->field($modelAddress, 'name')
                    ->textInput([
                        'maxlength' => 255,
                        'id' => 'txtName',
                        'class' => 'addressForm'
                    ])->label(false);
                ?>
            </div>
            <div id="submitButton" class="col-sm-12 p-0">
                <?php
                echo Html::submitButton('CONTINUAR', ['class' => 'btn submit']);

                ActiveForm::end();
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-7 p-0">
        <?= Map::widget(); ?>
    </div>
</div>