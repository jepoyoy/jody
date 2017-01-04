package com.infor.jody;

import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.EditText;
import android.widget.Spinner;

import com.infor.jody.dao.DriverDAO;
import com.infor.jody.dao.EmployeeDAO;
import com.infor.jody.dao.RouteDAO;
import com.infor.jody.dao.ScheduleDAO;
import com.infor.jody.dao.VehicleDAO;
import com.infor.jody.lib.Callback;
import com.infor.jody.model.Driver;
import com.infor.jody.model.Employee;
import com.infor.jody.lib.APPUrl;
import com.infor.jody.model.Trip;
import com.infor.jody.model.Vehicle;
import com.loopj.android.http.AsyncHttpClient;
import com.loopj.android.http.AsyncHttpResponseHandler;
import com.loopj.android.http.RequestParams;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.Iterator;
import java.util.List;

import cz.msebera.android.httpclient.Header;

public class MainActivity extends AppCompatActivity {

    SharedPreferences appsettings;
    Context mContext;
    Spinner vhcSpinner, drvSpinner;
    ArrayAdapter<Vehicle> spinnerArrayAdapterV, spinnerArrayAdapterD;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        mContext = this;

        appsettings = this.getSharedPreferences(APPUrl.APP_CONFIG,MODE_PRIVATE);

        vhcSpinner= (Spinner) this.findViewById(R.id.spinVehicle);
        drvSpinner= (Spinner) this.findViewById(R.id.spinDriver);

        populateSpinnerVehicle();
        populateSpinnerDriver();
    }

    public void syncData(View view){

        EmployeeDAO empDao = new EmployeeDAO(appsettings);
        empDao.syncData(new Callback() {
            @Override
            public void onFinish() {
                Log.d("finish", "employee sync");
            }
        });

        RouteDAO routeDao = new RouteDAO(appsettings);
        routeDao.syncData(new Callback() {
            @Override
            public void onFinish() {
                Log.d("finish", "routes sync");
            }
        });

        ScheduleDAO schedDao = new ScheduleDAO(appsettings);
        schedDao.syncData(new Callback() {
            @Override
            public void onFinish() {
                Log.d("finish", "sched sync");
            }
        });

        VehicleDAO vhcDao = new VehicleDAO(appsettings);
        vhcDao.syncData(new Callback() {
            @Override
            public void onFinish() {
                Log.d("finish", "vehicle sync");

                spinnerArrayAdapterV.clear();
                populateSpinnerVehicle();

            }
        });

        DriverDAO drvDao = new DriverDAO(appsettings);
        drvDao.syncData(new Callback() {
            @Override
            public void onFinish() {
                Log.d("finish", "driver sync");

                spinnerArrayAdapterD.clear();
                populateSpinnerDriver();
            }
        });

    }

    void populateSpinnerVehicle(){

        List<Vehicle> allVehicles = Vehicle.listAll(Vehicle.class);

         spinnerArrayAdapterV = new ArrayAdapter(mContext,
                android.R.layout.simple_spinner_item, allVehicles);

        vhcSpinner.setAdapter(spinnerArrayAdapterV);
    }

    void populateSpinnerDriver(){
        List<Driver> allDrivers = Driver.listAll(Driver.class);

         spinnerArrayAdapterD = new ArrayAdapter(mContext,
                android.R.layout.simple_spinner_item, allDrivers);

        drvSpinner.setAdapter(spinnerArrayAdapterD);
    }

    public void startApp(View view){

        Vehicle vehicle = (Vehicle)vhcSpinner.getSelectedItem();
        Driver driver = (Driver)drvSpinner.getSelectedItem();

        SharedPreferences.Editor editor = appsettings.edit();
        editor.putInt(APPUrl.APP_DRIVER, driver.driverId);
        editor.putInt(APPUrl.APP_VEHICLE, vehicle.vehicleId);
        editor.putString("driver-name", driver.toString());
        editor.putString("vehicle-name", vehicle.toString());
        editor.commit();

        Intent tripPage = new Intent(mContext, TripActivity.class);
        this.startActivity(tripPage);
    }

    public void updateServer(View view){
        AlertDialog.Builder builder = new AlertDialog.Builder(this);
        builder.setTitle("Input server address");

        // Set up the input
        final EditText input = new EditText(this);

        input.setText( appsettings.getString(APPUrl.APP_SERVER,"") );
        // Specify the type of input expected; this, for example, sets the input as a password, and will mask the text
        builder.setView(input);

        // Set up the buttons
        builder.setPositiveButton("OK", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                SharedPreferences.Editor editor = appsettings.edit();
                editor.putString(APPUrl.APP_SERVER, input.getText().toString());
                editor.commit();
            }
        });
        builder.setNegativeButton("Cancel", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                dialog.cancel();
            }
        });

        builder.show();
    }
}
