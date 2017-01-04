<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;

?>
<div class="route-receipts-view">

    <h3>Here's your booking!</h3>

    <p>You may use this E-Ticket to board in to your shuttle. This e-ticket is activated for 1 hour only.</p>
    <p>You may only use it for the Route: <?= $model->schedule->route->RouteDesc ?></p>

    <img src="<?= urldecode(Url::toRoute(['qr/index', 'id' => $model->trip_receipt_id])); ?>" />

    <br/>

    <a href="<?= urldecode(Url::toRoute(['qr/index', 'id' => $model->trip_receipt_id, 'download' => 'true'])); ?>" class="btn btn-primary btn-lg active" role="button">Download Image</a>

</div>
