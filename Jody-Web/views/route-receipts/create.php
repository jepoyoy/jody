<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RouteReceipts */

$this->title = 'Create Route Receipts';
$this->params['breadcrumbs'][] = ['label' => 'Route Receipts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="route-receipts-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
