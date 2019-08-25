package com.example.mysixthapp;

import android.arch.persistence.room.Room;
import android.database.sqlite.SQLiteConstraintException;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Spinner;
import android.widget.Toast;

import com.example.mysixthapp.db.AppDatabase;
import com.example.mysixthapp.db.ToDoDAO;
import com.example.mysixthapp.models.ToDo;


public class CreateToDoActivity extends AppCompatActivity {

    private EditText mSummaryEditText;
    private EditText mDescriptionEditText;
    private Spinner mCategory;
    private Button mSaveButton;
    private ToDoDAO mToDoDAO;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_detail);

		// Get the DAO here!
		
		
		
        mCategory = findViewById(R.id.category);
        mSummaryEditText = findViewById(R.id.todo_edit_summary);
        mDescriptionEditText = findViewById(R.id.todo_edit_description);
        mSaveButton = findViewById(R.id.saveButton);

        mSaveButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                String category = mCategory.getSelectedItem().toString();
                String summary = mSummaryEditText.getText().toString();
                String description = mDescriptionEditText.getText().toString();

                if (summary.length() == 0 || description.length() == 0) {
                    Toast.makeText(CreateToDoActivity.this, "Please make sure all details are correct", Toast.LENGTH_SHORT).show();
                    return;
                }
                
				//Your code goes here to insert a Todo!
				
				
				
				
				
				
            }
        });
    }
}