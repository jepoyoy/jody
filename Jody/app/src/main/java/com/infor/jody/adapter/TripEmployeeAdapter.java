package com.infor.jody.adapter;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.TextView;

import com.infor.jody.R;
import com.infor.jody.model.Employee;
import com.infor.jody.model.TripEmployee;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.List;

/**
 * Created by jbarron on 3/16/2016.
 */
public class TripEmployeeAdapter extends ArrayAdapter<TripEmployee> {

    Context context;
    TripEmployee[] data;
    private static LayoutInflater inflater = null;

    public TripEmployeeAdapter(Context context, List<TripEmployee> items) {
        super(context, 0, items);
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {

        // Check if an existing view is being reused, otherwise inflate the view
        if (convertView == null) {
            convertView = LayoutInflater.from(getContext()).inflate(R.layout.dashboard_menu_listitem, parent, false);
        }
        // Get the data item for this position
        TripEmployee dmItem = getItem(position);

        Employee employee = Employee.find(Employee.class, "employee_id = ?" ,dmItem.employeeId+"").get(0);

        TextView title = (TextView) convertView.findViewById(R.id.title);
        TextView sub = (TextView) convertView.findViewById(R.id.sub);
        ImageButton icon = (ImageButton) convertView.findViewById(R.id.imgDelete);

        title.setText(employee.getName() );
        sub.setText(employee.email);

        icon.setTag( dmItem.getId() );
        // Return the completed view to render on screen
        return convertView;
    }


}
