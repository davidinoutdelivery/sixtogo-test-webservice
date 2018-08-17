<?php

namespace app\models;

use PhpOrient\PhpOrient;
use PhpOrient\Protocols\Binary\Data\Record;
use PhpOrient\Protocols\Binary\Data\ID;

/**
 * ImageSearch represents the model behind the search form about `app\models\Image`.
 */
class OrientDb {

    /**
     * @inheritdoc
     */
    public static function connection() {
        $client = new PhpOrient();
        $client->configure(array(
            'hostname' => \Yii::$app->params['orientDb']['hostname'],
            'port' => \Yii::$app->params['orientDb']['port'],
        ));
        $client->dbOpen(
                \Yii::$app->params['orientDb']['dbname'], 
                \Yii::$app->params['orientDb']['username'], 
                \Yii::$app->params['orientDb']['password']
        );
        return $client;
    }

}
