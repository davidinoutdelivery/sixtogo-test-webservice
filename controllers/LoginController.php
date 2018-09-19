<?php
	namespace app\controllers;

	use Yii;
	use yii\web\Controller;
	use yii\web\Response;
	use app\models\Login;

	class LoginController extends Controller
	{
	    public function actionIndex()
	    {
	    	$model = new Login();
			$data = Yii::$app->request->get();				
	        if (isset($data) && !empty($data)) 
	        {
	        	//RECIBIMOS LOS DATOS DE LA URL PARA REALIZAR LA PETICION	        	
	        	$response = $model->requestLogin($data);
	            return $response;
	        }
	        else
	        {
	        	$response = json_encode([	"status" 	=> "error", 
	        								"message"	=> "no hay datos para consumir el servicio."]);
	        	return $response;
	        }
	    }
	}
?>