<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EmployeeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Employees';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Employee', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'employee_id',
            'email:email',
            'fname',
            'lname',
            'password',
            [
                'value' => function ($data) {

                    if($data->is_admin == 1){
                        return 'Administrator';
                    };

                    return 'Regular User';

                },
            ],
            'mobile',
            // 'activation_key',
            // 'is_admin',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
