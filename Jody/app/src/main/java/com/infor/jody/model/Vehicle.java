package com.infor.jody.model;

import com.orm.SugarRecord;

/**
 * Created by jbarron on 3/15/2016.
 */
public class Vehicle extends SugarRecord{

    public int vehicleId;
    public String description;
    public String platenum;
    public int isActive;
    public int capacity;

    public Vehicle(){

    }

    public Vehicle(int vehicleId, String description, String platenum, int isActive, int capacity) {
        this.vehicleId = vehicleId;
        this.description = description;
        this.platenum = platenum;
        this.isActive = isActive;
        this.capacity = capacity;
    }

    @Override
    public String toString() {
        return this.description + '-' + this.platenum;
    }
}
