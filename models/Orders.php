<?php
	namespace app\models;

	use Yii;
	use yii\base\Model;
	use yii\db\ActiveRecord;
	use yii\web\Session;
	use PhpOrient\PhpOrient;
	use PhpOrient\Protocols\Binary\Data\Record;
	use PhpOrient\Protocols\Binary\Data\ID;

	class Orders extends Model
	{
		public $filterStates = [];

		public function stateList()
	    {
	    	//	CONSULTAMOS LA LISTA DE ESTADOS PARA EL FILTRO DE ORDENES
	    	$client 	= OrientDb::connection();
	    	$consulta 	= $client->command('SELECT FROM State WHERE active = "true" ORDER BY sortOrder ASC');
	    	//$listado 	= $consulta->getOData();
	    	$response 	= json_encode($consulta);

	    	return $response;
	    }

	    public function orderList($rid,$get = null)
	    {
	    	//	CONSULTAMOS EL LISTADO DE ORDENES DEL USUARIO EN SESION
	    	//	select expand(getOrderByUser({user : #28:55}))
			$client 	= OrientDb::connection();
			$session 	= Yii::$app->session;
        	$session->open();

			if ($get != null) {

				if ($get['section'] == 'scheduled') {

					$sql = 'select expand(getOrderByUser({user : #28:55, onlySchedule: true}))';

				}elseif ($get['section'] == 'all') {

					if (isset($get['state'])) {
						
						$state      = "#".$get['state'];

	                    if (in_array($state, $session['orders']->filterStates)) {

	                        $index = array_search($state, $session['orders']->filterStates);
	                        unset($session['orders']->filterStates[$index]);

	                        if (empty($session['orders']->filterStates)) {
	                        	$sql = 'select expand(getOrderByUser({user : "#28:55"}))';
	                        }else{

	                        	$size = count($session['orders']->filterStates);
						
								$states = "[";
								$i = 1;
								foreach ($session['orders']->filterStates as $state) 
								{
									if ($i == $size) {
										$states .= $state;
									}else{
										$states .= $state.",";
									}
									
									$i = $i+1;
								}
								$states .= "]";

								$sql = 'select from (select expand(getOrderByUser({user : #28:55}))) where stateCurrent.@rid in '.$states;
	                        }

	                    }else{

	                        array_push($session['orders']->filterStates, $state);
	                        $size = count($session['orders']->filterStates);
						
							$states = "[";
							$i = 1;
							foreach ($session['orders']->filterStates as $state) 
							{
								if ($i == $size) {
									$states .= $state;
								}else{
									$states .= $state.",";
								}
								
								$i = $i+1;
							}
							$states .= "]";

							$sql = 'select from (select expand(getOrderByUser({user : #28:55}))) where stateCurrent.@rid in '.$states;
	                    }

					}elseif (!isset($get['state'])) {

						$sql = 'select expand(getOrderByUser({user : "#28:55"}))';
						
					}

				}

			}else{

				$sql = 'select expand(getOrderByUser({user : "#28:55"}))';

			}

			$orders = $client->command($sql);
			$response 	= json_encode($orders);

			//return $sql;
			return $response;
	    }

	}
?>