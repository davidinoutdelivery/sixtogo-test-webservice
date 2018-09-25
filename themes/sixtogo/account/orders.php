<?php

use yii\helpers\Html;

$session = Yii::$app->session;
$session->open();

$this->title = 'Órdenes';

$list = json_decode($estados);
$ordersList = json_decode($orders);

?>
<div class="row">
    <div class="col-xs-12 col-md-8" style="margin: auto;text-align: center;float: none;">
        
        <h1 class="gotham-medium"><?php echo $this->title;?></h1>
		
		<div style="text-align: left;padding: 10px;">

			<a href="orders?section=all" class="btn btn-primary btn-category">TODAS</a>
			<a href="orders?section=scheduled" class="btn btn-primary btn-category">PROGRAMADAS</a>
		     
		</div>
		<div style="text-align: left;padding: 10px;">
			<?php
				foreach ($list as $state) {
			?>
					<a href="../account/orders" class="btn btn-success" style="margin-top: 5px;"><?php echo $state->oData->name;?></a>
			<?php
				}
			?>
			<!--<a href="orders?section=all&state=" class="btn btn-success btn-status">Solicitado</a>
			<a href="orders?section=all&state=" class="btn btn-success btn-status">Preparación</a>
			<a href="orders?section=all&state=" class="btn btn-success btn-status">En Transito</a>
			<a href="orders?section=all&state=" class="btn btn-success btn-status">Entregado</a>
			<a href="orders?section=all&state=" class="btn btn-success btn-status">Calificado</a>
			<a href="orders?section=all&state=" class="btn btn-success btn-status">Cancelado</a>-->
		</div>
		<div style="text-align: left;padding: 10px;">
			<?php
				foreach ($ordersList as $order) 
				{
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
									<button class="btn btn-success">VER PEDIDO</button>
								</td>
							</tr>
						</table>
					</div>
			<?php
				}
			?>
		</div>

    </div>
</div>
<?php
$this->registerCssFile("@web/css/account.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
], 'orders');
