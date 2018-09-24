<?php
	namespace app\models;

	use Yii;
	use yii\base\Model;
	use yii\web\Session;
	use app\models\OrientDb;

	class Profile extends Model
	{
		public $rid;
		public $name;
		public $lastname;
		public $email;
		public $phone;
		public $password;
		public $passwordRepeat;

		public function rules()
		{
			return [
				[['name','lastname','email'],'required'],
				[['rid','name','lastname','phone','password','passwordRepeat'], 'string'],
				[['email'], 'email'],
				['passwordRepeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Las contraseñas no coinciden.'],
			];
		}

		public function updateUser()
		{
			$client = OrientDb::connection();

			$updateSql = "UPDATE User SET fullName = '" . $this->name . ' ' . $this->lastname . "', nameFirst = '" . $this->name . "', nameLast = '" . $this->lastname . "',phone = '" . $this->phone ."'";

			if ($this->password != '') {
				// 	AGREGAMOS LA ACTUALIZACION DE LA CONTRASEÑA
				$updateSql .= ",password = '" . $this->password ."'";
			}

			$updateSql .= " WHERE @rid = '" . $this->rid ."'";

			$update = $client->command($updateSql);
			$dataUpdate = $update->getOData();

			if ($dataUpdate['result'] == 1) {
				
				// 	SE HA ACTUALIZADO EL REGISTRO DEL USUARIO CORRECTAMENTE
				// 	ACTUALIZAMOS LA INFORMACION DE LA VARIABLE DE SESION DE USUARIO

				$session = Yii::$app->session;
            	$session->open();

            	$session['user']->nameFirst	= $this->name;
				$session['user']->nameLast 	= $this->lastname;
				$session['user']->phone 	= $this->phone;

				$response = true;

			}else{
				
				// 	NO SE HA PODIDO ACTUALIZAR EL REGISTRO DE USUARIO

				$response = false;

			}

			return $response;
			
			
		}

		public function attachSocialAccount($userAttributes,$token,$rid)
		{
			//	ADJUNTAR CUENTA DE FACEBOOK AL INICIO DE SESION
			// 	{"type":"facebook","id":"2552154545","token":"sfjkj4943hjfhhe343fd33"}
			$client = OrientDb::connection();

			$authData = json_encode(["type"=>"facebook","id"=>$userAttributes['id']]);

			$updateAuth = "UPDATE User SET authData = " . $authData . " WHERE @rid = '" . $rid . "'";

			$update = $client->command($updateAuth);
			$dataUpdate = $update->getOData();

			return $dataUpdate;
		}
		
	}