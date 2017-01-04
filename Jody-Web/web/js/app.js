function Schedule(schedule_id, trip_start, pointA , trip_end, pointB, route_name, vehicle_name) {
  this.schedule_id = schedule_id;
  this.pointA = pointA;
  this.pointB = pointB;
  this.trip_start = trip_start;
  this.trip_end = trip_end;
  this.route_name = route_name;
  this.vehicle_name = vehicle_name;

  console.log('schedule instantiated');

  return {
	  schedule_id : schedule_id,
	  pointA : pointA,
	  pointB : pointB,
	  trip_start : trip_start,
	  trip_end : trip_end,
	  route_name : route_name,
	  vehicle_name : vehicle_name
    };
};

var SCHED_MAP = {
 
    s_map: [],
 
    put: function(schedule_id, schedule_obj) {
    	this.s_map[schedule_id] = schedule_obj;
    },
 
    get: function(schedule_id){
    	return this.s_map[schedule_id];
    }
}

function modalBT(schedule_id){
  $('#booking-confirm-modal').modal('show');

  var schedobj = SCHED_MAP.get(schedule_id);

  $('#vehicle-info').val( schedobj.vehicle_name );
  $('#book-route').val( schedobj.pointA + ' -> ' + schedobj.pointB );
  $('#pickup-dropoff').val( schedobj.trip_start + ' / ' + schedobj.trip_end  );

  //for hidden form
  $('#sched_id').val( schedobj.schedule_id );
}


function goToURL(href) {
      location.href = href;

    }

