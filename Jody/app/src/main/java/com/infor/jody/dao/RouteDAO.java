package com.infor.jody.dao;

import android.content.SharedPreferences;

import com.infor.jody.lib.APPUrl;
import com.infor.jody.lib.Callback;
import com.infor.jody.model.Driver;
import com.infor.jody.model.Route;

import org.json.JSONException;
import org.json.JSONObject;

/**
 * Created by jbarron on 3/15/2016.
 */
public class RouteDAO extends BaseDAO{


    public RouteDAO(SharedPreferences sp){
        this.sp = sp;
        this.SYNC_URL = APPUrl.SYNC_ROUTE;
    }

    public void syncData(Callback callback){
        super.syncData(callback);
        Route.deleteAll(Route.class);
        syncDataFromWS();
    }

    @Override
    public void syncObjectToDB(JSONObject item) throws JSONException {
        int routeId = item.getInt("route_id");
        String pointA = item.getString("pointA");
        String pointB= item.getString("pointB");
        String routeCode= item.getString("route_code");

        Route route = new Route(routeId, pointA, pointB, routeCode);
        route.save();
    }

}
