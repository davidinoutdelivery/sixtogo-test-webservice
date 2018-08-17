<?php

namespace app\models;

use Yii;
use yii\base\Model;
use PhpOrient\Protocols\Binary\Data\ID;
use PhpOrient\Protocols\Binary\Data\Record;
use \yii\helpers\VarDumper;
use yii\helpers\Json;

/**
 * This is the model class for table "Banner".
 *
 * @property string $class
 * @property string $rid
 * @property integer $version
 * @property string $image
 * @property string $imageSelect
 * @property LinkList $pointSales
 * @property integer $sortOrder
 * @property string $subtitle
 * @property string $title
 * @property string $titleUrl
 * @property string $url
 */
class Banner extends Model {

    public $isNewRecord;
    public $class;
    public $rid;
    public $version;
    public $image;
    public $action;
    public $imageSelect;
    public $pointSales;
    public $sortOrder;
    public $subtitle;
    public $title;
    public $titleUrl;
    public $url;
    public $imageObj;
    public $type;
    public $slug;
    public $urlAction;

    /**
     * @inheritdoc
     */
    public static function cluster() {
        return 13;
    }

    /**
     * @inheritdoc
     */
    public static function className() {
        return 'Banner';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['class', 'rid', 'subtitle', 'title', 'action', 'url',
            'titleUrl', 'imageSelect'], 'string'],
            [['version', 'sortOrder'], 'integer'],
            [['imageSelect'], 'required', 'on' => 'create'],
            [['image', 'imageSelect', 'pointSales', 'sortOrder', 'subtitle',
            'title', 'url', 'action', 'imageObj', 'urlAction', 'slug', 'type'], 'safe'],
            [['url'], 'url'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'class' => Yii::t('app', '@class'),
            'rid' => Yii::t('app', 'rid'),
            'version' => Yii::t('app', 'Versión'),
            'image' => Yii::t('app', 'Imagen'),
            'imageSelect' => Yii::t('app', 'Imagen'),
            'pointSales' => Yii::t('app', 'Puntos de venta'),
            'subtitle' => Yii::t('app', 'Subtítulo'),
            'title' => Yii::t('app', 'Título'),
            'titleUrl' => Yii::t('app', 'Título de la url'),
            'url' => Yii::t('app', 'Url'),
            'sortOrder' => Yii::t('app', 'Orden'),
            'urlAction' => Yii::t('app', 'Url'),
            'slug' => Yii::t('app', 'Slug'),
            'type' => Yii::t('app', 'Tipo'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function Includes($include = []) {
        if (is_array($include)) {
            $join = "";
            if (in_array('image', $include)) {
                $join .= 'image:1 ';
            }
            return trim($join);
        }
        return "";
    }

    /**
     * @param $id
     * @param array $include
     * @return Product
     * @throws \yii\base\InvalidConfigException
     */
    public function findOne($id, $include = []) {
        $client = OrientDb::connection();
        $model = new Banner();
        $model->isNewRecord = false;
        $fetchplan = $model->Includes($include);

        $dataRelations = [];
        $relations = function (Record $record) use (&$dataRelations) {
            $dataRelations[(string) $record->getRid()] = $record;
            //VarDumper::dump($record, 10, true);
        };

        $record = $client->recordLoad(new ID($id), [
                    'fetch_plan' => $fetchplan,
                    '_callback' => $relations
                ])[0];

        $row = $record->getOData();
        $row['rid'] = $record->getRid()->jsonSerialize();
        $row['version'] = $record->getVersion();

        if (isset($row['image'])) {
            $image = $dataRelations[$row['image']->jsonSerialize()];
            $row['imageObj'] = isset($image) ? $image->getOData() : [];
        } else {
            $row['imageObj'] = [];
        }

        //VarDumper::dump($row, 10, true);

        $model->setAttributes($row);
        return $model;
    }

    /**
     * add or update row
     * @return boolean
     */
    public function save() {
        try {            
            $client = OrientDb::connection();

            if ($this->imageSelect) {
                $this->image = $this->imageSelect;
            }
            
            $action = [];
            
            if($this->type){
                $action['type'] = $this->type;
            }
            
            if($this->slug){
                $action['slug'] = $this->slug;
            }
            
            if($this->urlAction){
                $action['url'] = $this->urlAction;
            }
            
            if(count($action) > 0){
               $this->action = $action;
            }

            //VarDumper::dump($action, 10, true);
            
            $recordContent = [
                'action' => $this->action,
                'subtitle' => $this->subtitle,
                'title' => $this->title,
                'image' => new ID($this->image),
                'titleUrl' => $this->titleUrl,
                'url' => $this->url,
                'sortOrder' => (int) $this->sortOrder
            ];

            //VarDumper::dump($recordContent, 10, true);
            //return false;
            //VarDumper::dump($this->imageSelect, 10, true);

            if ($this->isNewRecord) {
                $rec = ( new Record())->setOData($recordContent)->setOClass($this->className());
                $record = $client->recordCreate($rec);
                $this->rid = $record->getRid();
            } else {
                $recordContent['image'] = $this->image;
                $queryContent = "UPDATE {$this->rid} MERGE " . Json::encode($recordContent);
                //echo $queryContent;
                //return false;
                //Yii::warning($queryContent);
                $client->command($queryContent);
            }
            return true;
        } catch (ErrorException $e) {
            Yii::warning($e);
        }
    }

    /**
     * delete row
     * @return boolean
     */
    public function delete() {
        try {
            $client = OrientDb::connection();
            $delete = $client->recordDelete(new ID($this->rid));
            return true;
        } catch (ErrorException $e) {
            Yii::warning($e);
        }
    }

}
