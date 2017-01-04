package com.infor.jody.dao;

import android.content.SharedPreferences;

import com.infor.jody.lib.APPUrl;
import com.infor.jody.lib.Callback;
import com.infor.jody.model.Route;
import com.infor.jody.model.Schedule;

import org.json.JSONException;
import org.json.JSONObject;

/**
 * Created by jbarron on 3/15/2016.
 */
public class ScheduleDAO extends BaseDAO{


    public ScheduleDAO(SharedPreferences sp){
        this.sp = sp;
        this.SYNC_URL = APPUrl.SYNC_SCHEDULE;
    }

    public void syncData(Callback callback){
        super.syncData(callback);
        Schedule.deleteAll(Schedule.class);
        syncDataFromWS();
    }

    @Override
    public void syncObjectToDB(JSONObject item) throws JSONException {
        int scheduleId = item.getInt("schedule_id");
        String tripStart = item.getString("trip_start");
        String tripEnd = item.getString("trip_end");
        int route_id = item.getInt("route_id");
        int vehicle_id = item.getInt("vehicle_id");
        int isActive = item.getInt("is_active");

        Schedule schedule = new Schedule(scheduleId, tripStart, tripEnd, route_id, vehicle_id, isActive);
        schedule.save();
    }

}
