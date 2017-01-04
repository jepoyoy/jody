<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\time\TimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Schedule */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="schedule-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'trip_start')->widget(TimePicker::classname(), ['pluginOptions' => [
        'showSeconds' => false,
        'showMeridian' => false
    ]]); ?>

    <?= $form->field($model, 'trip_end')->widget(TimePicker::classname(), ['pluginOptions' => [
        'showSeconds' => false,
        'showMeridian' => false
    ]]); ?>

    <?php $routeArray = ArrayHelper::map(\app\models\Route::find()->orderBy('route_id')->all(), 'route_id', 'RouteDesc') ?>
    <?= $form->field($model, 'route_id')->dropDownList($routeArray, ['prompt' => '---- Select Route ----'])->label('Route') ?>

    <?php $vehicleArray = ArrayHelper::map(\app\models\Vehicle::find()->orderBy('vehicle_id')->all(), 'vehicle_id', 'VehicleDesc') ?>
    <?= $form->field($model, 'vehicle_id')->dropDownList($vehicleArray, ['prompt' => '---- Select Vehicle ----'])->label('Vehicle') ?>

    <?= $form->field($model, 'is_active')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
