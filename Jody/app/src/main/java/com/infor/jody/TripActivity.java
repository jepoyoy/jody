package com.infor.jody;

import android.app.DatePickerDialog;
import android.app.Dialog;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.Color;
import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.util.Log;
import android.view.View;
import android.support.design.widget.NavigationView;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.DatePicker;
import android.widget.ImageButton;
import android.widget.ListView;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import com.infor.jody.adapter.TripEmployeeAdapter;
import com.infor.jody.lib.AESHelper;
import com.infor.jody.lib.APPUrl;
import com.infor.jody.lib.JSONWrapper;
import com.infor.jody.model.CustomSchedRoute;
import com.infor.jody.model.Driver;
import com.infor.jody.model.Route;
import com.infor.jody.model.Schedule;
import com.infor.jody.model.Trip;
import com.infor.jody.model.TripEmployee;
import com.infor.jody.model.Vehicle;

import org.json.JSONException;
import org.json.JSONObject;

import java.security.GeneralSecurityException;
import java.text.DateFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.List;
import java.util.Locale;

public class TripActivity extends AppCompatActivity
        implements NavigationView.OnNavigationItemSelectedListener {

    SharedPreferences appsettings;
    Vehicle currentVehicle;
    Driver currentDriver;
    ArrayAdapter<CustomSchedRoute> spinnerCSRAdapter;
    Spinner schedSpinner;

    CustomSchedRoute currentCSR;

    List<TripEmployee> passengers;
    TripEmployeeAdapter tripEmpAdapter;

    Trip currentTrip;

    int YEAR;
    int MONTH;
    int DAY;

    Context mContext;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_trip);
        setTitle("Manage Trips");
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        mContext = this;

        FloatingActionButton fab = (FloatingActionButton) findViewById(R.id.fab);
        fab.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Button btn = (Button) findViewById(R.id.btnContextBtn);
                String textVal = btn.getText().toString();

                if(textVal.equals("Start Trip")) {
                    Intent intent = new Intent("com.google.zxing.client.android.SCAN");
                    intent.putExtra("SCAN_MODE", "QR_CODE_MODE");
                    startActivityForResult(intent, 0);
                }else{
                    Toast.makeText(mContext, "Trip must be started to allow passenger scanning", Toast.LENGTH_LONG).show();
                }
            }
        });

        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        ActionBarDrawerToggle toggle = new ActionBarDrawerToggle(
                this, drawer, toolbar, R.string.navigation_drawer_open, R.string.navigation_drawer_close);
        drawer.setDrawerListener(toggle);
        toggle.syncState();

        NavigationView navigationView = (NavigationView) findViewById(R.id.nav_view);
        navigationView.setNavigationItemSelectedListener(this);

        View vi =
                navigationView.inflateHeaderView(R.layout.nav_header_trip);

        appsettings = this.getSharedPreferences(APPUrl.APP_CONFIG,MODE_PRIVATE);
        TextView txtDrvName = (TextView) vi.findViewById(R.id.txtDrvName);
        TextView txtVhcDetails = (TextView) vi.findViewById(R.id.txtVhcDetails);

        txtDrvName.setText( appsettings.getString("driver-name", "") );
        txtVhcDetails.setText(appsettings.getString("vehicle-name", ""));

        Log.d("CHECK", appsettings.getInt(APPUrl.APP_VEHICLE, 0) + "");

        currentDriver = Driver.find(Driver.class, "driver_id = ?" , appsettings.getInt(APPUrl.APP_DRIVER,0)+"").get(0);
        currentVehicle = Vehicle.find(Vehicle.class, "vehicle_id = ?", appsettings.getInt(APPUrl.APP_VEHICLE, 0) + "").get(0);

        schedSpinner = (Spinner) this.findViewById(R.id.spinnerSchedules);
        schedSpinner.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener()
        {
            @Override
            public void onItemSelected(AdapterView adapter, View v, int i, long lng) {

                CustomSchedRoute selectedCSR =  (CustomSchedRoute)adapter.getItemAtPosition(i);
                currentCSR = selectedCSR;
                updatePassengerList();
            }
            @Override
            public void onNothingSelected(AdapterView<?> parentView)
            {

            }
        });

        passengers = new ArrayList<TripEmployee>();
        tripEmpAdapter = new TripEmployeeAdapter(this, passengers);

        initializeTripLister();
    }

    private void initializeTripLister() {

        List<CustomSchedRoute> csr = new ArrayList<CustomSchedRoute>();
        List<Schedule> scheduleList = Schedule.find(Schedule.class, "1=1");

        for( Schedule sched : scheduleList ){

            Route tmpRt = Route.find(Route.class, "route_id = ?", sched.routeId +"").get(0);

            try {
                csr.add(new CustomSchedRoute(
                        sched.scheduleId,
                        tmpRt.routeId,
                        sched.toString(),
                        tmpRt.toString(),
                        sched.getStartTimestamp()
                ));
            } catch (ParseException e) {
                e.printStackTrace();
            }

            spinnerCSRAdapter = new ArrayAdapter(this,
                    android.R.layout.simple_spinner_item, csr);

            schedSpinner.setAdapter(spinnerCSRAdapter);

        }

        //Time init

        Calendar now = Calendar.getInstance();

        Button btnDate = (Button) findViewById(R.id.btnDate);
        //
        YEAR = now.get(Calendar.YEAR);
        MONTH = now.get(Calendar.MONTH) + 1;
        DAY = now.get(Calendar.DATE);

        btnDate.setText( YEAR + "-" + MONTH + "-" + DAY );
        try {
            updateBtnText();

            //Initialize CSR
            currentCSR = (CustomSchedRoute)schedSpinner.getSelectedItem();
            updatePassengerList();

        } catch (ParseException e) {
            e.printStackTrace();
        }

    }

    void updateBtnText() throws ParseException{

        Button btn = (Button) findViewById( R.id.btnDate );
        String string = btn.getText().toString();
        DateFormat format = new SimpleDateFormat("yyyy-M-d", Locale.ENGLISH);
        Date date = format.parse(string);

        DateFormat dfto = new SimpleDateFormat("EEE, MMM d, yyyy");

        btn.setText(dfto.format(date));
    }

    public void setDate(View view){
        showDialog(999);
    }

    @Override
    protected Dialog onCreateDialog(int id) {
        // TODO Auto-generated method stub
        if (id == 999) {
            return new DatePickerDialog(this, myDateListener, YEAR, MONTH-1, DAY);
        }
        return null;
    }

    private DatePickerDialog.OnDateSetListener myDateListener = new DatePickerDialog.OnDateSetListener() {
        @Override
        public void onDateSet(DatePicker arg0, int arg1, int arg2, int arg3) {

            YEAR = arg1;
            MONTH = arg2+1;
            DAY = arg3;

            Button btn = (Button) findViewById(R.id.btnDate);
            btn.setText( YEAR + "-" + (MONTH) + "-" + DAY );
            try {
                updateBtnText();
                CustomSchedRoute csr = (CustomSchedRoute)schedSpinner.getSelectedItem();
                currentCSR = csr;
                updatePassengerList();
            } catch (ParseException e) {
                e.printStackTrace();
            }

            //adapter.clear();
            //loadEventsOfDate();
        }
    };

    private void updatePassengerList() {

        String currentDay = YEAR + "-" + (MONTH) + "-" + DAY;

        tripEmpAdapter.clear();
        passengers.clear();

        List<Trip> tripsFiltered = Trip.find(Trip.class, "datestr = ? and schedule_id = ?", currentDay, currentCSR.scheduleId+"");

        if( !tripsFiltered.isEmpty() ){
            currentTrip = tripsFiltered.get(0);

            passengers = TripEmployee.find(TripEmployee.class, "trip_id = ?", currentTrip.getId() + "");
            tripEmpAdapter = new TripEmployeeAdapter(this, passengers);

            ListView listview = (ListView) findViewById(R.id.listPassengers);
            listview.setAdapter(tripEmpAdapter);

            if(currentTrip.startTime.length() > 0){
                updateContextBtn("End Trip");
            }else{
                updateContextBtn("Start Trip");
            }

        }else{

            updateContextBtn("Create Trip");
        }


    }

    private void updateContextBtn(String textVal) {

        Button btn = (Button) findViewById(R.id.btnContextBtn);
        btn.setText(textVal);

        if( textVal.equals("Create Trip") ){
            btn.setBackgroundColor(Color.parseColor("#43a047"));
        }

        if( textVal.equals("Start Trip") ){
            btn.setBackgroundColor(Color.parseColor("#E65100"));
        }

        if( textVal.equals("End Trip") ){
            btn.setBackgroundColor(Color.parseColor("#B71C1C"));
        }


    }

    public void processContextBtn(View view){

        Button btn = (Button) findViewById(R.id.btnContextBtn);
        String textVal = btn.getText().toString();

        DateFormat dateFormat = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
        Date date = new Date();
        String currentDay = YEAR + "-" + (MONTH) + "-" + DAY;
        String currentDate = dateFormat.format(date);

        if( textVal.equals("Create Trip") ){

            Trip newTrip = new Trip("","",currentDate,currentDate,currentCSR.scheduleId,
                    currentCSR.routeId, currentDriver.driverId, currentVehicle.vehicleId,"","",
                    currentDay , currentCSR.toString());
            newTrip.save();
            updateContextBtn("Start Trip");
            updatePassengerList();
        }

        if( textVal.equals("Start Trip") ){

            currentTrip.startTime = currentDate;
            currentTrip.save();
            updateContextBtn("End Trip");
        }

        if( textVal.equals("End Trip") ){

            currentTrip.endTime = currentDate;
            currentTrip.save();
            btn.setBackgroundColor(Color.parseColor("#424242"));
            btn.setText("Trip Finished");
        }



    }

    public void onActivityResult(int requestCode, int resultCode, Intent intent) {
        if (requestCode == 0) {
            if (resultCode == RESULT_OK) {
                String contents = intent.getStringExtra("SCAN_RESULT");
                String format = intent.getStringExtra("SCAN_RESULT_FORMAT");

                String scanned = "";

                try{
                    scanned = AESHelper.decrypt(contents.trim(), APPUrl.APP_AESKEY);

                    JSONObject jsonRootObject = new JSONObject(scanned);
                    Log.d("scanned", scanned);

                    int tripReceiptId = jsonRootObject.getInt("trip_receipt_id");
                    int employeeId = jsonRootObject.getInt("employee_id");
                    int scheduleId = jsonRootObject.getInt("schedule_id");
                    String tripStartTime = jsonRootObject.getString("trip_start");
                    int routeId = jsonRootObject.getInt("route_id");
                    String routeCode= jsonRootObject.getString("route_code");
                    String receiptDate= jsonRootObject.getString("receipt_date");

                    Date currentDateObj = new Date();

                    SimpleDateFormat sdfYMD = new SimpleDateFormat("yyyy-MM-dd");
                    String currentDay = YEAR + "-" + (MONTH) + "-" + DAY;

                    Calendar currentTime = Calendar.getInstance();
                    try {
                        currentTime.setTime(sdfYMD.parse(currentDay));// all done
                    } catch (ParseException e) {
                        e.printStackTrace();
                    }

                    //first filter - check route - must match
                    if(currentCSR.routeId != routeId){
                        Toast.makeText(this, "Cannot accept passenger - Routes do not match", Toast.LENGTH_LONG).show();
                        return;
                    }

                    Calendar receiptDateTime = null;
                    //second filter - ticket must be bought within the day
                    try {
                        receiptDateTime = Calendar.getInstance();
                        SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
                        receiptDateTime.setTime(sdf.parse(receiptDate));// all done

                       /* int year = cal.get(Calendar.YEAR);
                        int month = cal.get(Calendar.MONTH);
                        int day = cal.get(Calendar.DAY_OF_MONTH);
                        */

                        Log.d("check date year", receiptDateTime.get(Calendar.YEAR)+"");
                        Log.d("check date year", currentTime.get(Calendar.YEAR)+"");

                        Log.d("check date mth", receiptDateTime.get(Calendar.MONTH)+"");
                        Log.d("check date mth", currentTime.get(Calendar.MONTH)+"");

                        Log.d("check date dom", receiptDateTime.get(Calendar.DAY_OF_MONTH)+"");
                        Log.d("check date dom", currentTime.get(Calendar.DAY_OF_MONTH)+"");

                        if( receiptDateTime.get(Calendar.YEAR) != currentTime.get(Calendar.YEAR) ||
                                receiptDateTime.get(Calendar.MONTH) != currentTime.get(Calendar.MONTH) ||
                                receiptDateTime.get(Calendar.DAY_OF_MONTH) != currentTime.get(Calendar.DAY_OF_MONTH)
                                ){
                            Toast.makeText(this, "Cannot accept passenger - E-ticket not booked today", Toast.LENGTH_LONG).show();
                            return;
                        }


                    } catch (ParseException e) {
                        e.printStackTrace();
                    }

                    //third filter - ticket validity is 1 hour 30 minutes
                    long diff = currentTime.getTime().getTime() - receiptDateTime.getTime().getTime();
                    long diffMinutes = diff / (60 * 1000) % 60;

                    if(diffMinutes > 180){
                        Toast.makeText(this, "Cannot accept passenger - E-ticket validity passed 1 Hour 30 minutes", Toast.LENGTH_LONG).show();
                        return;
                    }

                    //if all else fails, add the passenger

                    DateFormat dateFormat = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
                    Date date = new Date();

                    TripEmployee te = new TripEmployee(dateFormat.format(date), employeeId, currentTrip.getId(), tripReceiptId);
                    te.save();
                    updatePassengerList();

                } catch (GeneralSecurityException e) {
                    e.printStackTrace();
                } catch (JSONException e) {
                    e.printStackTrace();
                }


            } else if (resultCode == RESULT_CANCELED) {
                // Handle cancel
            }
        }
    }

    public void deletePassenger(View view){

        ImageButton imgBtn = (ImageButton)view;

        String tripEmployeeId = imgBtn.getTag().toString();

        TripEmployee passenger = TripEmployee.findById(TripEmployee.class, Long.valueOf(tripEmployeeId));
        passenger.delete();

        updatePassengerList();
    }


    @Override
    public void onBackPressed() {
        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        if (drawer.isDrawerOpen(GravityCompat.START)) {
            drawer.closeDrawer(GravityCompat.START);
        } else {
            super.onBackPressed();
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.trip, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_settings) {

            TripEmployee.deleteAll(TripEmployee.class);
            Trip.deleteAll(Trip.class);

            return true;
        }

        return super.onOptionsItemSelected(item);
    }

    @SuppressWarnings("StatementWithEmptyBody")
    @Override
    public boolean onNavigationItemSelected(MenuItem item) {
        // Handle navigation view item clicks here.
        int id = item.getItemId();

        if (id == R.id.nav_camera) {
            // Handle the camera action
        } else if (id == R.id.nav_gallery) {

        } else if (id == R.id.nav_slideshow) {

        } else if (id == R.id.nav_manage) {

        } else if (id == R.id.nav_share) {

        }

        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        drawer.closeDrawer(GravityCompat.START);
        return true;
    }
}
