package com.infor.jody.model;

import com.orm.SugarRecord;

/**
 * Created by jbarron on 3/15/2016.
 */
public class Route extends SugarRecord {

    public int routeId;
    public String pointA;
    public String pointB;
    public String routeCode;

    public Route(){

    }

    public Route(int routeId, String pointA, String pointB, String routeCode) {
        this.routeId = routeId;
        this.pointA = pointA;
        this.pointB = pointB;
        this.routeCode = routeCode;
    }

    @Override
    public String toString() {
        return this.pointA + '-' + this.pointB;
    }

}
