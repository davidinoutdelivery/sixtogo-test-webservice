<?php
/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use kartik\widgets\Typeahead;
use app\assets\ThemeAsset;

$themeAsset = ThemeAsset::register($this);
$asset = new ThemeAsset();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>

        <div class="wrap">
            <?php
            NavBar::begin([
                'brandLabel' => Html::beginTag('div', [
                    'class' => 'row'
                ]) .
                Html::beginTag('a', [
                    'href' => '/'
                ]) .
                Html::img($themeAsset->baseUrl . '/img/header_logo.png', [
                    'alt' => Yii::$app->name
                ]) .
                Html::endTag('a') .
                Html::beginTag('a', [
                    'href' => '/'
                ]) .
                Html::tag('span', '', [
                    'class' => 'glyphicon glyphicon-map-marker',
                    'aria-hidden' => true
                ]) .
                Html::endTag('a') .
                Html::endTag('div'),
                'brandOptions' => [
                    'style' => 'height: auto; padding: 5px 15px;'
                ],
                'brandUrl' => 'javascript:void(0)',
                'options' => [
                    'class' => 'navbar-main navbar-fixed-top',
                ],
                'containerOptions' => [
                    'class' => 'hola mundo'
                ]
            ]);
            ?>
            <div class="row m-0">
                <div class="col-xs-offset-8">
                    <?php
                    echo Nav::widget([
                        'options' => ['class' => 'navbar-main-nav navbar-right'],
                        'items' => [
                            [
                                'label' => Html::tag('span', '', [
                                    'class' => 'glyphicon glyphicon-map-marker',
                                    'aria-hidden' => true
                                ]),
                                'encode' => false
                            ]
                        ],
                    ]);
                    ?>
                </div>
                <div class="col-xs-offset-8">
                    <?php
                    $session = Yii::$app->session;
                    $session->open();

                    echo Nav::widget([
                        'options' => ['class' => 'navbar-main-nav navbar-right'],
                        'items' => [
                            [
                                'label' => 'Home',
                                'url' => ['site/index']
                            ],
                            ['label' => 'About', 'url' => ['/site/about']],
                            ['label' => 'Contact', 'url' => ['/site/contact']],
                            (isset($session['login']) && $session['login'] === true) ? [
                                'label' => '<span class="glyphicon glyphicon-off" aria-hidden="true"></span>',
                                'url' => ['site/logout'],
                                'encode' => false
                                ] : [
                                'label' => 'Login',
                                'url' => ['site/login']
                                ]
                        ],
                    ]);
                    ?>
                </div>
            </div>
            <?php
            NavBar::end();
            ?>

            <div class="container">
                <?=
                Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ])
                ?>
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </div>

        <footer class="footer">
            <div class="container">
                <p class="pull-left">&copy; My Company <?= date('Y       ') ?></p>

                <p class="pull-right"><?= Yii::powered() ?></p>
            </div>
        </footer>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
