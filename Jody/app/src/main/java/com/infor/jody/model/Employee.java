package com.infor.jody.model;

import com.orm.SugarRecord;

/**
 * Created by jbarron on 3/15/2016.
 */
public class Employee extends SugarRecord{

    public int employeeId;
    public String email;
    public String fname;
    public String lname;
    public String mobile;

    public Employee(){}

    public Employee(int employeeId, String email, String fname, String lname, String mobile) {
        this.employeeId = employeeId;
        this.email = email;
        this.fname = fname;
        this.lname = lname;
        this.mobile = mobile;
    }

    public String getName(){
        return this.lname + ',' + this.fname;
    }
}
