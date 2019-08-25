import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.ProgressBar;
import android.widget.TextView;

public class MainActivity extends AppCompatActivity {

    private FakeAsync fake_task;
    private ProgressBar prog_bar;
    private TextView txt_view;
    private Button cancel_but;
    private Button start_but;

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        prog_bar = findViewById(R.id.prog_bar);
        txt_view = findViewById(R.id.txt_view);
        cancel_but = findViewById(R.id.cancel_but);
        start_but = findViewById(R.id.start_but);
    }

    public void handleClicks(View v) {

        // Your code goes here!
    }
}