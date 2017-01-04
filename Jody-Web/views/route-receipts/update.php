<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RouteReceipts */

$this->title = 'Update Route Receipts: ' . ' ' . $model->trip_receipt_id;
$this->params['breadcrumbs'][] = ['label' => 'Route Receipts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->trip_receipt_id, 'url' => ['view', 'id' => $model->trip_receipt_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="route-receipts-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
