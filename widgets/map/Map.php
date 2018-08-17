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
 * (DADR) 16/Ago/2018 16:35 - 16/Ago/2018 16:35 = No Tests
 * -    Se agrego el widget de modal de yii y se configuro un registerJs para 
 *      abrir la modal automaticamente al cargar la pagina.
 */

namespace app\widgets\map;

use yii\base\Widget;
use yii\helpers\Html;

/**
 * ModalAddress renderiza una ventana modal que se abre automaticamente al 
 * finalizar la carga de la pagina, esta modal divide el contenido en multiples
 * secciones.
 *
 * @author (DADR)
 * @version 0.01
 */
class Map extends Widget
{

    public function init() {
        parent::init();

        $view = $this->getView();
        MapAsset::register($view);
    }

    public function run() {
        ob_start();
        echo Html::tag('div', '', [ 'id' => 'map', 'style' => 'width: 100%; height: 512px;' ]);
        return ob_get_clean();
    }

}
