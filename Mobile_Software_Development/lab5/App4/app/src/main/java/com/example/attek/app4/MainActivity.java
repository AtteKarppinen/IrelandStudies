package com.example.attek.app4;

import android.content.Intent;
import android.net.Uri;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.Toast;

public class MainActivity extends AppCompatActivity {

    private ImageView map;
    private EditText lat, lng;
    private String location;
    private Uri uri;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        map = findViewById(R.id.map);
        lat = findViewById(R.id.lat);
        lng = findViewById(R.id.lng);

    }

    public void launchMaps(View view) {
        location = "geo:" + lat.getText().toString() + ","
                + lng.getText().toString() + "?z";
        uri = Uri.parse(location);

        Intent intent = new Intent(Intent.ACTION_VIEW);
        intent.setData(uri);

        // If there is app that can handle intent, result is not null
        if (intent.resolveActivity(getPackageManager()) != null) {
            startActivity(intent);
        }
        else {
            Toast.makeText(this, "No required apps found", Toast.LENGTH_LONG).show();
        }
    }
}
