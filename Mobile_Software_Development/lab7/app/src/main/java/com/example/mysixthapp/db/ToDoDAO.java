package com.example.mysixthapp.db;

import android.arch.persistence.room.Dao;
import android.arch.persistence.room.Delete;
import android.arch.persistence.room.Insert;
import android.arch.persistence.room.Query;
import android.arch.persistence.room.Update;

import com.example.mysixthapp.models.ToDo;

import java.util.List;


public interface ToDoDAO {

    public void insert(ToDo... toDos);

    public void update(ToDo... toDos);

    public void delete(ToDo... toDo);

    public List<ToDo> getToDos();

    public ToDo getToDoWithId(int number);
}
