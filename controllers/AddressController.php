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
        $modelAddress->isNewRecord = true;
        if (isset($session['login']) && $session['login'] === true) {

            $userAddress = $session['user']['userAddress'];
            foreach ($session['user']['userAddress'] as $key => $value) {
                if ($value->name == 'Casa' || $value->name == 'Oficina' || $value->name == 'Novi@') {
                    unset($userAddress[$key]);
                    $userAddress[$value->name] = $value;
                }
            }
            $session['user']['userAddress'] = $userAddress;

            $view = 'modal-with-login';
            $models = [
                'modelAddress' => $modelAddress,
                'userAddress' => $session['user']['userAddress']
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

        $session = Yii::$app->session;
        $session->open();
//        $modelAddress->load(Yii::$app->request->post());
//        VarDumper::dump($modelAddress, 10, true);
//        die();
        if (isset($session['login']) && $session['login'] === true) {

            if ($modelAddress->load(Yii::$app->request->post()) &&
                $modelAddress->validate() &&
                $save = $modelAddress->save($session['user']->rid)) {

                $session['user']['userAddress'] = json_decode($save);
                $session['address'] = $modelAddress;
            }
        } else {
            $session['address'] = $modelAddress;
        }

//        VarDumper::dump($session['address'], 10, true);
//        VarDumper::dump($modelAddress->validate(), 10, true);
//        VarDumper::dump($modelAddress, 10, true);
//        die();

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

}
