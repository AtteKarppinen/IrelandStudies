package com.example.mysixthapp;

import android.arch.persistence.room.Room;
import android.content.Intent;
import android.support.design.widget.FloatingActionButton;
import android.support.v4.content.ContextCompat;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.View;

import com.example.mysixthapp.db.AppDatabase;
import com.example.mysixthapp.db.ToDoDAO;
import com.example.mysixthapp.models.ToDo;

import java.util.ArrayList;

public class MainActivity extends AppCompatActivity {

    private static final int RC_CREATE_TODO = 1;
    private static final int RC_UPDATE_TODO = 2;

    private RecyclerView mToDosRecyclerView;
    private ToDoRecyclerAdapter mToDoRecyclerAdapter;
    private FloatingActionButton mAddToDoFloatingActionButton;
    private ToDoDAO mToDoDAO;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

		// Get the DAO here!
        mToDoDAO = Room.databaseBuilder(this, AppDatabase.class, "todo")
                .allowMainThreadQueries()
                .build()
                .getToDoDAO();
		
		
		mToDosRecyclerView = findViewById(R.id.contactsRecyclerView);
        mToDosRecyclerView.setLayoutManager(new LinearLayoutManager(this));
        mAddToDoFloatingActionButton = findViewById(R.id.addContactFloatingActionButton);

        int colors[] = {ContextCompat.getColor(this, R.color.colorAccent),
                ContextCompat.getColor(this, android.R.color.holo_orange_light),
                ContextCompat.getColor(this, android.R.color.holo_green_light),
                ContextCompat.getColor(this, android.R.color.holo_blue_dark)};

        mToDoRecyclerAdapter = new ToDoRecyclerAdapter(this, new ArrayList<ToDo>(), colors);

        mToDoRecyclerAdapter.addActionCallback(new ToDoRecyclerAdapter.ActionCallback() {
            @Override
            public void onLongClickListener(ToDo toDo) {
                Intent intent = new Intent(MainActivity.this, UpdateToDoActivity.class);

                intent.putExtra(UpdateToDoActivity.EXTRA_TODO_ID, toDo.getId());

                startActivityForResult(intent, RC_UPDATE_TODO);
            }
        });
        mToDosRecyclerView.setAdapter(mToDoRecyclerAdapter);

        mAddToDoFloatingActionButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(MainActivity.this, CreateToDoActivity.class);
                startActivityForResult(intent, RC_CREATE_TODO);
            }
        });

        loadToDos();
    }

    private void loadToDos() {
        mToDoRecyclerAdapter.updateData(mToDoDAO.getToDos());
    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        if (requestCode == RC_CREATE_TODO && resultCode == RESULT_OK) {
            loadToDos();
        } else if (requestCode == RC_UPDATE_TODO && resultCode == RESULT_OK) {
            loadToDos();
        }
    }
}
