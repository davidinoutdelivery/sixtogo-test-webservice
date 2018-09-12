<?php
	namespace app\models;

	use Yii;
	use yii\base\Model;
	use PhpOrient\PhpOrient;
	use PhpOrient\Protocols\Binary\Data\Record;
	use PhpOrient\Protocols\Binary\Data\ID;

	class Account extends Model
	{
		public $email;
		
		public function rules()
	    {
	        return [
	            // REGLA DE EMAIL REQUERIDO
	            [['email'], 'required'],
	            // email has to be a valid email address
	            ['email', 'email'],
	        ];
	    }

	    public function userValidate($email)
	    {

	    	$client = OrientDb::connection();
	    	$exists = $client->command('SELECT COUNT(*) FROM User WHERE email = "'.$email.'"');
	    	$data = $exists->getOData();
	    	//return $data['COUNT'];
	    	if ($data['COUNT'] == 1) {
	    		$response = true;
	    	}else{
	    		$response = false;
	    	}
	    	return $response;
	    }

	}
?>