<?php

/**
 * -----------------------------------------------------------------------------
 * Creado Por     | David Alejandro Domínguez Rivera
 * Fecha Creación | 14/Ago/2018 16:30 
 * -----------------------------------------------------------------------------
 * Empresa        | InOutDelivery 
 * Aplicación     | webfront-yii2
 * Desarrolladores| David Alejandro Domínguez Rivera                      (DADR)
 * -----------------------------------------------------------------------------
 * Historial de modificaciones:
 * (DADR) 14/Ago/2018 16:30 - 14/Ago/2018 17:20 = Test[success]
 * -    Se agrego el widget de modal de yii y se configuro un registerJs para 
 *      abrir la modal automaticamente al cargar la pagina.
 * (DADR) 15/Ago/2018 10:50 - 15/Ago/2018 17:20 = Test[success]
 * -    Se agrego libreria yii2-google-maps-library para el manejo de GoogleMaps
 *      se cambio el widget de modal a uno propio llamado ModalAddress y se 
 *      implemento el mapa dentro del nuevo modal.
 * (DADR) 16/Ago/2018 09:35 - 16/Ago/2018 17:20 = No Test
 * -    Modificar los controles del mapa para que no aparescan los botones de 
 *      Map Type, Fullscreen y Street View.
 */
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use app\widgets\map\Map;
use app\widgets\modal\Modal;
use kartik\form\ActiveForm;
use bookin\aws\checkbox\AwesomeCheckbox;

//echo Spinner::widget(['width' => '150px', 'height' => '150px', 'border' => '15px']);

$this->title = 'My Yii Application';

Modal::begin([
    'header' => false,
    'closeButton' => [
        'class' => 'close pos-tr'
    ],
    'bodyOptions' => [
        'class' => 'modal-body p-0'
    ],
    'footer' => false,
    'id' => 'modalAddress',
    'size' => 'modal-lg',
    'clientOptions' => [
        'show' => $modalRender['render']
    ]
]);

echo $modalRender['modal'];

Modal::end();
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
