<?php
	namespace app\controllers;

	use Yii;
	use yii\web\Controller;
	use yii\web\Response;
	use app\models\Account;
	use app\models\Recovery;

	class AccountController extends Controller
	{
		
		public function actionIndex()
		{
			$model = new Account();
							
	        if ($model->load(Yii::$app->request->post()) && $model->validate()) 
	        {
	            $email  = $model->email;

	            /*	VALIDAMOS QUE EL EMAIL INGRESADO ESTE REGISTRADO EN LA BASE DE DATOS:
					*	HACEMOS USO DE LA FUNCION: select resetPassword({email : "email@email.com"})	
	            */
	            $response = $model->userValidate($email);

	            return $this->render('response_validate',['response' => $response]);
	        }
	        else
	        {
	        	return $this->render('index', ['model' => $model]);	
	        }
	        
		}

		public function actionRecovery()
		{
			$model = new Recovery();

			$GET = Yii::$app->request->get();
			
			// VALIDAMOS QUE ESTEN DEFINIDAS LAS VARIABLES GET (token, email) PARA EL CAMBIO DE CONTRASEÑA

			if (isset($GET['token']) && isset($GET['email'])) {
				
				if ($model->load(Yii::$app->request->post()) && $model->validate()) {

					//	OBTENEMOS LAS CONTRASEÑAS INGRESADAS DEL FORMULARIO
					$email 				= $GET['email'];
					$password  			= $model->password;
					$repeat_password  	= $model->repeat_password;

					$response = $model->passwordUpdate($email,$password);

					return $this->render('response_recovery',['response' => $response]);			

	        	}
				else{
					
					$response = $model->tokenEmailValidate($GET);

					return $this->render('recovery',['model' => $model, 'response' => $response]);
				}
			}else{
				
				return $this->render('recovery',['response' => false]);

			}
		}
	}
?>