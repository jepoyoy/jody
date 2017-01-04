package com.infor.jody.model;

/**
 * Created by jbarron on 3/16/2016.
 */
public class CustomSchedRoute {

    public int scheduleId;
    public int routeId;
    public String schedDescription;
    public String routeDescription;
    public long schedRouteDate;

    public CustomSchedRoute(int scheduleId, int routeId, String schedDescription, String routeDescription, long schedRouteDate) {
        this.scheduleId = scheduleId;
        this.routeId = routeId;
        this.schedDescription = schedDescription;
        this.routeDescription = routeDescription;
        this.schedRouteDate = schedRouteDate;
    }

    @Override
    public String toString() {
        return this.routeDescription + ' ' + this.schedDescription;
    }
}
