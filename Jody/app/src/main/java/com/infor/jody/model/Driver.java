package com.infor.jody.model;

import com.orm.SugarRecord;

/**
 * Created by jbarron on 3/15/2016.
 */
public class Driver extends SugarRecord{

    public int driverId;
    public String fname;
    public String lname;
    public String mname;
    public String schedule;
    public String mobile;

    public Driver(){

    }

    public Driver(int driverId, String fname, String lname, String mname, String schedule, String mobile) {
        this.driverId = driverId;
        this.fname = fname;
        this.lname = lname;
        this.mname = mname;
        this.schedule = schedule;
        this.mobile = mobile;
    }

    @Override
    public String toString() {
        return this.lname + ',' + this.fname;
    }
}
