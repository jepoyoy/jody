<h3>Daily Shuttle Passenger Report</h3>

<br/>
<i><?= date('Y-m-d H:i:s') ?></i>


Trips today: <?= count($trips) ?>

<?php foreach($trips as $trip): ?>

<?php
	$datestart =  $trip->schedule->trip_start . '02/20/1991'; 
	$dateStartStr = date('h:i:s a', strtotime($datestart));

	$dateend =  $trip->schedule->trip_end . '02/20/1991'; 
	$dateEndStr = date('h:i:s a', strtotime($dateend));
?>


<h5>Trip #<?= $trip->trip_id ?></h5>
<ul>
	<li><b>Route: </b><?= $trip->route->routeDesc ?></li>
	<li><b>Schedule: </b><?= $dateStartStr.' - '.$dateEndStr ?></li>
	<li><b>Trip Start Time: </b><?= $trip->start_time ?></li>
	<li><b>Trip Start Time: </b><?= $trip->end_time ?></li>
	<li><b>Trip Time:</b>
	<?php

		$date_a = new DateTime($trip->start_time);
		$date_b = new DateTime($trip->end_time);

		$interval = date_diff($date_a,$date_b);

		echo $interval->format('%h hours %i minutes %s seconds');

	?>
	</li>
</ul>

    <h5>Passenger List</h5>

    <table border=1 >

        <thead>
            <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Sched Match Check</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach( $trip->tripEmployees as $passenger ): ?>

                <tr>
                    <td><?= $passenger->trip_employee_id ?></td>
                    <td><?= $passenger->employee->fullname ?></td>
                    <td><?= $passenger->employee->email ?></td>
                    <td><?php

                        //checks if the original intended sched is used

                    $receipt_sched = $passenger->tripReceipt->schedule->schedule_id;
                    $trip_sched = $trip->schedule->schedule_id;

                    if( $receipt_sched == $trip_sched ){
                        echo 'No Issues';
                    }else{
                        echo 'With Issue';
                    }

                    ?></td>

                </tr>


            <?php endforeach ?>
        </tbody>

    </table>

    <br><br>

<?php endforeach ?>