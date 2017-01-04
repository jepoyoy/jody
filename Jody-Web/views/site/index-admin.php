<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
          <section id="asdasd" class="col-md-12">
          <i>System Time: <?= date('Y-m-d H:i:s'); ?></i>
          </section>
        </div>

        <div class="row">


            <section id="latest-trips" class="col-md-6">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title">Latest Finished Trips</h3>
                  </div>

                  <div class="panel-body">

                    <?php foreach( $trips as $trip ): ?>

                    <?php
                      $route = $trip->route;
                      $route_code0 = $route->CodeAsArray[0];
                      $route_code1 = $route->CodeAsArray[1];

                      $datestart =  $trip->schedule->trip_start . '02/20/1991'; 


                       $dateend =  $trip->schedule->trip_end . '02/20/1991'; 
                    ?>

                      <div class="panel panel-default finished-trip" onclick="javascript:goToURL('<?=  urldecode(Url::toRoute(['trip/view', 'id' => $trip->trip_id])) ?>')">
                      <div class="panel-body">
                        
                        <div class="col-sm-6">
                            <img src="<?= Yii::$app->request->baseUrl . "/images/rt/rt-$route_code0.jpg"; ?>" alt="Infor Office" class="img-rounded">
                            <img src="<?= Yii::$app->request->baseUrl . "/images/rt/rt-rw.jpg"; ?>" alt="->" class="img-rounded">
                            <img src="<?= Yii::$app->request->baseUrl . "/images/rt/rt-$route_code1.jpg"; ?>" alt="Market Market" class="img-rounded">
                        </div>

                        <div class="col-sm-6">
                            <dl style="margin-bottom:0px">
                              <dt><?= $route->pointA ?> to <?= $route->pointB ?></dt>
                              <dd style="font-size:0.8em"><?php echo date('h:i:s a', strtotime($datestart)); ?> - <?php echo date('h:i:s a', strtotime($dateend)); ?></dd>
                              <dd style="font-size:0.8em"><?= $trip->driver->lname ?> , <?= $trip->driver->fname ?></dd>
                            </dl>
                        </div>

                      </div>
                    </div>

                    <?php endforeach; ?>
    
                  </div>
                </div>
            </section>

            <sectionid ="summary-and-reports" class="col-md-6">
                <div class="panel panel-default">
              
                      <div class="panel-heading">
                        <h3 class="panel-title">Daily Summary</h3>
                      </div>

                      <div class="panel-body">

                        <div class="row">

                            <div class="col-md-6">
                               <div class="hero-widget well well-sm">
                                    <div class="icon">
                                         <i class="glyphicon glyphicon-road"></i>
                                    </div>
                                    <div class="text">
                                        <var><?= $todaytrips ?></var>
                                        <label class="text-muted">Synced Trips</label>
                                    </div>
                                </div>
                            </div>
                        

                            <div class="col-md-6">
                               <div class="hero-widget well well-sm">
                                    <div class="icon">
                                         <i class="glyphicon glyphicon-qrcode"></i>
                                    </div>
                                    <div class="text">
                                        <var><?= $todayreceipts ?></var>
                                        <label class="text-muted">E-tickets created</label>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row" style="display:none">
                        
                             <div class="col-md-6">
                               <div class="hero-widget well well-sm">
                                    <div class="icon">
                                         <i class="glyphicon glyphicon-envelope"></i>
                                    </div>
                                    <div class="text">
                                        <var>0</var>
                                        <label class="text-muted">Unread Messages</label>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-6">
                               <div class="hero-widget well well-sm">
                                    <div class="icon">
                                         <i class="glyphicon glyphicon-star"></i>
                                    </div>
                                    <div class="text">
                                        <var>0</var>
                                        <label class="text-muted">VIP Bookings</label>
                                    </div>
                                </div>
                            </div>

                        </div>

                      </div>
                </div>

                <div class="panel panel-default">
              
                      <div class="panel-heading">
                        <h3 class="panel-title">Report</h3>
                      </div>

                      <div class="panel-body">
                        
                        <div class="dropdown">
                          <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            -Select a report-
                            <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li><a href="<?= urldecode(Url::toRoute(['report/daily-report'])) ?>">Daily Trip Report</a></li>
                          </ul>
                        </div>

                        <br/>

                        <button type="button" class="btn btn-primary">Load report</button>

                      </div>
                </div>
            </section>


        </div>

    </div>
</div>
