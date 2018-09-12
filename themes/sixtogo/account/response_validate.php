<?php
use yii\helpers\Html;

$this->title = 'Email';

?>

<div class="row">
    <div class="col-xs-12 col-md-6" style="margin: auto;float: none;">  
        <h3><?= Html::encode($this->title) ?></h3>

        <p>Tu <b>Correo electrónico</b> <?php echo $email;?></p>
        <p><b>Existe?</b> <?php echo ($userExists)?"Si":"No";?></p>

        <div class="row">

            <div class="col-lg-12">
                

            </div>
        </div>

    </div>
</div>