<?php

/**
 * -----------------------------------------------------------------------------
 * Creado Por     | David Alejandro Domínguez Rivera
 * Fecha Creación | 15/Ago/2018 14:30 
 * -----------------------------------------------------------------------------
 * Empresa        | InOutDelivery 
 * Aplicación     | webfront-yii2
 * Desarrolladores| David Alejandro Domínguez Rivera                      (DADR)
 * -----------------------------------------------------------------------------
 * Historial de modificaciones:
 * (DADR) 15/Ago/2018 14:30 - 15/Ago/2018 17:20 = Test[success]
 * -    Se creo el widget de ModalAddress el cual esta basado en el widget Modal
 *      de yii2-bootstrap, se partio el contenido del modal en dos secciones y 
 *      se creo la función renderMap para pintar el mapa en la sección derecha
 *      de la modal.
 */

namespace app\widgets\modal;

use Yii;
use yii\helpers\ArrayHelper;
use \yii\bootstrap\Widget;
use \yii\bootstrap\Html;

/**
 * Modal renderiza una ventana modal que se abre automaticamente al 
 * finalizar la carga de la pagina, esta modal divide el contenido en multiples
 * secciones.
 *
 * @author (DADR)
 * @version 0.01
 */
class Modal extends Widget
{

    const SIZE_LARGE = "modal-lg";
    const SIZE_SMALL = "modal-sm";
    const SIZE_DEFAULT = "";

    /**
     * @var string the header content in the modal window.
     */
    public $header;

    /**
     * @var string additional header options
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     * @since 2.0.1
     */
    public $headerOptions;

    /**
     * @var array body options
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     * @since 2.0.7
     */
    public $bodyOptions = ['class' => 'modal-body'];

    /**
     * @var string the footer content in the modal window.
     */
    public $footer;

    /**
     * @var string additional footer options
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     * @since 2.0.1
     */
    public $footerOptions;

    /**
     * @var string the map content in the modal window.
     */
    public $map;

    /**
     * @var string the modal size. Can be [[SIZE_LARGE]] or [[SIZE_SMALL]], or empty for default.
     */
    public $size;

    /**
     * @var array|false the options for rendering the close button tag.
     * The close button is displayed in the header of the modal window. Clicking
     * on the button will hide the modal window. If this is false, no close button will be rendered.
     *
     * The following special options are supported:
     *
     * - tag: string, the tag name of the button. Defaults to 'button'.
     * - label: string, the label of the button. Defaults to '&times;'.
     *
     * The rest of the options will be rendered as the HTML attributes of the button tag.
     * Please refer to the [Modal plugin help](http://getbootstrap.com/javascript/#modals)
     * for the supported HTML attributes.
     */
    public $closeButton = [];

    /**
     * @var array the options for rendering the toggle button tag.
     * The toggle button is used to toggle the visibility of the modal window.
     * If this property is false, no toggle button will be rendered.
     *
     * The following special options are supported:
     *
     * - tag: string, the tag name of the button. Defaults to 'button'.
     * - label: string, the label of the button. Defaults to 'Show'.
     *
     * The rest of the options will be rendered as the HTML attributes of the button tag.
     * Please refer to the [Modal plugin help](http://getbootstrap.com/javascript/#modals)
     * for the supported HTML attributes.
     */
    public $toggleButton = false;

    /**
     * Initializes the widget.
     */
    public function init() {
        parent::init();

        $this->initOptions();

        echo $this->renderToggleButton() . "\n";
        echo Html::beginTag('div', $this->options) . "\n";
        echo Html::beginTag('div', ['class' => 'modal-dialog ' . $this->size]) . "\n";
        echo Html::beginTag('div', [
            'class' => 'modal-content row',
            'style' => 'overflow: hidden;'
        ]) . "\n";
        echo Html::beginTag('div', ['class' => 'modal-address col-sm-5']) . "\n";
        echo $this->renderHeader() . "\n";
        echo $this->renderBodyBegin() . "\n";
    }

    /**
     * Renders the widget.
     */
    public function run() {
        echo "\n" . $this->renderBodyEnd();
        echo "\n" . $this->renderFooter();
        echo "\n" . Html::endTag('div'); // modal-address
        echo Html::beginTag('div', ['class' => 'modal-map col-sm-7']) . "\n";
        echo $this->renderMap() . "\n";
        echo "\n" . Html::endTag('div'); // modal-content
        echo "\n" . Html::endTag('div'); // modal-dialog
        echo "\n" . Html::endTag('div');

        $this->registerPlugin('modal');
    }

    /**
     * Renders the header HTML markup of the modal
     * @return string the rendering result
     */
    protected function renderHeader() {
        $button = $this->renderCloseButton();
        if ($button !== null && !$this->map) {
            $this->header = $button . "\n" . $this->header;
        }
        if ($this->header !== null) {
            Html::addCssClass($this->headerOptions, ['widget' => 'modal-header']);
            return Html::tag('div', "\n" . $this->header . "\n", $this->headerOptions);
        } else {
            return null;
        }
    }

    /**
     * Renders the opening tag of the modal body.
     * @return string the rendering result
     */
    protected function renderBodyBegin() {
        return Html::beginTag('div', $this->bodyOptions);
    }

    /**
     * Renders the closing tag of the modal body.
     * @return string the rendering result
     */
    protected function renderBodyEnd() {
        return Html::endTag('div');
    }

    /**
     * Renders the HTML markup for the footer of the modal
     * @return string the rendering result
     */
    protected function renderFooter() {
        if ($this->footer !== null) {
            Html::addCssClass($this->footerOptions, ['widget' => 'modal-footer']);
            return Html::tag('div', "\n" . $this->footer . "\n", $this->footerOptions);
        } else {
            return null;
        }
    }

    /**
     * Renderiza el mapa en la sección izquierda del modal y agrega el botón de
     * cerrar.
     * @return string con el resultado del renderizado
     */
    protected function renderMap() {
        if ($this->map !== null) {
            return $this->map;
        } else {
            return null;
        }
    }

    /**
     * Renders the toggle button.
     * @return string the rendering result
     */
    protected function renderToggleButton() {
        if (($toggleButton = $this->toggleButton) !== false) {
            $tag = ArrayHelper::remove($toggleButton, 'tag', 'button');
            $label = ArrayHelper::remove($toggleButton, 'label', 'Show');
            if ($tag === 'button' && !isset($toggleButton['type'])) {
                $toggleButton['type'] = 'button';
            }

            return Html::tag($tag, $label, $toggleButton);
        } else {
            return null;
        }
    }

    /**
     * Renders the close button.
     * @return string the rendering result
     */
    protected function renderCloseButton() {
        if (($closeButton = $this->closeButton) !== false) {
            $tag = ArrayHelper::remove($closeButton, 'tag', 'button');
            $label = ArrayHelper::remove($closeButton, 'label', '&times;');
            if ($tag === 'button' && !isset($closeButton['type'])) {
                $closeButton['type'] = 'button';
            }

            $style = 'position: fixed;' .
                    'left: 100%;' .
                    'top: -15px;' .
                    'z-index: 3;' .
                    'width: 30px;' .
                    'height: 30px;' .
                    '-moz-border-radius: 50%;' .
                    '-webkit-border-radius: 50%;' .
                    'opacity: 0.8;' .
                    'border-radius: 50%;' .
                    'background: #f00';

            if ($this->map) {
                Html::addCssStyle($closeButton, $style);
            }
            return Html::tag($tag, $label, $closeButton);
        } else {
            return null;
        }
    }

    /**
     * Initializes the widget options.
     * This method sets the default values for various options.
     */
    protected function initOptions() {
        $this->options = array_merge([
            'class' => 'fade',
            'role' => 'dialog',
            'tabindex' => -1,
                ], $this->options);
        Html::addCssClass($this->options, ['widget' => 'modal']);

        if ($this->clientOptions !== false) {
            $this->clientOptions = array_merge(['show' => false], $this->clientOptions);
        }

        if ($this->closeButton !== false) {
            $this->closeButton = array_merge([
                'data-dismiss' => 'modal',
                'aria-hidden' => 'true',
                'class' => 'close',
                    ], $this->closeButton);
        }

        if ($this->toggleButton !== false) {
            $this->toggleButton = array_merge([
                'data-toggle' => 'modal',
                    ], $this->toggleButton);
            if (!isset($this->toggleButton['data-target']) && !isset($this->toggleButton['href'])) {
                $this->toggleButton['data-target'] = '#' . $this->options['id'];
            }
        }
    }

}
