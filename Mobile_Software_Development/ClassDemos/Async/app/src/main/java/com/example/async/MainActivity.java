package com.example.async;

import android.os.AsyncTask;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.widget.TextView;

public class MainActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        new CountDownTask().execute();
    }

    private class CountDownTask extends AsyncTask<Void, Integer, Void> {

        protected void onPreExecute() {
            TextView textView = findViewById(R.id.tv_counter);
            textView.setText("START");
        }

        @Override
        protected Void doInBackground(Void... voids) {

            for (int i = 15; i > 0; i--) {
                try {
                    Thread.sleep(1000);
                    publishProgress(i);
                }
                catch (InterruptedException e) {}
            }
            return null;
        }

        @Override
        protected void onProgressUpdate(Integer... values) {
            super.onProgressUpdate(values);

            TextView textView = findViewById(R.id.tv_counter);
            textView.setText(Integer.toString(values[0]));
        }


        protected void onPostExecute(Void result) {
            TextView textView = findViewById(R.id.tv_counter);
            textView.setText("DONE");
        }
    }
}
