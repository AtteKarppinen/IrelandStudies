package app.myseventhapp;

import android.os.AsyncTask;
import android.widget.ProgressBar;
import android.widget.TextView;

public class FakeAsync extends AsyncTask<Void, Integer, Integer> {

    ProgressBar prog_bar;
    TextView txt_view;
    private int progress_count = 0;

    FakeAsync(ProgressBar pb, TextView tv){
        prog_bar = pb;
        txt_view = tv;
    }

    @Override
    protected Integer doInBackground(Void...params) {
        for (int i = 0; i < 100; i++) {
            // Break if cancelled
            if (isCancelled()) break;

            try {
                Thread.sleep(100);
            }
            catch (InterruptedException e) {
                e.printStackTrace();
            }
            progress_count += 1;
            publishProgress(progress_count);
        }
        return progress_count;
    }

    @Override
    protected void onPreExecute() {
        super.onPreExecute();
        txt_view.setText("Download starting");
    }

    @Override
    protected void onProgressUpdate(Integer... progress) {
        super.onProgressUpdate(progress);

        prog_bar.setProgress(progress[0]);
        txt_view.setText("Download " + progress[0] + "% completed");
    }

    @Override
    protected void onPostExecute(Integer result) {
        super.onPostExecute(result);

        prog_bar.setProgress(result);
        txt_view.setText("Download " + result +"% completed!");
    }

    protected void onCancelled(Integer result) {
        super.onCancelled(result);

        // Check that progress has been started
        if (result != null && prog_bar != null) {
            prog_bar.setProgress(result);
            txt_view.setText("Download aborted - " + result + "% completed");
        }

    }
}