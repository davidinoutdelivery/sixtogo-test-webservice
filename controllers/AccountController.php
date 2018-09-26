<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\web\Session;

use app\models\Account;
use app\models\Recovery;
use app\models\Profile;
use app\models\Orders;

class AccountController extends Controller {

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
        ];
    }

    public function actionIndex() {
        $model = new Account();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $email = $model->email;

            /* 	VALIDAMOS QUE EL EMAIL INGRESADO ESTE REGISTRADO EN LA BASE DE DATOS:
             * 	HACEMOS USO DE LA FUNCION: select resetPassword({email : "email@email.com"})	
             */
            $response = $model->userValidate($email);

            return $this->render('response_validate', ['response' => $response]);
        } else {
            return $this->render('index', ['model' => $model]);
        }
    }

    public function actionRecovery() {
        $model = new Recovery();

        $GET = Yii::$app->request->get();

        // VALIDAMOS QUE ESTEN DEFINIDAS LAS VARIABLES GET (token, email) PARA EL CAMBIO DE CONTRASEÑA

        if (isset($GET['token']) && isset($GET['email'])) {

            if ($model->load(Yii::$app->request->post()) && $model->validate()) {

                //	OBTENEMOS LAS CONTRASEÑAS INGRESADAS DEL FORMULARIO
                $email = $GET['email'];
                $password = $model->password;
                $repeat_password = $model->repeat_password;

                $response = $model->passwordUpdate($email, $password);

                return $this->render('response_recovery', ['response' => $response]);
            } else {

                $response = $model->tokenEmailValidate($GET);

                return $this->render('recovery', ['model' => $model, 'response' => $response]);
            }
        } else {

            return $this->render('recovery', ['response' => false]);
        }
    }

    public function actionProfile() {
        
        $model = new Profile;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            //  GESTIONAMOS LA ACTUALIZACION DE LA INFORMACION BASICA DEL USUARIO EN SESION
            $response = $model->updateUser();
            
            if ($response) {
                $render = ['site/index'];
            }else{
                $render = ['account/profile'];
            }

            //return $this->render('response_profile',['response' => $render]);
            return $this->redirect($render);

        }else{

            $session = Yii::$app->session;
            $session->open();

            if (isset($session['user']) && $session['login']) {
                //  DIRECCIONAMOS A LA SECCION DEL PERFIL DE USUARIO
                return $this->render('profile',['model'=> $model,
                                                'user' => $session['user']]);
            }else{
                //  EL USUARIO NO HA INICIADO SESION
                return $this->redirect(['site/login']);
            }
             
        }        

    }

    public function oAuthSuccess($client)
    {
        $profile = new Profile;

        $session = Yii::$app->session;
        $session->open();

        $userAttributes = $client->getUserAttributes(); 
        $token = $client->getAccessToken();
        $rid = $session['user']->rid;

        $response = $profile->attachSocialAccount($userAttributes,$token,$rid);

        $session['response_facebook'] = $response;        

        /*$session['response_facebook'] = array(  'userAttributes' => $userAttributes,
                                                'token'          => $token,
                                                'rid'            => $rid);*/

        return $this->redirect(['account/profile']);
    }

    public function actionOrders()
    {
        $model = new Orders;

        $session = Yii::$app->session;
        $session->open();

        //  EVALUAMOS QUE SI EL USUARIO HA INICIADO SESION
        if (isset($session['user']) && $session['login']) {

            //  LISTA DE ESTADOS DE ORDENES
            $states = $model->stateList();

            if (Yii::$app->request->get()) {

                //  GUARDAMOS LAS VARIABLES CAPTURADAS DE LA URL
                $get = Yii::$app->request->get();
                
                //  CONSULTAMOS LAS ORDENES DEL USUARIO USUANDO EL FILTRO
                $orders  = $model->orderList($session['user']->rid,$get);

                //  DIRECCIONAMOS A LA SECCION DE ORDENES DE USUARIO
                return $this->render('orders',[ 'states'  => $states,
                                                'orders'  => $orders,
                                                'get'     => $get]);

            }else{

                $session['orders'] = new Orders;

                //  LISTA TOTAL DE ORDENES DEL USUARIO
                $orders  = $model->orderList($session['user']->rid);

                $modalDetails     = Yii::$app->runAction('account/details',['details' => $orders]);

                //  RENDERIZAMOS LA SECCION DE ORDENES DE USUARIO
                return $this->render('orders',[ 'states'   => $states,
                                                'orders'    => $orders/*,
                                                'modalDetails'    => $modalDetails*/]);    
            }
            
        }else{
            //  EL USUARIO NO HA INICIADO SESION
            return $this->redirect(['site/login']);
        }
    }

    public function actionDetails($details)
    {
        return $this->renderPartial('details',['details' => $details]);
    }

}

?>