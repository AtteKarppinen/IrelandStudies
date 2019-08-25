package com.example.attek.smurfapp;

import android.content.*;
import android.os.*;
import android.view.*;
import android.widget.*;
import android.support.v7.app.AppCompatActivity;

public class DetailsActivity extends AppCompatActivity {

    private static final String[] SMURF_DETAILS = {
            "Jokey\n\nHe presents gifts that then explode in the faces of those who open them.\n\nHe always finds a way to make a joke, even in dangerous situations.\n\nHe irritates the other Smurfs a bit, but in the end, they forgive him his weakness for playing tricks.",
            "Hefty\n\nThe strongest Smurf in the village.\n\nAn accomplished sportsman, he can be recognized by the tattoo in the form of a heart on his arm.\n\nHe’s often seen lifting weights to stay in shape.",
            "Nerdy\n\nThe only Smurf who always takes everything seriously.\n\nHe spends his time lecturing the other Smurfs and thinks he’s smarter than everyone else.\n\nThe other Smurfs have no problem telling him to go away!",
            "Papa\n\nHead of the village and a very powerful alchemist.\n\nHe is much older than the other Smurfs - 542 years old!\n\nHe often saves the Smurfs from the most perilous situations using his wisdom and knowledge."
    };

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(com.example.attek.smurfapp.R.layout.activity_details);

        Intent intent = getIntent();
        int id = intent.getIntExtra("smurf_id", com.example.attek.smurfapp.R.id.jokey);
        String text = "";
        if (id == com.example.attek.smurfapp.R.id.jokey) {
            text = SMURF_DETAILS[0];
        } else if (id == com.example.attek.smurfapp.R.id.hefty) {
            text = SMURF_DETAILS[1];
        } else if (id == com.example.attek.smurfapp.R.id.nerdy) {
            text = SMURF_DETAILS[2];
        } else { // if (id == R.id.raph)
            text = SMURF_DETAILS[3];
        }
        TextView tv = (TextView) findViewById(com.example.attek.smurfapp.R.id.smurf_info);
        tv.setText(text);
    }

    public void onclickButton(View view) {

        Intent intent = new Intent();
        setResult(RESULT_OK, intent);
        finish();
    }
}
