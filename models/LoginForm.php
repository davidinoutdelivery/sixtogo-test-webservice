<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\curl;
use yii\web\Session;

use app\models\User;

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
        
        $request = $curl->get('http://localhost:4000/login/index?action=login&email='.$this->username.'&password='.$this->password);

        $data = json_decode($request);
        
        if ($data->status == 'success') {
            // SE HA VALIDADO CORRECTAMENTE EL USUARIO Y LA CONTRASEÑA
            $session = Yii::$app->session;
            //if ($session->isActive){
                
                $session->open();

                $session->set('nombre','Felipe Garzon');
                //$session['user'] = new \ArrayObject;
                $session['user'] = new User;

                $session['user']->rid               = $data->userData->getUser->rid;
                $session['user']->authData          = $data->userData->getUser->authData;
                $session['user']->cart              = $data->userData->getUser->cart;
                $session['user']->createdAt         = $data->userData->getUser->createdAt;
                //$session['user']->creditCards       = $data->userData->getUser->creditCards;
                $session['user']->description       = $data->userData->getUser->description;
                $session['user']->email             = $data->userData->getUser->email;
                $session['user']->emailVerified     = $data->userData->getUser->emailVerified;
                $session['user']->employmentArea    = $data->userData->getUser->employmentArea;
                $session['user']->fullName          = $data->userData->getUser->fullName;
                $session['user']->habeasData        = $data->userData->getUser->habeasData;
                $session['user']->identification    = $data->userData->getUser->identification;
                //$session['user']->name              = $data->userData->getUser->name;
                $session['user']->nameFirst         = $data->userData->getUser->nameFirst;
                $session['user']->nameLast          = $data->userData->getUser->nameLast;
                $session['user']->onesignalUser     = $data->userData->getUser->onesignalUser;
                $session['user']->password          = $this->password;
                $session['user']->phone             = $data->userData->getUser->phone;
                //$session['user']->pointSales        = $data->userData->getUser->pointSales;
                //$session['user']->roles             = $data->userData->getUser->roles;
                $session['user']->status            = $data->userData->getUser->status;
                $session['user']->tags              = $data->userData->getUser->tags;
                $session['user']->token             = $data->userData->getUser->token;
                $session['user']->updatedAt         = $data->userData->getUser->updatedAt;
                //$session['user']->userAddress       = $data->userData->getUser->userAddress;

            //}

            $response = $data->userData;

        }else{
            // HA OCURRIDO UN ERROR
            $response = $data;
        }

        return $response;
    }

    
}
