<?php

namespace app\models;

use Yii;
use yii\base\Model;

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
            [['isNewRecord', 'address', 'description', 'name', 'city', 'country'], 'safe'],
            [['address', 'city', 'country'], 'string']
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
    public function save()
    {
        try {
            $client = OrientDb::connection();

            if ($this->isNewRecord) {
                $dateCreated = date_create(date('Y-m-d H:i:s'));
            } else {
                $dateCreated = date_create(date($this->createdAt));
                $dateUpdated = date_create(date('Y-m-d H:i:s'));
            }

            if ($this->location) {
                $location = json_decode($this->location);
                $this->location = ( new Record())->setOData([
                        'coordinates' => [
                            $location['lng'], $location['lat']
                        ]
                    ])->setOClass('OPoint');
            }

            $recordContent = [
                'address' => $this->address,
                'city' => $this->city,
                'country' => $this->country,
                'default' => false,
                'description' => $this->description,
                'name' => $this->name,
                'status' => true,
                'location' => $this->location,
                'checkCoverage' => true,
                'offCoverage' => false,
                'saved' => true,
                'createdAt' => $dateCreated
            ];

            if ($this->isNewRecord) {

                $newRecord = (new Record())
                    ->setOData($recordContent)
                    ->setOClass($this->class);
                $record = $client->recordCreate($newRecord);
                $this->rid = $record->getRid();
            } else {
                if ($this->password != "") {
                    $recordContent['password'] = md5($this->password);
                }
                if (is_array($this->pointSales)) {
                    $recordContent['pointSales'] = $this->pointSales;
                }
                if (is_array($this->typeServices)) {
                    $recordContent['typeServices'] = $this->typeServices;
                }
                unset($recordContent['createdAt']);
                $recordContent['updatedAt'] = date('Y-m-d H:i:s');
                $queryContent = "UPDATE {$this->rid} MERGE " . Json::encode($recordContent);
                //echo $queryContent;
                //return false;
                //Yii::warning($queryContent);
                $client->command($queryContent);

                if (is_array($this->pointSales)) {
                    $removeDrivers = "UPDATE PointSale remove drivers = {$this->rid}";
                    Yii::beginProfile($removeDrivers, 'yii\db\Command::query');
                    $client->command($removeDrivers);
                    Yii::endProfile($removeDrivers, 'yii\db\Command::query');

                    $insertDrivers = "UPDATE [" . implode(',', $this->pointSales) . "] add drivers = {$this->rid}";
                    Yii::beginProfile($insertDrivers, 'yii\db\Command::query');
                    $client->command($insertDrivers);
                    Yii::endProfile($insertDrivers, 'yii\db\Command::query');
                }
            }

            return true;
        } catch (ErrorException $e) {
            Yii::warning($e);
        }
    }

}
