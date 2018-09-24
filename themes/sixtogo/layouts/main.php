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

$session = Yii::$app->session;
//$session->open();
if (isset($session['address'])) {
    $address = $session['address']->address;
//    $address = 'null';
} else {
    $address = 'Seleccionar dirección';
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <link rel="shortcut icon" href="<?= $themeAsset->baseUrl ?>/img/favicon.png" type="image/x-icon" />
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>

        <div class="wrap">
            <nav class="navbar navbar-default navbar-fixed-top">
                <div class="container">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand image" href="/">
                            <img src="<?= $themeAsset->baseUrl ?>/img/brand.png" alt="<?= Yii::$app->name ?>">
                        </a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-left">
                            <li>
                                <a id="navBarAddress" class="address" href="javascript:void(0)">
                                    <div class="row m-0">
                                        <div class="col-xs-2 navbar-brand">
                                            <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
                                        </div>
                                        <div class="col-xs-10">
                                            <div class="row">
                                                <label class="title m-0 mt-5">
                                                    Entregar en:
                                                </label>
                                                <label class="address m-0 mb-10">
                                                    <?= $address ?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <?php
                                if (isset($session['login']) && $session['login'] === true) :
                                    ?>
                                    <a href="site/logout">
                                        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                                    </a>
                                    <?php
                                else :
                                    ?>
                                    <a href="site/login">
                                        Login
                                    </a>
                                <?php
                                endif;
                                ?>
                            </li>
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </div>
            </nav>

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
