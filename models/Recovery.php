<?php
	namespace app\models;

	use Yii;
	use yii\base\Model;
	use yii\db\ActiveRecord;
	use PhpOrient\PhpOrient;
	use PhpOrient\Protocols\Binary\Data\Record;
	use PhpOrient\Protocols\Binary\Data\ID;

	class Recovery extends Model
	{
		public $password;
		public $repeat_password;

		public function rules()
		{
			return [

            	[['password','repeat_password'], 'required'],
            	['repeat_password', 'compare', 'compareAttribute' => 'password', 'message' => 'Las contraseñas no coinciden.'],

			];
		}

		public function tokenEmailValidate($GET)
	    {
	    	// 	EVALUAMOS LA VALIDEZ DEL TOKEN Y EL EMAIL DE URL PARA EL CAMBIO DE CONTRASEÑA

	    	$client 	= OrientDb::connection();
	    	$validate 	= $client->command('select validateEmailToken({email : "'.$GET['email'].'", token : "'.$GET['token'].'"})');
	    	$response 	= $validate->getOData();
	    	
	    	return $response;
	    }

	    public function passwordUpdate($email,$password)
	    {
	    	// 	REALIZAMOS EL CAMBIO DE CONTRASEÑA DEL USUARIO CON LA FUNCION 
	    	// 	select changePassword({username : "freddy@gmail.com", password : "123"})

	    	$username = explode('@', $email);
	    	$name = $username[0];

	    	$client 	= OrientDb::connection();
			//$update 	= $client->command('UPDATE User SET password = "'.$password.'" WHERE name = "'.$name.'"');
			$update 	= $client->command('select changePassword({username : "'.$email.'", password : "'.$password.'"})');
			//$response 	= $update->getOData();
			$dataUpdate = $update->getOData();
			//$response = ['email' => $email, 'password' => $password, 'response' => $dataUpdate];
			$response = ['email' => $email, 'password' => $password, 'response' => $dataUpdate];

			return $response;
	    }
	}
?>