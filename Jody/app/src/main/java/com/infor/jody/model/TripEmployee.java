package com.infor.jody.model;

import com.orm.SugarRecord;

/**
 * Created by jbarron on 3/15/2016.
 */
public class TripEmployee extends SugarRecord{

    public String createdDate;
    public int employeeId;
    public Long tripId;
    public int tripReceiptId;

    public TripEmployee(){}

    public TripEmployee(String createdDate, int employeeId, Long tripId, int tripReceiptId) {
        this.createdDate = createdDate;
        this.employeeId = employeeId;
        this.tripId = tripId;
        this.tripReceiptId = tripReceiptId;
    }
}
