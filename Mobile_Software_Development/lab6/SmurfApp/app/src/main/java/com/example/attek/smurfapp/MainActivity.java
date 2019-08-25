package com.example.attek.smurfapp;

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
        setContentView(com.example.attek.smurfapp.R.layout.activity_main);

        player = MediaPlayer.create(this, com.example.attek.smurfapp.R.raw.theme_tune);

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

        ImageButton img = (ImageButton) findViewById(com.example.attek.smurfapp.R.id.smurf);
        RadioGroup group = (RadioGroup) findViewById(com.example.attek.smurfapp.R.id.smurf_group);
        int checkedID = group.getCheckedRadioButtonId();

        if (checkedID == com.example.attek.smurfapp.R.id.jokey) {
            img.setImageResource(com.example.attek.smurfapp.R.drawable.jokey);
        } else if (checkedID == com.example.attek.smurfapp.R.id.hefty) {
            img.setImageResource(com.example.attek.smurfapp.R.drawable.hefty);
        } else if (checkedID == com.example.attek.smurfapp.R.id.nerdy) {
            img.setImageResource(com.example.attek.smurfapp.R.drawable.nerdy);
        } else if (checkedID == com.example.attek.smurfapp.R.id.papa) {
            img.setImageResource(com.example.attek.smurfapp.R.drawable.papa);
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
        RadioGroup group = (RadioGroup) findViewById(com.example.attek.smurfapp.R.id.smurf_group);
        group.check(id);
        updateImage();
    }

    @Override
    protected void onPause() {
        super.onPause();
        Log.d("lifecycle","onPause");
    }

    @Override
    protected void onResume() {
        super.onResume();
        Log.d("lifecycle","onResume");

        if (player != null) {

        }
    }

    @Override
    protected void onRestart() {
        super.onRestart();
        Log.d("lifecycle","onRestart");
    }

    @Override
    protected void onStart() {
        super.onStart();
        Log.d("lifecycle","onStart");
    }

    @Override
    protected void onStop() {
        super.onStop();
        Log.d("lifecycle","onStop");
    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
        Log.d("lifecycle","onDestroy");
    }
}
