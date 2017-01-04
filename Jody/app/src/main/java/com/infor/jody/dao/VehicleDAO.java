package com.infor.jody.dao;

import android.content.SharedPreferences;

import com.infor.jody.lib.APPUrl;
import com.infor.jody.lib.Callback;
import com.infor.jody.model.Employee;
import com.infor.jody.model.Vehicle;

import org.json.JSONException;
import org.json.JSONObject;

/**
 * Created by jbarron on 3/15/2016.
 */
public class VehicleDAO extends BaseDAO{


    public VehicleDAO(SharedPreferences sp){
        this.sp = sp;
        this.SYNC_URL = APPUrl.SYNC_VEHICLE;
    }

    public void syncData(Callback callback){
        super.syncData(callback);
        Vehicle.deleteAll(Vehicle.class);
        syncDataFromWS();
    }

    @Override
    public void syncObjectToDB(JSONObject item) throws JSONException {
        int vehicleid = item.getInt("vehicle_id");
        String description = item.getString("description");
        String platenum= item.getString("platenum");
        int isactive= item.getInt("isactive");
        int capacity = item.getInt("capacity");

        Vehicle vehicle = new Vehicle(vehicleid,description, platenum, isactive, capacity);
        vehicle.save();
    }

}
