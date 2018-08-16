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
 */
use yii\helpers\VarDumper;
use yii\web\View;
use app\widgets\ModalAddress;
use dosamigos\google\maps\Map;
use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\services\GeocodingClient;
use dosamigos\google\maps\overlays\InfoWindow;
use dosamigos\google\maps\overlays\Marker;

$this->registerJs("$('#openModalAddress').click();", View::POS_READY, 'modalOpen');

$geocodingClient = new GeocodingClient();
$teste = $geocodingClient->lookup(
        [
            'address' => 'Cl. 147 #7b-37',
            'region' => 'Bogotá'
        ]
);
$coord = new LatLng(['lat' => $teste->results[0]->geometry->location->lat, 'lng' => $teste->results[0]->geometry->location->lng]);
$map = new Map([
    'center' => $coord,
    'zoom' => 17,
    'width' => 'calc(100% + 15px)',
//    'border-radius' => '0 6px 6px 0'
        ]);

// Lets add a marker now
$marker = new Marker([
    'position' => $coord,
    'title' => 'My Home Town',
        ]);

// Provide a shared InfoWindow to the marker
$marker->attachInfoWindow(
        new InfoWindow([
    'content' => '<p>This is my super cool content</p>'
        ])
);

// Add marker to the map
$map->addOverlay($marker);

/* @var $this yii\web\View */

$this->title = 'My Yii Application';

ModalAddress::begin([
//    'closeButton' => false,
    'header' => '<h2>Modal Prueba</h2>',
//    'headerOptions' => ['class' => 'address'],
    'map' => $map->display(),
    'id' => 'modalAddress',
    'size' => 'modal-lg',
    'toggleButton' => [
        'hidden' => 'hidden',
        'id' => 'openModalAddress',
        'label' => 'click me',
    ],
]);

// Display the map -finally :)
//echo $map->display();
//VarDumper::dump($teste->results[0]->geometry->location->lat);

ModalAddress::end();
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
