<?php
	namespace app\models;

	use Yii;
	use yii\base\Model;
	use yii\db\ActiveRecord;
	use PhpOrient\PhpOrient;
	use PhpOrient\Protocols\Binary\Data\Record;
	use PhpOrient\Protocols\Binary\Data\ID;

	class Account extends Model
	{
		public $email;

		public function rules()
	    {
	        return [
	            // REGLA DE EMAIL REQUERIDO AL SOLICITAR CAMBIO DE CONTRASEÑA
	            [['email'], 'required', 'message' => 'Por favor ingrese el correo electrónico.'],
	            
	            // VALIDACION DE EMAIL VALIDO
	            ['email', 'email'],
	        ];
	    }
	    

	    public function userValidate($email)
	    {
	    	//	EVALUAMOS SI EL USUARIO (EMAIL) EXISTE EN LA BASE DE DATOS
			//	select resetPassword({email : "freddyclone@gmail.com"})
			//	PARA ENVIAR EL EMAIL Y GENERAR EL TOKEN PARA EL CAMBIO DE CONTRASEÑA
			$client = OrientDb::connection();	
			$validate = $client->command('select resetPassword({email : "'.$email.'"})');
			$dataValidate = $validate->getOData();

			$response = ['email' => $email, 'validate' => $dataValidate['resetPassword']];

			
			return $response;
	    }

	}
?>