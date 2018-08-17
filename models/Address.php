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
    public $createdAt;
    public $default;
    public $description;
    public $name;
    public $status;
    public $updatedAt;
    public $location;
    public $data;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['address', 'city', 'country', 'location'], 'required'],
            [['address', 'city', 'country'], 'string']
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'address' => 'Escribe tu dirección',
            'description' => 'Datos complementarios',
            'isNewRecord' => 'Guardar Dirección'
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function contact($email)
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([$this->email => $this->name])
                ->setSubject($this->subject)
                ->setTextBody($this->body)
                ->send();

            return true;
        }
        return false;
    }
}
