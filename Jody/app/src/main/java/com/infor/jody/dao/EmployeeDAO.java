package com.infor.jody.dao;

import android.content.SharedPreferences;

import com.infor.jody.lib.APPUrl;
import com.infor.jody.lib.Callback;
import com.infor.jody.model.Employee;

import org.json.JSONException;
import org.json.JSONObject;

/**
 * Created by jbarron on 3/15/2016.
 */
public class EmployeeDAO extends BaseDAO{


    public EmployeeDAO(SharedPreferences sp){
        this.sp = sp;
        this.SYNC_URL = APPUrl.SYNC_EMPLOYEE;
    }

    public void syncData(Callback callback){
        super.syncData(callback);
        Employee.deleteAll(Employee.class);
        syncDataFromWS();
    }

    @Override
    public void syncObjectToDB(JSONObject item) throws JSONException {
        int employeeId = item.getInt("employee_id");
        String email = item.getString("email");
        String fname= item.getString("fname");
        String lname= item.getString("lname");
        String mobile= item.getString("mobile");

        Employee emp = new Employee(employeeId,email, fname, lname, mobile);
        emp.save();
    }

}
