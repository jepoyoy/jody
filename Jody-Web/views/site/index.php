<?php
use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
      <div class="container">
        <h1>Hello, world!</h1>
        <p>This is Jody, our online shuttle booking app. Use Jody to book tickets for various city routes to make your commuting easier. You can open Jody from your mobile browser or PC</p>
        <p><?= Html::a('Login as Infor employee', ['login'], ['class' => 'btn btn-primary']) ?></p>
      </div>
    </div>

    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-4">
          <h2>Book your shuttle e-tickets online</h2>
          <p>Access Jody from your mobile browser or PC. You only need your Infor credentials</p>
        </div>
        <div class="col-md-4">
          <h2>Never miss your ride!</h2>
          <p>Thru SMS reminders, you can always catch your shuttle on-time.</p>
       </div>
        <div class="col-md-4">
          <h2>More routes coming soon</h2>
          <p>Book shuttle rides to and from office  - more routes to come.</p> 
        </div>
      </div>
    </div> <!-- /container -->

</div>
