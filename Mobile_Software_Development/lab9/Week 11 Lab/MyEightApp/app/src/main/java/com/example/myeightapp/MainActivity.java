package com.example.myeightapp;

import android.Manifest;
import android.content.Context;
import android.os.Environment;
import android.support.annotation.NonNull;
import android.content.pm.PackageManager;
import android.os.Bundle;
import android.support.v4.app.ActivityCompat;
import android.support.v4.content.ContextCompat;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;

import java.io.*;

public class MainActivity extends AppCompatActivity {

    private String TAG = "#MYIO";

    private String CONTENT = "cached data...\n";
    private String LYRIC = "I see a little silhouetto of a man\nScaramouche, Scaramouche, will you do the Fandango\nThunderbolt and lightning, very, very fright'ning me\n(Galileo) Galileo, (Galileo) Galileo, Galileo figaro magnifico\n";
    private String POEM = "Ah, distinctly I remember it was in the bleak December\nAnd each separate dying ember wrought its ghost upon the floor.\n";
    private String QUOTE = "HAL: Affirmative, Dave. I read you.\nDave: Open the pod bay doors, HAL.\nHAL: I'm sorry, Dave. I'm afraid I can't do that.\nDave: I don't know what you're talking about, HAL.\nHAL: I know that you and Frank were planning to disconnect me, and I'm afraid that's something I cannot allow to happen.\n";

    private static final int REQUEST_CODE = 1;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

         writeToInternalPrivate();
         writeToCache();
         writeToPrivateExternal();
         getPermission();
    }

    public void writeToInternalPrivate() {
        // Check the internal location
        File file = new File(getFilesDir(), "Poem");
        Log.wtf("LOCATIONMESSAGE", file.toString());
        writeOutput(file, POEM);
    }

    public void writeToCache() {
        try {
            File subdir = new File(getCacheDir(), "/subDir");
            subdir.mkdirs();

            File file = new File(subdir, "Content");
            Log.wtf("LOCATIONMESSAGE", file.toString());
            writeOutput(file, CONTENT);
        }
        catch (Exception e) {
            e.printStackTrace();
        }
    }

    public void writeToPrivateExternal() {
        try {
            File file = new File(getExternalFilesDir(Environment.DIRECTORY_DOCUMENTS), "/Lyrics");
            Log.wtf("LOCATIONMESSAGE", file.toString());
            writeOutput(file, LYRIC);
            readInput(file);
        }
        catch (Exception e) {
            e.printStackTrace();
        }
    }

    public void writeToPublicSD() {
        // Check that sd is mounted and writable
        if (Environment.MEDIA_MOUNTED.equals(Environment.getExternalStorageState())) {
            try {
                File file = new File(Environment.getExternalStoragePublicDirectory
                        (Environment.DIRECTORY_DOWNLOADS),"/Quote");
                Log.wtf("LOCATIONMESSAGE", file.toString());
                writeOutput(file, QUOTE);
                readInput(file);
            }
            catch (Exception e) {
                e.printStackTrace();
            }
        }
    }


    private void writeOutput(File file, String data) {
        try {
            FileOutputStream stream = new FileOutputStream(file);
            OutputStreamWriter writer = new OutputStreamWriter(stream);
            BufferedWriter buf = new BufferedWriter(writer);

            buf.write(data);
            buf.flush();
            buf.close();

            writer.close();
            stream.close();
        } catch (FileNotFoundException e) {
            Log.e(TAG, e.getMessage());
        } catch (IOException e) {
            Log.e(TAG, e.getMessage());
        }
    }

    private String readInput(File f) {

        StringBuilder temp = new StringBuilder();
        try {
            FileInputStream fs = new FileInputStream(f);
            if (fs != null) {
                InputStreamReader reader = new InputStreamReader(fs);
                BufferedReader buf = new BufferedReader(reader);

                String line = buf.readLine();
                while (line != null) {
                    temp.append(line + "\n");
                    line = buf.readLine();
                }
                return temp.toString();
            }
            else{
                Log.e(TAG, "InputStream is null");
            }
        } catch (IOException e) {
            Log.e(TAG, e.getMessage());
        }
        return null;
    }

    public void getPermission() {

        int permission = ContextCompat.checkSelfPermission(this, Manifest.permission.WRITE_EXTERNAL_STORAGE);

        if (permission != PackageManager.PERMISSION_GRANTED) {
            ActivityCompat.requestPermissions(this, new String[]{Manifest.permission.WRITE_EXTERNAL_STORAGE}, REQUEST_CODE);
        }
    }

    public void onRequestPermissionsResult(int code, @NonNull String[] perms, @NonNull int[] results) {
        super.onRequestPermissionsResult(code, perms, results);

        if (code == REQUEST_CODE) {

            int temp = results.length;
            if (temp > 0 && results[0] == PackageManager.PERMISSION_GRANTED) {
                Log.d(TAG, "Write Permission Granted!");
                writeToPublicSD();
            } else {
                Log.d(TAG, "Write Permission Denied!");
            }
        }
    }
}