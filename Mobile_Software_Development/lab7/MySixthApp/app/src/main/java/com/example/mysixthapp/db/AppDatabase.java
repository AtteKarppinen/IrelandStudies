package com.example.mysixthapp.db;

import android.arch.persistence.room.Database;
import android.arch.persistence.room.RoomDatabase;

import com.example.mysixthapp.models.ToDo;


@Database(entities = {ToDo.class}, version = 1)

public abstract class AppDatabase extends RoomDatabase {
    public abstract ToDoDAO getToDoDAO();
}
