<?php

/**
 * -----------------------------------------------------------------------------
 * Creado Por     | David Alejandro Domínguez Rivera
 * Fecha Creación | 16/Ago/2018 14:55 
 * -----------------------------------------------------------------------------
 * Empresa        | InOutDelivery 
 * Aplicación     | webfront-yii2
 * Desarrolladores| David Alejandro Domínguez Rivera                      (DADR)
 * -----------------------------------------------------------------------------
 * Historial de modificaciones:
 * (DADR) 16/Ago/2018 14:55  - 16/Ago/2018 14:55 = Test[success]
 * -    Se creo el ThemeAsset (basado en el AppAsset), el cual se encargara de 
 *      gestionar los contenidos de los diferentes temas de la aplicación 
 *      alojados en la carpeta themes.
 */

namespace app\widgets\spinner;

use yii\web\AssetBundle;

/**
 * Paquete de assets para los temas de la aplicación.
 *
 * @author (DADR) 
 * @version 1.0
 */
class SpinnerAsset extends AssetBundle {

    public $sourcePath = '@app/widgets/spinner';
    public $css = [
        'css/spinner.css',
    ];
    public $js = [
    ];
    public $depends = [
    ];
}
