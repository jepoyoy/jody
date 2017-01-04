package com.infor.jody.lib;

import org.json.JSONException;
import org.json.JSONObject;

/**
 * Created by Jeff on 11/17/2015.
 */
public class JSONWrapper extends JSONObject{

    public JSONWrapper() throws JSONException{
        super();
    }

    public JSONWrapper(String jsonStr) throws JSONException{
        super(jsonStr);
    }

    public String getStringOrBlank(String fieldName) {

        try {
            return this.getString(fieldName);
        } catch (JSONException e) {
            return "";
        }

    }
}
