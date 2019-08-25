package com.example.myfifthapp;

import android.support.v7.app.AppCompatActivity;

import android.content.Intent;
import android.media.MediaPlayer;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.ImageButton;
import android.widget.RadioGroup;
import android.widget.Toast;

public class MainActivity extends AppCompatActivity {

    private static final int REQUEST_CODE_DETAILS_ACTIVITY = 999;

    private MediaPlayer player;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(com.example.myfifthapp.R.layout.activity_main);

        player = MediaPlayer.create(this, com.example.myfifthapp.R.raw.theme_tune);

    }

    public void onClickSmurfImage(View view) {

        // Code goes here...
    }

    @Override
    protected void onSaveInstanceState(Bundle outState) {

        super.onSaveInstanceState(outState);

        // Code goes here...

    }

    public void selectSmurf(View view) {
        updateImage();
    }

    private void updateImage() {

        ImageButton img = (ImageButton) findViewById(com.example.myfifthapp.R.id.smurf);
        RadioGroup group = (RadioGroup) findViewById(com.example.myfifthapp.R.id.smurf_group);
        int checkedID = group.getCheckedRadioButtonId();

        if (checkedID == com.example.myfifthapp.R.id.jokey) {
            img.setImageResource(com.example.myfifthapp.R.drawable.jokey);
        } else if (checkedID == com.example.myfifthapp.R.id.hefty) {
            img.setImageResource(com.example.myfifthapp.R.drawable.hefty);
        } else if (checkedID == com.example.myfifthapp.R.id.nerdy) {
            img.setImageResource(com.example.myfifthapp.R.drawable.nerdy);
        } else if (checkedID == com.example.myfifthapp.R.id.papa) {
            img.setImageResource(com.example.myfifthapp.R.drawable.papa);
        }
    }

    protected void onActivityResult(int requestCode, int resultCode, Intent intent) {
        super.onActivityResult(requestCode, resultCode, intent);
        if (requestCode == REQUEST_CODE_DETAILS_ACTIVITY &&
                resultCode == RESULT_OK) {

            Toast.makeText(this, "Result OK!" , Toast.LENGTH_SHORT).show();
        }
    }

    @Override
    protected void onRestoreInstanceState(Bundle savedInstanceState) {

        super.onRestoreInstanceState(savedInstanceState);

        int id = savedInstanceState.getInt("id");
        RadioGroup group = (RadioGroup) findViewById(com.example.myfifthapp.R.id.smurf_group);
        group.check(id);
        updateImage();
    }
}