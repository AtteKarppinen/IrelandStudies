import android.os.AsyncTask;
import android.view.View;
import android.widget.ProgressBar;
import android.widget.TextView;
import android.util.Log;

public class FakeAsync extends AsyncTask<Void, Integer, Integer> {

    ProgressBar prog_bar;
    TextView txt_view;

    FakeAsync(ProgressBar pb, TextView tv){
        prog_bar = pb;
        txt_view = tv;
    }

	@Override
    protected Integer doInBackground(Void...params) {

        // Your Code Goes here!
    }
	
    @Override
    protected void onPreExecute() {
        super.onPreExecute();
        // Your Code Goes here!
    }

    @Override
    protected void onProgressUpdate(Integer... progress) {
        super.onProgressUpdate(progress);

        // Your Code Goes here!
    }

    @Override
    protected void onPostExecute(Integer result) {
        super.onPostExecute(result);
		
        // Your Code Goes here!
    }

    protected void onCancelled(Integer result) {
        super.onCancelled(result);

        // Your Code Goes here!
    }
}
