package com.infor.jody;

import android.app.Application;
import android.content.res.Configuration;

import com.orm.SugarApp;

/**
 * Created by jbarron on 3/15/2016.
 */
public class JodyApplication extends SugarApp {

    @Override
    public void onConfigurationChanged(Configuration newConfig) {
        super.onConfigurationChanged(newConfig);
    }

    @Override
    public void onCreate() {
        super.onCreate();
    }

    @Override
    public void onLowMemory() {
        super.onLowMemory();
    }

    @Override
    public void onTerminate() {
        super.onTerminate();
    }

}