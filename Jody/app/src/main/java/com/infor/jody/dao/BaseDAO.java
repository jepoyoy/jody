package com.infor.jody.dao;

import android.content.SharedPreferences;
import android.util.Log;

import com.infor.jody.lib.APPUrl;
import com.infor.jody.lib.Callback;
import com.infor.jody.model.Employee;
import com.loopj.android.http.AsyncHttpClient;
import com.loopj.android.http.AsyncHttpResponseHandler;
import com.loopj.android.http.RequestParams;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import cz.msebera.android.httpclient.Header;

/**
 * Created by jbarron on 3/15/2016.
 */
public class BaseDAO {

    SharedPreferences sp;
    String SYNC_URL;
    Callback callback;

    public void syncDataFromWS(){

        String url = APPUrl.getURLPrefix( sp.getString(APPUrl.APP_SERVER, "localhost") );

        RequestParams params = new RequestParams();
        params.put("r", SYNC_URL);

        AsyncHttpClient client = new AsyncHttpClient();
        client.get(url, params, new AsyncHttpResponseHandler() {

            @Override
            public void onStart() {
                // called before request is started
            }

            @Override
            public void onSuccess(int statusCode, Header[] headers, byte[] response) {
                // called when response HTTP status is "200 OK"
                final String res = new String(response);
                android.util.Log.e("Response", "" + res);

                JSONArray content = null;
                JSONObject jsonRootObject = null;
                try {
                    jsonRootObject = new JSONObject(res);

                    if (jsonRootObject.getString("response").equals("success")) {
                        content = jsonRootObject.getJSONArray("data");
                        Log.d("BASEDao", "found - " + content);
                        for (int i = 0; i < content.length(); i++) {
                            JSONObject item = content.getJSONObject(i);

                            syncObjectToDB(item);

                        }
                    }

                } catch (JSONException e) {
                    e.printStackTrace();
                }

                callback.onFinish();
            }

            @Override
            public void onFailure(int statusCode, Header[] headers, byte[] errorResponse, Throwable e) {
                // called when response HTTP status is "4XX" (eg. 401, 403, 404)
            }

            @Override
            public void onRetry(int retryNo) {
                // called when request is retried
            }
        });

    }

    public void syncData(Callback callback){
        this.callback = callback;
    }

    public void syncObjectToDB( JSONObject item ) throws JSONException {

        //blank

    }

}
