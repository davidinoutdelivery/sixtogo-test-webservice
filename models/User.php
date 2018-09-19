<?php

namespace app\models;

use yii\base\Model;

class User extends Model
{
    public $class;
    public $rid;
    public $version;

    public $authData;
    public $cart;
    public $createdAt;
    public $creditCards;
    public $description;
    public $email;
    public $emailVerified;
    public $employmentArea;
    public $fullName;
    public $habeasData;
    public $identification;
    public $name;
    public $nameFirst;
    public $nameLast;
    public $onesignalUser;
    public $password;
    public $phone;
    public $pointSales;
    public $roles;
    public $status;
    public $tags;
    public $token;
    public $updatedAt;
    public $userAddress;


    public function rules() {
        return [
            [['class', 'rid', 'name', 'identification', 'description',
            'email', 'phone', 'token', 'nameFirst', 'nameLast',
            'employmentArea', 'fullName', 'password', 'status'], 'string'],
            [['version'], 'integer'],
            [['email'], 'email'],
            [['name', 'description', 'email', 'phone', 'token',
            'employmentArea', 'fullName', 'password', 'status',
            'creditCards', 'onesignalUser', 'pointSales', 'roles', 'tags',
            'userAddress', 'identification', 'nameLast'], 'safe'],
            [['email', 'fullName'], 'required'],
            [['emailVerified', 'habeasData'], 'boolean'],
            [['createdAt', 'updatedAt'], 'date', 'format' => 'd-M-yyyy H:m:s']
        ];
    }

}
