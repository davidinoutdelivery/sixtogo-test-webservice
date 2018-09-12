<?php
	namespace app\controllers;

	use Yii;
	use yii\web\Controller;
	use yii\web\Response;
	use app\models\Account;

	class AccountController extends Controller
	{
		
		public function actionIndex()
		{
			$model = new Account();
				
	        if ($model->load(Yii::$app->request->post()) && $model->validate()) 
	        {
	            $email  = $model->email;

	            #	VALIDAMOS QUE EL EMAIL INGRESADO ESTE REGISTRADO EN LA BASE DE DATOS

	            $userExists = $model->userValidate($email);

	            return $this->render('response_validate',[	'email' 		=> $email,
	        												'userExists' 	=> $userExists]);
	        }
	        else
	        {
	        	return $this->render('index', [
		            'model' => $model,
		        ]);	
	        }
	        
		}
	}
?>