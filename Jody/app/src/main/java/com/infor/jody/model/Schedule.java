package com.infor.jody.model;

import com.orm.SugarRecord;

import java.text.DateFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;

/**
 * Created by jbarron on 3/15/2016.
 */
public class Schedule extends SugarRecord{

    public int scheduleId;
    public String tripStart;
    public String tripEnd;
    public int routeId;
    public int vehicleId;
    public int isActive;

    public Schedule(){

    }

    public Schedule(int scheduleId, String tripStart, String tripEnd, int routeId, int vehicleId, int isActive) {
        this.scheduleId = scheduleId;
        this.tripStart = tripStart;
        this.tripEnd = tripEnd;
        this.routeId = routeId;
        this.vehicleId = vehicleId;
        this.isActive = isActive;
    }

    @Override
    public String toString() {
        try {
            return this.getTripStartAMPM() + '-' + this.getTripEndAMPM();
        } catch (ParseException e) {
            e.printStackTrace();
        }
        return null;
    }

    public long getStartTimestamp() throws ParseException {
        SimpleDateFormat formatter = new SimpleDateFormat("dd/MM/yyyy HH:mm:ss");
        String dateInString = "02/02/1991 " + tripStart;
        Date d = formatter.parse(dateInString);
        Calendar c = Calendar.getInstance();
        c.setTime(d);
        long time = c.getTimeInMillis();
        long curr = System.currentTimeMillis();
        long diff = curr - time;    //Time difference in milliseconds
        return diff/1000;
    }

    public String getTripStartAMPM() throws ParseException {
        String input = "1991-02-20 " + tripStart;
        DateFormat inputFormat = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
        DateFormat outputFormat = new SimpleDateFormat("KK:mm a");
        return outputFormat.format(inputFormat.parse(input));
    }

    public String getTripEndAMPM() throws ParseException {
        String input = "1991-02-20 " + tripEnd;
        DateFormat inputFormat = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
        DateFormat outputFormat = new SimpleDateFormat("KK:mm a");
        return outputFormat.format(inputFormat.parse(input));
    }

}
