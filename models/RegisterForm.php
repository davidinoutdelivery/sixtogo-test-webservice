<?php
	namespace app\models;

	use Yii;
	use yii\base\Model;
	use yii\base\Exception;
	use app\models\OrientDb;
	use PhpOrient\Exceptions\PhpOrientException;	

	class RegisterForm extends Model
	{
		public $name;
		public $lastname;
		public $email;
		public $phone;
		public $password;
		public $passwordRepeat;
		public $checkAge;
		public $termsAndConditions;

		public function rules()
		{
			return [
				[['name','lastname','email','password','passwordRepeat','checkAge','termsAndConditions'],'required'],
				[['phone'], 'string'],
				[['email'], 'email'],
				['passwordRepeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Las contraseñas no coinciden.'],
				[['checkAge', 'termsAndConditions'], 'boolean'],

			];
		}

		//	REGISTRAR USUARIO EN EL SISTEMA
		public function registerUser()
		{
			try{
				
				$client = OrientDb::connection();
				$insert = $client->command('SELECT createUser({username: "' . $this->email . '", email : "' . $this->email . '", password: "' . $this->password . '", nameFirst:"' . $this->name . '", nameLast: "' . $this->lastname . '", authData : null, phone: "' . $this->phone . '"})');
				$response = $insert->getOData();
				return $response;

			}catch(PhpOrientException $e){
				
				return $e;

			}
		}

		// 	VALIDACION DE LISTA BLANCA PARA PAGINAS DE DOCUMENTACION
		public function validateDoc($document)
		{
			if ($document == 'terms_and_conditions' ||
				$document == 'privacy_policy') {
				
				$render = $document;

			}else{

				$render = "no_document";

			}

			return $render;
		}
		
	}
?>