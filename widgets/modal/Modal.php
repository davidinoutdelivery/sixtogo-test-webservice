<?php
/**
 * -----------------------------------------------------------------------------
 * Creado Por     | David Alejandro Domínguez Rivera
 * Fecha Creación | 07/Sep/2018 13:00 
 * -----------------------------------------------------------------------------
 * Empresa        | InOutDelivery 
 * Aplicación     | webfront-yii2
 * Desarrolladores| David Alejandro Domínguez Rivera                      (DADR)
 * -----------------------------------------------------------------------------
 * Historial de modificaciones:
 * (DADR) 07/Sep/2018 13:00 - 07/Sep/2018 17:00 = V0.00.003[Not-Tested]
 *  - [done]Create modal widget based on yii\bootstrap\Modal.
 *  - [todo]
 */

namespace app\widgets\modal;

use Yii;
use yii\web\View;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Html;
use yii\bootstrap\Widget;
use richardfan\widget\JSRegister;

/**
 * Modal renders a modal window that can be toggled by clicking on a button.
 * 
 * Based on yii\bootstrap\Modal
 *
 * @see http://getbootstrap.com/javascript/#modals
 * @author David Alejandro Domínguez Rivera <david.a.dominguez.r@gmail.com>
 * @version 0.0
 */
class Modal extends Widget
{

    const SIZE_LARGE = "modal-lg";
    const SIZE_SMALL = "modal-sm";
    const SIZE_DEFAULT = "";

    /**
     * @var string|false the header content in the modal window. If this property 
     * is false, no header will be rendered.
     */
    public $header;

    /**
     * @var string additional header options
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes
     * are being rendered.
     * @since 2.0.1
     */
    public $headerOptions;

    /**
     * @var array body options
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes
     * are being rendered.
     * @since 2.0.7
     */
    public $bodyOptions = ['class' => 'modal-body'];

    /**
     * @var string the footer content in the modal window.
     */
    public $footer;

    /**
     * @var string additional footer options
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes
     * are being rendered.
     * @since 2.0.1
     */
    public $footerOptions;

    /**
     * @var string the modal size. Can be [[SIZE_LARGE]] or [[SIZE_SMALL]], or 
     * empty for default.
     */
    public $size;

    /**
     * @var array|false the options for rendering the close button tag.
     * The close button is displayed in the header of the modal window. Clicking
     * on the button will hide the modal window. If this is false, no close button
     * will be rendered.
     *
     * The following special options are supported:
     *
     * - tag: string, the tag name of the button. Defaults to 'button'.
     * - label: string, the label of the button. Defaults to '&times;'.
     *
     * The rest of the options will be rendered as the HTML attributes of the 
     * button tag.
     * 
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
     * @var array the id list for link the toggle action.
     * The toggle action link is used to link an element with the action of toggle 
     * the visibility of the modal window.
     * If this property is false, no toggle action will be linked.
     */
    public $toggleButtonList = false;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        $this->initOptions();

        echo $this->renderToggleButton() . "\n";
        $this->linkToggleAction();
        echo Html::beginTag('div', $this->options) . "\n";
        echo Html::beginTag('div', ['class' => 'modal-dialog ' . $this->size]) . "\n";
        echo Html::beginTag('div', ['class' => 'modal-content']) . "\n";
        echo ($this->header !== false) ? $this->renderHeader() . "\n" : '';
        echo $this->renderBodyBegin() . "\n";
        echo ($this->header === false) ? $this->renderCloseButton() . "\n" : '';
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        echo "\n" . $this->renderBodyEnd();
        echo "\n" . $this->renderFooter();
        echo "\n" . Html::endTag('div'); // modal-content
        echo "\n" . Html::endTag('div'); // modal-dialog
        echo "\n" . Html::endTag('div');

        $this->registerPlugin('modal');
    }

    /**
     * Renders the header HTML markup of the modal
     * @return string the rendering result
     */
    protected function renderHeader()
    {
        $return = null;

        if ($this->header !== false) {

            $button = $this->renderCloseButton();
            if ($button !== null) {
                $this->header = $button . "\n" . $this->header;
            }

            Html::addCssClass($this->headerOptions, ['widget' => 'modal-header']);
            $return = Html::tag('div', "\n" . $this->header . "\n", $this->headerOptions);
        }

        return $return;
    }

    /**
     * Renders the opening tag of the modal body.
     * @return string the rendering result
     */
    protected function renderBodyBegin()
    {
        return Html::beginTag('div', $this->bodyOptions);
    }

    /**
     * Renders the closing tag of the modal body.
     * @return string the rendering result
     */
    protected function renderBodyEnd()
    {
        return Html::endTag('div');
    }

    /**
     * Renders the HTML markup for the footer of the modal
     * @return string the rendering result
     */
    protected function renderFooter()
    {
        $return = null;

        if ($this->footer !== false) {
            Html::addCssClass($this->footerOptions, ['widget' => 'modal-footer']);
            $return = Html::tag('div', "\n" . $this->footer . "\n", $this->footerOptions);
        }

        return $return;
    }

    /**
     * Renders the toggle button.
     * @return string the rendering result
     */
    protected function renderToggleButton()
    {
        $return = null;

        if (($toggleButton = $this->toggleButton) !== false) {
            $tag = ArrayHelper::remove($toggleButton, 'tag', 'button');
            $label = ArrayHelper::remove($toggleButton, 'label', 'Show');
            if ($tag === 'button' && !isset($toggleButton['type'])) {
                $toggleButton['type'] = 'button';
            }

            $return = Html::tag($tag, $label, $toggleButton);
        }

        return $return;
    }

    /**
     * Renders the toggle button.
     * @return string the rendering result
     */
    protected function linkToggleAction()
    {
        if (($idList = $this->toggleButtonList) !== false && $this->id) {
            JSRegister::begin([
                'position' => View::POS_READY
            ]);
            ?>
            <script>
            <?php foreach ($idList as $id) : ?>
                    $('#<?= $id ?>').click(function () {
                        $('#<?= $this->id ?>').modal('toggle');
                    });
            <?php endforeach; ?>
            </script>
            <?php
            JSRegister::end();
        }
    }

    /**
     * Renders the close button.
     * @return string the rendering result
     */
    protected function renderCloseButton()
    {
        $return = null;

        if (($closeButton = $this->closeButton) !== false) {
            $tag = ArrayHelper::remove($closeButton, 'tag', 'button');
            $label = ArrayHelper::remove($closeButton, 'label', '&times;');
            if ($tag === 'button' && !isset($closeButton['type'])) {
                $closeButton['type'] = 'button';
            }

            $return = Html::tag($tag, $label, $closeButton);
        }

        return $return;
    }

    /**
     * Initializes the widget options.
     * This method sets the default values for various options.
     */
    protected function initOptions()
    {
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
