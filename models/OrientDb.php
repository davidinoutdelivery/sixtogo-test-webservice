<?php

namespace app\models;
use Yii;
use yii\helpers\VarDumper;
use PhpOrient\PhpOrient;
use PhpOrient\Protocols\Binary\Data\Record;
use PhpOrient\Protocols\Binary\Data\ID;
use PhpOrient\Exceptions\PhpOrientException;

/**
 * ImageSearch represents the model behind the search form about `app\models\Image`.
 */
class OrientDb {

    /**
     * @inheritdoc
     */
    public static function connection($username = null, $password = null) {

        try {
        
            $client = new PhpOrient();
            $client->configure(array(
                'hostname' => Yii::$app->params['orientDb']['hostname'],
                'port' => Yii::$app->params['orientDb']['port'],
            ));
            $client->dbOpen(
                    Yii::$app->params['orientDb']['dbname'], 
                    ($username !== null) ? $username : Yii::$app->params['orientDb']['username'], 
                    ($password !== null) ? $password : Yii::$app->params['orientDb']['password']
            );
            $resp = $client;

        } catch (PhpOrientException $e) {
            $resp = $e;
        }

        return $resp;
    }

}
