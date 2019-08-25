package com.example.sdcard;

import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.PrintWriter;

import android.os.Environment;
import android.util.Log;

public class MainActivity extends AppCompatActivity {

    private static final String TAG = "#MYIO";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        checkExternalMedia();
        writeToSDFile();
        readRaw();
    }

    private void checkExternalMedia() {
        boolean mExternalStorageAvailable = false;
        boolean mExternalStorageWriteable = false;

        String state = Environment.getExternalStorageState();

        if (Environment.MEDIA_MOUNTED.equals(state)) {
            mExternalStorageAvailable = mExternalStorageWriteable = true;
        } else if (Environment.MEDIA_MOUNTED_READ_ONLY.equals(state)) {
            mExternalStorageAvailable = true;
        }
        String message = "\t\tEXTERNAL MEDIA:";
        Log.d(TAG, message);

        message = "\t\treadable = " + mExternalStorageAvailable;

        Log.d(TAG, message);
        message = "\t\twritable = " + mExternalStorageWriteable;
        Log.d(TAG, message);
    }


    private void writeToSDFile() {


        File root0 = android.os.Environment.getExternalStorageDirectory();

        File root = this.getExternalFilesDir(Environment.DIRECTORY_DOCUMENTS);

        String message = "\t\tEXTERNAL FILE SYSTEM ROOT DIRECTORY:";
        Log.d(TAG, message);

        message = "\t\t" + root0.toString();
        Log.d(TAG, message);

        message = "\t\tEXTERNAL APP DATA ROOT DIRECTORY:";
        Log.d(TAG, message);

        message = "\t\t" + root.toString();
        Log.d(TAG, message);


        File dir = new File(root.getAbsolutePath() + "/download");
        dir.mkdirs();
        File file = new File(dir, "myData.txt");

        try {
            FileOutputStream f = new FileOutputStream(file);
            PrintWriter pw = new PrintWriter(f);
            pw.println("The bicycles go by in twos and threes");
            pw.println("There's a dance in Billy Brennan's barn to-night");
            pw.flush();
            pw.close();
            f.close();
        } catch (FileNotFoundException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
        }
        message = "\t\tFILE WRITTEN TO:";
        Log.d(TAG, message);

        message = "\t\t" + file.toString();
        Log.d(TAG, message);
    }


    private void readRaw() {
        String message = "\t\tDATA READ FROM res/raw/textfile.txt:";
        Log.d(TAG, message);
        InputStream is = this.getResources().openRawResource(R.raw.textfile);
        InputStreamReader isr = new InputStreamReader(is);
        BufferedReader br = new BufferedReader(isr, 8192);    // 2nd arg is buffer size

        try {
            String test;
            while (true) {
                test = br.readLine();
                if (test == null) break;
                message = "\t\t" + test;
                Log.d(TAG, message);
            }
            isr.close();
            is.close();
            br.close();
        } catch (IOException e) {
            e.printStackTrace();
        }
        message = "\t\tThat's All Folks!";
        Log.d(TAG, message);
    }
}