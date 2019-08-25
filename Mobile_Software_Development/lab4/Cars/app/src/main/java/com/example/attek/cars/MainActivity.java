package com.example.attek.cars;

import android.content.Context;
import android.content.res.Resources;
import android.graphics.Color;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.Gravity;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.BaseAdapter;
import android.widget.GridView;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import java.lang.reflect.Array;
import java.math.MathContext;
import java.util.Arrays;

public class MainActivity extends AppCompatActivity {

    private GridView gridView;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        gridView = findViewById(R.id.gridView);
        final MyAdapter myAdapter = new MyAdapter(this);
        gridView.setAdapter(myAdapter);

        gridView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                Toast.makeText(view.getContext(), "I love "  + myAdapter.getItem(position).toString(), Toast.LENGTH_LONG).show();
            }
        });

    }
}

class MyAdapter extends BaseAdapter {

//  Works as long as images match array
    private Integer[] images = {
            R.drawable.audi, R.drawable.chevrolet, R.drawable.ferrari,
            R.drawable.fiat, R.drawable.land_rover, R.drawable.renault,
            R.drawable.skoda, R.drawable.alfa_romeo, R.drawable.lexus,
            R.drawable.bmw, R.drawable.citroen, R.drawable.honda,
            R.drawable.jaguar, R.drawable.mercedes, R.drawable.volkswagen,
            R.drawable.toyota, R.drawable.vauxhall
    };

    private String[] carArray = {"Audi", "Chevrolet", "Ferrari", "Fiat", "Land Rover",
                                 "Renault", "Skoda", "Alfa Romeo", "Lexus", "BMW",
                                 "Citroen", "Honda", "Jaguar", "Mercedes",
                                 "Volkswagen", "Toyota", "Vauxhall"};
    private Context mContext;
    public MyAdapter(Context c) {
        mContext = c;
    }

    @Override
    public int getCount() {
        return carArray.length;
    }

    @Override
    public Object getItem(int position) {
        return carArray[position];
    }

    @Override
    public long getItemId(int position) {
        return 0;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
//        Next task can be also accomplished using TextView, but there are some problems;
//        Text will still be displayed on top of images and pressing image doesn't indicate
//        in any way it has been pressed (click effect). Toast works both ways.

//        TextView textView;
        ImageView imageView;

        if (convertView == null) {
            int space = mContext.getResources().getDimensionPixelSize(R.dimen.pad_size);
//            float txtSize = mContext.getResources().getDimensionPixelSize(R.dimen.text_size);

//            textView = new TextView(mContext);
//            textView.setLayoutParams(new GridView.LayoutParams(230, 230));

//            textView.setPadding(space, space, space, space);
//            textView.setTextSize(txtSize);
//            textView.setAllCaps(true);
//            textView.setTextColor(Color.RED);

//            textView.setText(getItem(position).toString());

            imageView = new ImageView(mContext);
            imageView.setLayoutParams(new GridView.LayoutParams(230, 230));
            imageView.setScaleType(ImageView.ScaleType.CENTER_CROP);
            imageView.setPadding(space, space, space, space);
        }
        else {
//            textView = (TextView) convertView;
            imageView = (ImageView) convertView;
        }
//        textView.setBackgroundResource(images[position]);
//        return textView;
        imageView.setImageResource(images[position]);
        return imageView;
    }
}