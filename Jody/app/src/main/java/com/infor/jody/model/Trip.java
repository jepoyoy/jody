package com.infor.jody.model;

import com.orm.SugarRecord;

/**
 * Created by jbarron on 3/15/2016.
 */
public class Trip extends SugarRecord{



    public String notes;
    public String isValidityEnabled;
    public String createdDate;
    public String updatedDate;

    public int scheduleId;
    public int routeId;
    public int driverId;
    public int vehicleId;

    public String startTime;
    public String endTime;

    public String datestr;
    public String timestr;

    public Trip(){}


    public Trip(String notes, String isValidityEnabled, String createdDate, String updatedDate, int scheduleId, int routeId, int driverId, int vehicleId, String startTime, String endTime, String datestr, String timestr) {
        this.notes = notes;
        this.isValidityEnabled = isValidityEnabled;
        this.createdDate = createdDate;
        this.updatedDate = updatedDate;
        this.scheduleId = scheduleId;
        this.routeId = routeId;
        this.driverId = driverId;
        this.vehicleId = vehicleId;
        this.startTime = startTime;
        this.endTime = endTime;
        this.datestr = datestr;
        this.timestr = timestr;
    }


}
