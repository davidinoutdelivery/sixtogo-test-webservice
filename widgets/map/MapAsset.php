<?php

/**
 * -----------------------------------------------------------------------------
 * Creado Por     | David Alejandro Domínguez Rivera
 * Fecha Creación | 16/Ago/2018 16:35 
 * -----------------------------------------------------------------------------
 * Empresa        | InOutDelivery 
 * Aplicación     | webfront-yii2
 * Desarrolladores| David Alejandro Domínguez Rivera                      (DADR)
 * -----------------------------------------------------------------------------
 * Historial de modificaciones:
 * (DADR) 16/Ago/2018 16:35  - 16/Ago/2018 16:35 = Test[success]
 * -    Se creo el ThemeAsset (basado en el AppAsset), el cual se encargara de 
 *      gestionar los contenidos de los diferentes temas de la aplicación 
 *      alojados en la carpeta themes.
 */

namespace app\widgets\map;

use yii\web\AssetBundle;

/**
 * Paquete de assets para los temas de la aplicación.
 *
 * @author (DADR) 
 * @version 1.0
 */
class MapAsset extends AssetBundle {

    public $sourcePath = '@app/widgets/map';
    public $css = [
    ];
    public $js = [
        'https://maps.googleapis.com/maps/api/js?key=AIzaSyAGygNhTiCiqhrTTCeLamEB6BMswcMnx_A&v=3.34&language=es&region=CO&libraries=places',
        'js/map.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_END];
}
