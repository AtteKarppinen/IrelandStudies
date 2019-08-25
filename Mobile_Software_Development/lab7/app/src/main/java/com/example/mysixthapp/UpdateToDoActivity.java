package com.example.mysixthapp;

import android.arch.persistence.room.Room;
import android.database.sqlite.SQLiteConstraintException;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.Toolbar;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import com.example.mysixthapp.db.AppDatabase;
import com.example.mysixthapp.db.ToDoDAO;
import com.example.mysixthapp.models.ToDo;

public class UpdateToDoActivity extends AppCompatActivity {

    public static String EXTRA_TODO_ID = "todo_id";

    private EditText mSummaryEditText;
    private EditText mDescriptionEditText;
    private TextView mCategory;
    private Button mUpdateButton;
    private Toolbar mToolbar;
    private ToDoDAO mToDoDAO;
    private ToDo TODO;

    @Override
    protected void onCreate(Bundle savedInstanceState) {

        super.onCreate(savedInstanceState);

        setContentView(R.layout.activity_update_contact);

		// Get the DAO here!
        
		
		
		mCategory = findViewById(R.id.updateCategory);
        mSummaryEditText = findViewById(R.id.todo_edit_summary);
        mDescriptionEditText = findViewById(R.id.todo_edit_description);
        mUpdateButton = findViewById(R.id.updateButton);
        mToolbar = findViewById(R.id.toolbar);

        TODO = mToDoDAO.getToDoWithId(getIntent().getIntExtra(EXTRA_TODO_ID, -1));

        initViews();
    }

    private void initViews() {
        setSupportActionBar(mToolbar);
        mCategory.setText(TODO.getCategory());
        mSummaryEditText.setText(TODO.getSummary());
        mDescriptionEditText.setText(TODO.getDescription());

        final int id = TODO.id;
        mUpdateButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                String category = mCategory.getText().toString();
                String summary = mSummaryEditText.getText().toString();
                String description = mDescriptionEditText.getText().toString();

                if (summary.length() == 0 || description.length() == 0) {
                    Toast.makeText(UpdateToDoActivity.this, "Please make sure all details are correct", Toast.LENGTH_SHORT).show();
                    return;
                }

                //Your code goes here to insert a Todo!
				
				
				
            }
        });
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.menu_update_options, menu);
        return super.onCreateOptionsMenu(menu);
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case R.id.delete: {
                mToDoDAO.delete(TODO);
                setResult(RESULT_OK);
                finish();
                break;
            }
        }
        return super.onOptionsItemSelected(item);
    }
}