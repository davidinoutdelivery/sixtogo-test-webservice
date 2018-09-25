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
            $session['user']->rid            = $data->userData->getUser->rid;
            $session['user']->authData       = $data->userData->getUser->authData;
            $session['user']->cart           = $data->userData->getUser->cart;
            $session['user']->createdAt      = $data->userData->getUser->createdAt;
            $session['user']->description    = $data->userData->getUser->description;
            $session['user']->email          = $data->userData->getUser->email;
            $session['user']->emailVerified  = $data->userData->getUser->emailVerified;
            $session['user']->employmentArea = $data->userData->getUser->employmentArea;
            $session['user']->fullName       = $data->userData->getUser->fullName;
            $session['user']->habeasData     = $data->userData->getUser->habeasData;
            $session['user']->identification = $data->userData->getUser->identification;
            $session['user']->nameFirst      = $data->userData->getUser->nameFirst;
            $session['user']->nameLast       = $data->userData->getUser->nameLast;
            $session['user']->onesignalUser  = $data->userData->getUser->onesignalUser;
            $session['user']->phone          = $data->userData->getUser->phone;
            $session['user']->status         = $data->userData->getUser->status;
            $session['user']->tags           = $data->userData->getUser->tags;
            $session['user']->token          = $data->userData->getUser->token;
            $session['user']->updatedAt      = $data->userData->getUser->updatedAt;
            $session['user']->userAddress    = $data->userData->getUser->address;

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
        
        $userData = $validate->getOData();

        $encode   = json_encode($userData);

        if (!empty($userData)) {
            //  SE HAN OBTENIDO LOS DATOS DEL USUARIO CORRECTAMENTE
            $decode = json_decode($encode);

            $session['login'] = true;

            $session['user'] = new User;
            $session['user']->rid            = $decode->getUser->rid;
            $session['user']->authData       = $decode->getUser->authData;
            $session['user']->cart           = $decode->getUser->cart;
            $session['user']->createdAt      = $decode->getUser->createdAt;
            $session['user']->description    = $decode->getUser->description;
            $session['user']->email          = $decode->getUser->email;
            $session['user']->emailVerified  = $decode->getUser->emailVerified;
            $session['user']->employmentArea = $decode->getUser->employmentArea;
            $session['user']->fullName       = $decode->getUser->fullName;
            $session['user']->habeasData     = $decode->getUser->habeasData;
            $session['user']->identification = $decode->getUser->identification;
            $session['user']->nameFirst      = $decode->getUser->nameFirst;
            $session['user']->nameLast       = $decode->getUser->nameLast;
            $session['user']->onesignalUser  = $decode->getUser->onesignalUser;
            $session['user']->phone          = $decode->getUser->phone;
            $session['user']->status         = $decode->getUser->status;
            $session['user']->tags           = $decode->getUser->tags;
            $session['user']->token          = $decode->getUser->token;
            $session['user']->updatedAt      = $decode->getUser->updatedAt;
            $session['user']->userAddress    = $decode->getUser->address;

            $response = true;

        }else{
            //  LA CUENTA EN FACEBOOK NO ESTA ASOCIADA AL INICIO DE SESION CON FACEBOOK
            $response = false;
        }

        $session['facebook'] = $response;
        return $response;
    }
}
