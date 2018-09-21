<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Address;
use yii\helpers\VarDumper;

class AddressController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
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

        return $this->render('index', [
                'model' => $model,
        ]);
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionModal()
    {

        $session = Yii::$app->session;
        $session->open();

//        $session->destroy();

        $modelAddress = new Address();
        if (isset($session['login']) && $session['login'] === true) {
            $view = 'modal-with-login';
            $models = [
                'modelAddress' => $modelAddress
            ];
        } else {
            $view = 'modal-without-login';
            $modelLoginForm = new LoginForm();
            $models = [
                'modelAddress' => $modelAddress,
                'modelLoginForm' => $modelLoginForm
            ];
        }

        return $this->renderPartial($view, $models);
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionSave()
    {
        $modelAddress = new Address();
        $modelAddress->isNewRecord = true;

        $session = Yii::$app->session;
        $session->open();
        if (isset($session['login']) && $session['login'] === true) {

            if ($modelAddress->load(Yii::$app->request->post()) &&
                $modelAddress->validate() &&
                $modelAddress->save()) {
                
            }
        }

        $session['address'] = $modelAddress;
        $session['location'] = json_decode($modelAddress->location, true);

        VarDumper::dump($modelAddress->load(Yii::$app->request->post()), 10, true);
        VarDumper::dump($modelAddress->validate(), 10, true);
        die();

        $this->redirect(['site/index']);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
                'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
                'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

}
