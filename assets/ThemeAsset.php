<?php

/**
 * -----------------------------------------------------------------------------
 * Creado Por     | David Alejandro Domínguez Rivera
 * Fecha Creación | 15/Ago/2018 15:40 
 * -----------------------------------------------------------------------------
 * Empresa        | InOutDelivery 
 * Aplicación     | webfront-yii2
 * Desarrolladores| David Alejandro Domínguez Rivera                      (DADR)
 * -----------------------------------------------------------------------------
 * Historial de modificaciones:
 * (DADR) 15/Ago/2018 15:40  - 15/Ago/2018 16:40 = Test[success]
 * -    Se creo el ThemeAsset (basado en el AppAsset), el cual se encargara de 
 *      gestionar los contenidos de los diferentes temas de la aplicación 
 *      alojados en la carpeta themes.
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Paquete de assets para los temas de la aplicación.
 *
 * @author (DADR) 
 * @version 1.0
 */
class ThemeAsset extends AssetBundle {

    public $sourcePath = '@app/themes/sixtogo';
    public $css = [
        'css/site.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
