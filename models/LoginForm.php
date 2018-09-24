<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\VarDumper;
use linslin\yii2\curl;
use yii\web\Session;
use app\models\User;
use app\models\OrientDb;
/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{

    public $username;
    public $password;
    public $rememberMe = true;

    //private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    public function login()
    {
        $curl = new curl\Curl();

        $request = $curl->get('http://localhost:4000/login/index?action=login&email=' . $this->username . '&password=' . $this->password);

        $data = json_decode($request);

        if (isset($data->status) && $data->status == 'success') {
            // SE HA VALIDADO CORRECTAMENTE EL USUARIO Y LA CONTRASEÑA
            $session = Yii::$app->session;
            $session->open();

            $session['login'] = true;
            $session['user'] = new User;
            $session['user']->rid = $data->userData->getUser->rid;
            $session['user']->authData = $data->userData->getUser->authData;
            $session['user']->cart = $data->userData->getUser->cart;
            $session['user']->createdAt = $data->userData->getUser->createdAt;
            //$session['user']->creditCards       = $data->userData->getUser->creditCards;
            $session['user']->description = $data->userData->getUser->description;
            $session['user']->email = $data->userData->getUser->email;
            $session['user']->emailVerified = $data->userData->getUser->emailVerified;
            $session['user']->employmentArea = $data->userData->getUser->employmentArea;
            $session['user']->fullName = $data->userData->getUser->fullName;
            $session['user']->habeasData = $data->userData->getUser->habeasData;
            $session['user']->identification = $data->userData->getUser->identification;
            //$session['user']->name              = $data->userData->getUser->name;
            $session['user']->nameFirst = $data->userData->getUser->nameFirst;
            $session['user']->nameLast = $data->userData->getUser->nameLast;
            $session['user']->onesignalUser = $data->userData->getUser->onesignalUser;
            $session['user']->password = $this->password;
            $session['user']->phone = $data->userData->getUser->phone;
            //$session['user']->pointSales        = $data->userData->getUser->pointSales;
            //$session['user']->roles             = $data->userData->getUser->roles;
            $session['user']->status = $data->userData->getUser->status;
            $session['user']->tags = $data->userData->getUser->tags;
            $session['user']->token = $data->userData->getUser->token;
            $session['user']->updatedAt = $data->userData->getUser->updatedAt;
            $session['user']->userAddress = $data->userData->getUser->address;

            $response = true;
        } else {
            // HA OCURRIDO UN ERROR
            $response = $data;
        }

        return $response;
    }

    public function saveResponse($userAttributes)
    {
        $session = Yii::$app->session;
        $session->open();

        $session['facebook'] = $userAttributes;
    }

    //  VALIDACION E INICIO DE SESION CON FACEBOOK
    public function loginFacebook($userAttributes)
    {   
        $session = Yii::$app->session;
        $session->open();

        $id = $userAttributes['id'];

        $client = OrientDb::connection();

        //  VALIDAMOS SI LA CUENTA DE FACEBOOK ESTA ASOCIADA AL INICIO DE SESION CON FACEBOOK DEL USUARIO
        //  SELECT getUser({authData : { id: "2552154545", type: "facebook" }})
        $validate = $client->command('SELECT getUser({authData : { id: "' . $id . '", type: "facebook" }})');
        //$validate = $client->command('SELECT getUser({authData : { id: "2552154545", type: "facebook" }})');
        $userData = $validate->getOData();

        if (!empty($userData)) {
            //  SE HAN OBTENIDO LOS DATOS DEL USUARIO CORRECTAMENTE

            $session['login'] = true;

            $session['user'] = new User;
            $session['user']->rid            = "#".$userData['getUser']['rid']->cluster.":".$userData['getUser']['rid']->position;
            $session['user']->authData       = $userData['getUser']['authData'];
            $session['user']->cart           = $userData['getUser']['cart'];
            $session['user']->createdAt      = $userData['getUser']['createdAt'];
            $session['user']->description    = $userData['getUser']['description'];
            $session['user']->email          = $userData['getUser']['email'];
            $session['user']->emailVerified  = $userData['getUser']['emailVerified'];
            $session['user']->employmentArea = $userData['getUser']['employmentArea'];
            $session['user']->fullName       = $userData['getUser']['fullName'];
            $session['user']->habeasData     = $userData['getUser']['habeasData'];
            $session['user']->identification = $userData['getUser']['identification'];
            $session['user']->nameFirst      = $userData['getUser']['nameFirst'];
            $session['user']->nameLast       = $userData['getUser']['nameLast'];
            $session['user']->onesignalUser  = $userData['getUser']['onesignalUser'];
            $session['user']->phone          = $userData['getUser']['phone'];
            $session['user']->status         = $userData['getUser']['status'];
            $session['user']->tags           = $userData['getUser']['tags'];
            $session['user']->token          = $userData['getUser']['token'];
            $session['user']->updatedAt      = $userData['getUser']['updatedAt'];
            $session['user']->userAddress    = $userData['getUser']['address'];

            $response = true;

        }else{
            //  LA CUENTA EN FACEBOOK NO ESTA ASOCIADA AL INICIO DE SESION CON FACEBOOK
            $response = false;
        }

        $session['facebook'] = $response;
        return $response;
    }
}
