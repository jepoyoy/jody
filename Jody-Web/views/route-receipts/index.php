<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RouteReceiptsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Route Receipts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="route-receipts-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Route Receipts', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'trip_receipt_id',
            'employee_id',
            'schedule_id',
            'created_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
