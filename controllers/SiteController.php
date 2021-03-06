<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\web\Session;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\RegisterForm;
use app\models\Address;
use yii\helpers\VarDumper;

class SiteController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'auth' => [ 
                'class' => 'yii\authclient\AuthAction', 
                'successCallback' => [$this, 'oAuthSuccess'],
            ],
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new Address();

        $session = Yii::$app->session;
        $session->open();

//        $session->destroy();

        $modalRender['render'] = false;
        if (!isset($session['address']) || empty($session['address'])) {
            $modalRender['render'] = true;
        }

        $modalRender['modal'] = Yii::$app->runAction('address/modal');

        return $this->render('index', [
                'model' => $model,
                'modalRender' => $modalRender,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post())) {

            $response = $model->login();

            if ($response === true) {
                $this->redirect(['site/index']);
            }else{
                $this->redirect(['site/login']);
            }
        } else {
            $model->password = '';
            return $this->render('login', ['model' => $model,]);
        }
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        $session = Yii::$app->session;
        $session->open();
        $session->destroy();

        $this->redirect(['site/index']);
    }


    /*
        Register action
    */
    public function actionRegister()
    {
        $model = new RegisterForm;

        if ($model->load(Yii::$app->request->post())) {
            
            $insert = $model->registerUser();

            if (is_a($insert, 'PhpOrient\Exceptions\PhpOrientException')) {
                // HA OCURRIDO UN ERROR AL MOMENTO DE EJECUTAR LA CONSULTA
                $response = array("status" => "error", "message" => "No se pudo realizar el registro.");
            }else{
                // SE HA REGISTRADO EL USUARIO EXITOSAMENTE
                $response = array("status" => "success", "message" => "Se ha realizado el registro correctamente");
            }

            return $this->render('register-response',['response' => $response]);
        }
        else{

           
            $modalTerms     = Yii::$app->runAction('site/terms');
            $modalPolicy    = Yii::$app->runAction('site/privacy');

            return $this->render('register', [
                'model'         => $model,
                'modalTerms'    => $modalTerms,
                'modalPolicy'   => $modalPolicy
            ]);
        
        }
    }

    public function actionTerms()
    {
        return $this->renderPartial('terms');
    }

    public function actionPrivacy()
    {
        return $this->renderPartial('privacy');
    }

    public function oAuthSuccess($client) {

        $facebook = new LoginForm;

        $userAttributes = $client->getUserAttributes(); 
        
        $login = $facebook->loginFacebook($userAttributes);

        if ($login) {
            $render = ['site/index'];
        }else{
            $render = ['site/login'];
        }

        return $this->redirect($render);
    }

    
}
