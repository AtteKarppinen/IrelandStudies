package com.example.mysixthapp.db;

import android.arch.persistence.room.Dao;
import android.arch.persistence.room.Delete;
import android.arch.persistence.room.Insert;
import android.arch.persistence.room.Query;
import android.arch.persistence.room.Update;

import com.example.mysixthapp.models.ToDo;

import java.util.List;

@Dao
public interface ToDoDAO {

    @Insert
    public void insert(ToDo... toDos);

    @Update
    public void update(ToDo... toDos);

    @Delete
    public void delete(ToDo... toDo);

    @Query("SELECT * FROM todo")
    public List<ToDo> getToDos();

    @Query("SELECT * FROM todo WHERE id = :number")
    public ToDo getToDoWithId(int number);
}
