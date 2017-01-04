package com.infor.jody.dao;

import android.content.SharedPreferences;

import com.infor.jody.lib.APPUrl;
import com.infor.jody.lib.Callback;
import com.infor.jody.model.Driver;
import com.infor.jody.model.Vehicle;

import org.json.JSONException;
import org.json.JSONObject;

/**
 * Created by jbarron on 3/15/2016.
 */
public class DriverDAO extends BaseDAO{


    public DriverDAO(SharedPreferences sp){
        this.sp = sp;
        this.SYNC_URL = APPUrl.SYNC_DRIVER;
    }

    public void syncData(Callback callback){
        super.syncData(callback);
        Driver.deleteAll(Driver.class);
        syncDataFromWS();
    }

    @Override
    public void syncObjectToDB(JSONObject item) throws JSONException {
        int driverId = item.getInt("driver_id");
        String fname = item.getString("fname");
        String lname= item.getString("lname");
        String mname= item.getString("mname");
        String schedule= item.getString("schedule");
        String mobile= item.getString("mobile");

        Driver driver = new Driver(driverId, fname, lname, mname, schedule ,mobile);
        driver.save();
    }

}
