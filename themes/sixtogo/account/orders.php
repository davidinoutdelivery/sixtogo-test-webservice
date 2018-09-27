<?php

use yii\helpers\Html;
use app\widgets\modal\Modal;

$session = Yii::$app->session;
$session->open();

$this->title = 'Órdenes';
$list = json_decode($states);
$ordersList = json_decode($orders);

if (!empty($ordersList)) 
{
	foreach ($ordersList as $order) 
	{
		$itemsList = $order->oData->items;

		$orderNumber = $order->oData->orderNumber;

		Modal::begin([
		    'header' => false,
		    'closeButton' => [
		        'class' => 'close pos-tr'
		    ],
		    'bodyOptions' => [
		        'class' => 'modal-body p-0'
		    ],
		    'footer' => false,
		    'id' => "order_".$orderNumber,
		    'size' => 'modal-lg',
		    'clientOptions' => [
		        'show' => false
		    ],
		    'toggleButtonList' => ['btnModalDetails_'.$orderNumber],
		]);

		//echo "<pre>";
		//print_r($itemsList);
		//echo "</pre>";
		foreach ($itemsList as $item) 
		{
			?>
				<h4><?php echo $item->product;?></h4>				
				<img src="<?php echo $item->image->url;?>" alt="<?php echo $item->product;?>" style="width:300px;height: 300px;">
			<?php
		}

		Modal::end();
	}
}



?>
<div class="row">
    <div class="col-xs-12 col-md-8" style="margin: auto;text-align: center;float: none;">
        
        <h1 class="gotham-medium"><?php echo $this->title;?></h1>
		<button class="btn btn-info" id="btnModalDetails">Ver Modal</button>
		<div style="text-align: left;padding: 10px;">

			<a href="orders?section=all" class="btn btn-primary btn-category">TODAS</a>
			<a href="orders?section=scheduled" class="btn btn-primary btn-category">PROGRAMADAS</a>
		     
		</div>
		<?php
			if (!isset($get['section']) || $get['section'] == 'all') {
				
		?>
		<div style="text-align: left;padding: 10px;">
			<?php
				foreach ($list as $state) {
					
					if (in_array($state->rid, $session['orders']->filterStates)) {
						$class = 'btn-info';
					}else{
						$class = 'btn-success';
					}

					$state_rid = str_replace('#', '', $state->rid);		
			?>
					<a href="../account/orders?section=all&state=<?php echo $state_rid;?>" class="btn <?php echo $class;?>" style="margin-top: 5px;"><?php echo $state->oData->name;?></a>
			<?php
				}
			?>
		</div>
		<?php
			}
		?>
		<div style="text-align: left;padding: 10px;">
			<?php
				if (!empty($ordersList)) 
				{
					foreach ($ordersList as $order) 
					{
						$itemsList = json_encode($order->oData->items);
						$orderNumber = $order->oData->orderNumber;
						//echo "<pre>";
						//print_r($order);
						//echo "</pre>";
						$date = new DateTime($order->oData->createdAt->date);
				?>
						<div class="order">
							<table style="width: 100%;">
								<tr>
									<td class="colLeft">
										<button class="btn btn-info"> 
											<?php echo $order->oData->stateCurrent->name;?>
										</button>
									</td>
									<td class="colRight">
										<label>FECHA Y HORA</label><br>
										<?php echo $date->format('d/m/Y H:i:s');;?>
									</td>
								</tr>
								<tr>
									<td class="colLeft">
										<label>REPARTIDOR</label><br>
										<?php echo $order->oData->driver->name;?>
									</td>
									<td class="colRight">
										<label>NÚMERO DE ORDEN</label><br>
										<?php echo $order->oData->orderNumber;?>
									</td>
								</tr>
								<tr>
									<td class="colLeft">
										<label>DIRECCIÓN</label><br>
										<?php echo $order->oData->userAddress->address;?>
									</td>
									<td class="colRight">
										<label>VALOR TOTAL</label><br>
										<?php echo "$".number_format($order->oData->total);?>
									</td>
								</tr>
								<tr>
									<td class="colLeft">
										<label>METODO DE PAGO</label><br>
										<?php echo $order->oData->paymentMethod->name;?>
									</td>
									<td class="colRight">
										<label>TIEMPO DE ENTREGA</label><br>
										<?php echo $order->oData->deliveryMinutes." MIN";?>
									</td>
								</tr>
								<tr>
									<td class="colLeft">
										<label>PUNTO DE VENTA</label><br>
										<?php echo $order->oData->pointSale->name;?>
									</td>
									<td class="colRight">
										<label>DISTANCIA RECORRIDA</label><br>
										<?php echo $order->oData->driver->distanceKm." KM";?>
									</td>
								</tr>
								<tr>
									<td class="colLeft">
										<label>CANTIDAD DE PRODUCTOS</label><br>
										<?php
											$items = $order->oData->items; 
											echo sizeof($items);
										?>	
									</td>
									<td class="colRight">
										<button class="btn btn-success" id="<?php echo 'btnModalDetails_'.$orderNumber;?>">VER PEDIDO</button>
									</td>
								</tr>
							</table>
						</div>
				<?php
					}
				}
				else
				{
					if ($get['section'] == 'scheduled') {
				?>
						<div class="alert alert-danger">No tienes ordenes programadas actualmente.</div>
				<?php
					}else{
				?>
						<div class="alert alert-danger">No tienes ordenes actualmente.</div>
				<?php
					}
				}
			?>
		</div>

    </div>
</div>
<?php
$this->registerCssFile("@web/css/account.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
], 'orders');