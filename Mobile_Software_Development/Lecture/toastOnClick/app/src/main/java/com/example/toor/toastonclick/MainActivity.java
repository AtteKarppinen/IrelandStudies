package com.example.toor.toastonclick;

import android.content.Context;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.ImageView;
import android.widget.Toast;

public class MainActivity extends AppCompatActivity implements View.OnClickListener {

    private Context context;
    private ImageView smile, neutral, frown;
    private int duration;
    private String text;
    private Toast toast;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        context = getApplicationContext();
        duration = Toast.LENGTH_SHORT;
        text = "Weird";

        smile = findViewById(R.id.icon_1);
        neutral = findViewById(R.id.icon_2);
        frown = findViewById(R.id.icon_3);

        smile.setOnClickListener(this);
        neutral.setOnClickListener(this);
        frown.setOnClickListener(this);
    }

    public void onClick(View view) {
        switch (view.getId()) {
            case R.id.icon_1: {
                text = "Happy";
                break;
            }
            case R.id.icon_2: {
                text = "Neutral";
                break;
            }
            case R.id.icon_3: {
                text = "Sad";
                break;
            }
        }

        toast.makeText(context, text, duration).show();
    }
}
