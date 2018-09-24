<?php

namespace app\models;

use Yii;
use yii\base\Model;
use PhpOrient\Protocols\Binary\Data\ID;
use PhpOrient\Protocols\Binary\Data\Record;
use PhpOrient\Exceptions\PhpOrientException;
use yii\helpers\VarDumper;

/**
 * ContactForm is the model behind the contact form.
 */
class Address extends Model
{

    public $isNewRecord;
    public $class;
    public $rid;
    public $version;
    public $address;
    public $city;
    public $country;
    public $default;
    public $description;
    public $name;
    public $status;
    public $location;
    public $checkCoverage;
    public $offCoverage;
    public $saved;
    public $type;
    public $updatedAt;
    public $createdAt;

    function __construct()
    {
        parent::__construct();
        $this->class = $this->className();
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['address', 'city', 'country', 'location'], 'required'],
            [['address', 'description', 'name', 'city', 'country', 'saved'], 'safe'],
            [['address', 'city', 'country'], 'string'],
            [['name'], 'validateName', 'skipOnEmpty' => false]
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'isNewRecord' => 'Guardar Dirección',
            'address' => 'Escribe tu dirección',
            'description' => 'Datos complementarios',
            'saved' => 'Guardar Dirección'
        ];
    }

    /**
     * @inheritdoc
     */
    public static function className()
    {
        return 'userAddress';
    }

    /**
     * add or update row
     * @return boolean
     */
    public function save($userRid)
    {
        try {
            $client = OrientDb::connection();

            $recordContent = [
                'address' => $this->address,
                'city' => $this->city,
                'country' => $this->country,
                'defaultAddress' => false,
                'description' => $this->description,
                'name' => (empty($this->name) || is_null($this->name)) ? 'unnamed' : $this->name,
                'status' => true,
                'location' => json_decode($this->location),
                'checkCoverage' => true,
                'saved' => $this->saved,
                'user' => $userRid
            ];

            if ($this->isNewRecord) {

                $jsonEncode = json_encode($recordContent, JSON_UNESCAPED_UNICODE);

                $sql = "SELECT createAddress({$jsonEncode});";

                Yii::beginProfile($sql, 'yii\db\Command::query');
                $data = $client->command($sql);
                Yii::endProfile($sql, 'yii\db\Command::query');

                $result = $data->getOData();

                $return = false;
                if ($result['createAddress']) {
                    $return = json_encode($result['createAddress']);
                }
            } else {

                echo 'error';
                die();

//                if ($this->password != "") {
//                    $recordContent['password'] = md5($this->password);
//                }
//                if (is_array($this->pointSales)) {
//                    $recordContent['pointSales'] = $this->pointSales;
//                }
//                if (is_array($this->typeServices)) {
//                    $recordContent['typeServices'] = $this->typeServices;
//                }
//                unset($recordContent['createdAt']);
//                $recordContent['updatedAt'] = date('Y-m-d H:i:s');
//                $queryContent = "UPDATE {$this->rid} MERGE " . Json::encode($recordContent);
//                //echo $queryContent;
//                //return false;
//                //Yii::warning($queryContent);
//                $client->command($queryContent);
//
//                if (is_array($this->pointSales)) {
//                    $removeDrivers = "UPDATE PointSale remove drivers = {$this->rid}";
//                    Yii::beginProfile($removeDrivers, 'yii\db\Command::query');
//                    $client->command($removeDrivers);
//                    Yii::endProfile($removeDrivers, 'yii\db\Command::query');
//
//                    $insertDrivers = "UPDATE [" . implode(',', $this->pointSales) . "] add drivers = {$this->rid}";
//                    Yii::beginProfile($insertDrivers, 'yii\db\Command::query');
//                    $client->command($insertDrivers);
//                    Yii::endProfile($insertDrivers, 'yii\db\Command::query');
//                }
            }

            return $return;
        } catch (ErrorException $e) {
            Yii::warning($e);
        }
    }

    /**
     * @param string $attribute the attribute currently being validated
     * @param mixed $params the value of the "params" given in the rule
     * @param \yii\validators\InlineValidator $validator related InlineValidator instance.
     * This parameter is available since version 2.0.11.
     */
    public function validateName($attribute, $params, $validator)
    {
        if ($this->saved == 1 && empty($this->$attribute)) {

            $validator->addError($this, $attribute, 'Debe elegir un nombre para guardar la dirección.');
        }
    }

}
