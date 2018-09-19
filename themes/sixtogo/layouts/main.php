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
        <!--FONT-AWESOME-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    </head>
    <body>
        <?php $this->beginBody() ?>

        <div class="wrap">
            <?php
            NavBar::begin([
                'brandLabel' => Html::img($themeAsset->baseUrl . '/img/header_logo.png', ['alt' => Yii::$app->name]),
                'brandOptions' => [
                    'style' => 'height: auto;'
                ],
                'brandUrl' => Yii::$app->homeUrl,
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
                                'label' => '',
                                'encode' => false
                            ]
                        ],
                    ]);
                    ?>
                </div>
                <div class="col-xs-offset-8">
                    <?php
                    echo Nav::widget([
                        'options' => ['class' => 'navbar-main-nav navbar-right'],
                        'items' => [
                            [
                                'label' => 'Home',
                                'url' => ['/site/index']
                            ],
                            ['label' => 'About', 'url' => ['/site/about']],
                            ['label' => 'Contact', 'url' => ['/site/contact']],
//                            Yii::$app->user->isGuest ? (
//                                ['label' => 'Login', 'url' => ['/site/login']]
//                                ) : (
//                                '<li>'
//                                . Html::beginForm(['/site/logout'], 'post')
//                                . Html::submitButton(
//                                    'Logout(' . Yii::$app->user->identity->username . ')', ['class' => 'btn btn-link logout']
//                                )
//                                . Html::endForm()
//                                . '</li>'
//                                )
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
