<?php

/**
 * -----------------------------------------------------------------------------
 * Creado Por     | David Alejandro Domínguez Rivera
 * Fecha Creación | 16/Ago/2018 14:20 
 * -----------------------------------------------------------------------------
 * Empresa        | InOutDelivery 
 * Aplicación     | webfront-yii2
 * Desarrolladores| David Alejandro Domínguez Rivera                      (DADR)
 * -----------------------------------------------------------------------------
 * Historial de modificaciones:
 * (DADR) 16/Ago/2018 14:20 - 16/Ago/2018 14:20 = Tests[success]
 * -    Se agrego el widget de modal de yii y se configuro un registerJs para 
 *      abrir la modal automaticamente al cargar la pagina.
 */

namespace app\widgets\spinner;

use yii\web\View;
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
class Spinner extends Widget
{

    public $width;
    public $height;
    public $border;

    public function init() {
        parent::init();

        $view = $this->getView();
        SpinnerAsset::register($view);
    }

    public function run() {
        return Html::tag('div', '', [
                    'class' => 'lds-dual-ring',
                    'style' => 'width: ' . $this->width . ';' .
                               'height: ' . $this->height . ';' .
                               'border-width: ' . $this->border . ';'
        ]);
    }

}
