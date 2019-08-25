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

    private class CountDownTask extends AsyncTask<Void, Integer, Void>{

        @Override
        protected void onPreExecute(){
            TextView t = findViewById(R.id.tv_counter);
            t.setText("Before Thread Runs!");
        }

        @Override
        protected Void doInBackground(Void... voids) {

            for(int i = 5; i > 0; i--){
                try{
                    Thread.sleep(1500);
                    publishProgress(i);
                    Thread.sleep(750);

                }catch (InterruptedException e){}
            }
            return null;
        }

        @Override
        protected void onProgressUpdate(Integer... values) {
            super.onProgressUpdate(values);

            TextView t = findViewById(R.id.tv_counter);
            t.setText(Integer.toString(values[0].intValue()));

        }

        @Override
        protected void onPostExecute(Void result){
            TextView t = findViewById(R.id.tv_counter);
            t.setText("Thread Finished!");
        }

    }
}
