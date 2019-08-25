package com.example.atte.secondapp;

import android.content.Context;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.ImageButton;
import android.widget.Toast;

public class MainActivity extends AppCompatActivity {

    private Button button;
    private ImageButton imgBtn;
    private Context context;
    private CharSequence charSequence;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        button          = findViewById(R.id.btnClickMe);
        imgBtn          = findViewById(R.id.imgButton);
        context         = getApplicationContext();
        charSequence    = context.getText(R.string.btn_clicked);

        button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Toast.makeText(context, charSequence, Toast.LENGTH_LONG).show();
            }
        });

        imgBtn.setOnClickListener(new View.OnClickListener() {
            boolean changed = false;
            @Override
            public void onClick(View v) {

                if (!changed) {
                    imgBtn.setImageResource(R.drawable.android2);
                    changed = true;
                }
                else {
                    imgBtn.setImageResource(R.drawable.photo);
                    changed = false;
                }
            }
        });
    }
}
