package com.infor.jody.lib;

/**
 * Created by Jeff on 12/19/2015.
 */
public class APPUrl {

    public final static String APP_SERVER = "appserver_url";
    public final static String APP_DRIVER = "appdriver";
    public final static String APP_VEHICLE = "appvehicle";

    public final static String APP_CONFIG = "com.infor.jody";

    //default yii web url
    public final static String APP_HTTP = "http://";
    public final static String DEFAULT_URL = "/jody/web/index.php";

    //sync URLS
    public final static String SYNC_EMPLOYEE = "employee/sync";
    public final static String SYNC_VEHICLE = "vehicle/sync";
    public final static String SYNC_DRIVER = "driver/sync";
    public final static String SYNC_ROUTE = "route/sync";
    public final static String SYNC_SCHEDULE = "schedule/sync";

    public static String getURLPrefix(String serverName){
        return APP_HTTP + serverName + DEFAULT_URL;
    }

    public final static String APP_AESKEY = "57238004e784498bbc2f8bf984565090";

}
