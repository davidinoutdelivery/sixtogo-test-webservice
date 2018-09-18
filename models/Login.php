<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use app\models\OrientDb;
use yii\helpers\VarDumper;

class Login extends Model
{
	
	public function requestLogin($data)
	{
		try {
			//	
			$client = OrientDb::connection($data['email'],$data['password']);

			if (is_a($client,'PhpOrient\Exceptions\PhpOrientException')) 
			{
				$response = json_encode([	'status' 	=> 'error',
											'message' 	=> 'Usuario y/o contraseña invalidos.']);
			} 
			else 
			{
				# VALIDACION DE USUARIO Y CONTRASEÑA PARA EL LOGUEO
				$select 	= $client->command('SELECT getUser({"username":"' . $data['email'] . '"})');
				$userData 	= $select->getOData();

				$response 	= json_encode([	'status' 	=> 'success',
											'userData' 	=> $userData]);

			}

			return $response;

		} catch (Exception $e) {

			return $e;
			
		}
	}
}