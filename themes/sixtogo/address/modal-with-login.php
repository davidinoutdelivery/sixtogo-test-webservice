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
 * @var $userAdderss Array
 */
//VarDumper::dump($userAddress,10,true);
//die();

JSRegister::begin([
    'key' => 'modal-whit-login',
    'position' => View::POS_READY
]);
?>
<script>
    $('#isSaved').change(function () {
        if ($('#isSaved').prop('checked')) {
            if ($('#otherAddress').hasClass('scroll-open')) {
                $('#otherAddress').removeClass('scroll-open');
                $('#otherAddress').addClass('scroll-close');
            } else {
                $('#otherAddress').removeClass('scroll-close');
            }
        } else {
            $('#txtName').val(name);
            $('#divName').addClass('hidden');
            $('#submitButton').removeClass('col-sm-4');
            $('#submitButton').addClass('col-sm-12');
        }
        $('.btn-circle-xl').removeClass('btn-circle-xl-active');
    });

    $('.btn-circle-xl').click(function () {
        let name = $(this).data('name');
        $('.btn-circle-xl').removeClass('btn-circle-xl-active');
        if ($('#isSaved').prop('checked')) {
            $(this).addClass('btn-circle-xl-active')
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
            $('#ridAddress').val(false);
        } else {
            if ($(this).data('rid') !== '' && $(this).data('rid') != undefined) {
                $(this).addClass('btn-circle-xl-active')
            }
            $('#txtName').val(name);
            $('#divName').addClass('hidden');
            $('#submitButton').removeClass('col-sm-4');
            $('#submitButton').addClass('col-sm-12');

            if (name !== 'others') {
                $('#ridAddress').val($(this).data('rid'));
                $('#addressGeocode').val($(this).data('address'));
                $('#descriptionAddress').val($(this).data('description'));
                ($(this).data('rid') !== '') ? $('#addressGeocode').trigger("address:change") : null;
                if ($('#otherAddress').hasClass('scroll-open')) {
                    $('#otherAddress').removeClass('scroll-open');
                    $('#otherAddress').addClass('scroll-close');
                    $('.accordion-section').css('width', "#000000");
                } else {
                    $('#otherAddress').removeClass('scroll-close');
                }
            } else {
                if ($('#otherAddress').hasClass('scroll-open')) {
                    $('#otherAddress').removeClass('scroll-open');
                    $('#otherAddress').addClass('scroll-close');
                } else {
                    $('#otherAddress').removeClass('scroll-close');
                    $('#otherAddress').addClass('scroll-open');
                }
            }
        }
    });

    $('.accordion-item').click(function () {
        $(this).find('.otherAddress').prop('checked', true);
        $('#ridAddress').val($(this).data('rid'));
        $('#addressGeocode').val($(this).data('address'));
        $('#descriptionAddress').val($(this).data('description'));
        $('#addressGeocode').trigger("address:change");

        $('#otherAddress').removeClass('scroll-open');
        $('#otherAddress').addClass('scroll-close');
    });

    var scroll = document.getElementById('otherAddress');
    scroll.addEventListener("webkitAnimationStart", function (e) {
        if (e.animationName == 'vacordion-right-slide') {
            $('.accordion-section').css('width', '280px');
        }
    });
    scroll.addEventListener("animationstart", function (e) {
        if (e.animationName == 'vacordion-right-slide') {
            $('.accordion-section').css('width', '280px');
        }
    });
    scroll.addEventListener("webkitAnimationEnd", function (e) {
        if (e.animationName == 'vacordion-left-slide') {
            $('.accordion-section').css('width', '0px');
        }
    });
    scroll.addEventListener("animationend", function (e) {
        if (e.animationName == 'vacordion-left-slide') {
            $('.accordion-section').css('width', '0px');
        }
    });
</script>
<?php
JSRegister::end();
?>
<div class="row m-0">
    <div class="col-sm-5 py-15">
        <div class="row m-0">
            <div>
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
                        echo $form->field($modelAddress, 'rid')
                            ->hiddenInput(['id' => 'ridAddress'])
                            ->label(false);
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
                                'id' => 'descriptionAddress',
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
                                'id' => 'isSaved',
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
                        <button type="button" class="btn btn-circle-xl center-block" data-name="Casa"
                                data-rid="<?= isset($userAddress['Casa']->rid) ? $userAddress['Casa']->rid : '' ?>"
                                data-address="<?= isset($userAddress['Casa']->address) ? $userAddress['Casa']->address : '' ?>"
                                data-description="<?= isset($userAddress['Casa']->description) ? $userAddress['Casa']->description : '' ?>">
                            <i class="glyphicon glyphicon-home"></i>
                        </button>
                        <label class="address-list-label">Casa</label>
                    </div>
                    <div class="col-sm-3 p-0">
                        <button type="button" class="btn btn-circle-xl center-block" data-name="Oficina"
                                data-rid="<?= isset($userAddress['Oficina']->rid) ? $userAddress['Oficina']->rid : '' ?>"
                                data-address="<?= isset($userAddress['Oficina']->address) ? $userAddress['Oficina']->address : '' ?>"
                                data-description="<?= isset($userAddress['Oficina']->description) ? $userAddress['Oficina']->description : '' ?>">
                            <i class="glyphicon glyphicon-briefcase"></i>
                        </button>
                        <label class="address-list-label">Oficina</label>
                    </div>
                    <div class="col-sm-3 p-0">
                        <button type="button" class="btn btn-circle-xl center-block" data-name="Novi@"
                                data-rid="<?= isset($userAddress['Novi@']->rid) ? $userAddress['Novi@']->rid : '' ?>"
                                data-address="<?= isset($userAddress['Novi@']->address) ? $userAddress['Novi@']->address : '' ?>"
                                data-description="<?= isset($userAddress['Novi@']->description) ? $userAddress['Novi@']->description : '' ?>">
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
            <?php if (isset($userAddress) && !empty($userAddress)) : ?>
                <div class="col-xs-12 p-0 accordion-section">
                    <div id="otherAddress" class="row m-0 scrollbar">
                        <?php
                        foreach ($userAddress as $key => $value) :
                            if ($key != 'Casa' && $key != 'Oficina' && $key != 'Novi@') :
                                ?>
                                <div class="row m-0 accordion-item"
                                     data-rid="<?= $value->rid ?>"
                                     data-address="<?= $value->address ?>"
                                     data-description="<?= $value->description ?>">
                                    <div class="col-xs-1 p-0 icon">
                                        <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
                                    </div>
                                    <div class="col-xs-9 p-0">
                                        <div class="row m-0">
                                            <label class="col-xs-12 p-0 title">
                                                <?= $value->name ?>
                                            </label>
                                            <label class="col-xs-12 p-0 address">
                                                <?= $value->address ?>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-xs-2 p-0 icon">
                                        <?php
                                        echo AwesomeCheckbox::widget([
                                            'name' => 'otherAddress',
                                            'type' => AwesomeCheckbox::TYPE_RADIO,
                                            'style' => [
                                                AwesomeCheckbox::STYLE_SUCCESS
                                            ],
                                            'options' => [
                                                'class' => 'otherAddress',
                                                'label' => ' '
                                            ]
                                        ]);
                                        ?>
                                    </div>
                                </div>
                                <?php
                            endif;
                        endforeach;
                        ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-sm-7 p-0">
        <?= Map::widget(); ?>
    </div>
</div>