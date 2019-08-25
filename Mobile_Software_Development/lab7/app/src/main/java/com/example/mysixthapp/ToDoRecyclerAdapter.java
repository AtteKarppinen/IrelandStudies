package com.example.mysixthapp;

import android.content.Context;
import android.graphics.drawable.GradientDrawable;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import com.example.mysixthapp.models.ToDo;

import java.util.List;


public class ToDoRecyclerAdapter extends RecyclerView.Adapter<ToDoRecyclerAdapter.ViewHolder> {

    //Interface for callbacks
    interface ActionCallback {
        void onLongClickListener(ToDo toDo);
    }

    private int[] colors;
    private Context context;
    private List<ToDo> toDoList;
    private ActionCallback mActionCallbacks;

    ToDoRecyclerAdapter(Context context, List<ToDo> contactList, int[] colors) {
        this.context = context;
        this.toDoList = toDoList;
        this.colors = colors;
    }

    @Override
    public ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(context).inflate(R.layout.todo_row, parent, false);
        return new ViewHolder(view);
    }

    @Override
    public void onBindViewHolder(ViewHolder holder, int position) {
        holder.bindData(position);
    }

    @Override
    public int getItemCount() {
        return toDoList.size();
    }

    void updateData(List<ToDo> toDos) {
        this.toDoList = toDos;
        notifyDataSetChanged();
    }

    //View Holder
    class ViewHolder extends RecyclerView.ViewHolder implements View.OnLongClickListener {
        private TextView mSummaryTextView;
        private TextView mCategoryTextView;
        private GradientDrawable mBackground;

        ViewHolder(View itemView) {
            super(itemView);

            itemView.setOnLongClickListener(this);
            mSummaryTextView = itemView.findViewById(R.id.label);
            mCategoryTextView = itemView.findViewById(R.id.cat);
            mBackground = (GradientDrawable) mCategoryTextView.getBackground();
        }

        void bindData(int position) {
            ToDo toDo = toDoList.get(position);

            String summary = toDo.getSummary();
            mSummaryTextView.setText(summary);

            String category = toDo.getCategory();
            if (category.equalsIgnoreCase("College")) {
                mBackground.setColor(colors[0]);
                mCategoryTextView.setText("C");
            } else if (category.equalsIgnoreCase("Home")) {
                mBackground.setColor(colors[1]);
                mCategoryTextView.setText("H");
            } else if (category.equalsIgnoreCase("Social")) {
                mBackground.setColor(colors[2]);
                mCategoryTextView.setText("S");
            } else {
                mBackground.setColor(colors[3]);
                mCategoryTextView.setText("W");
            }
        }

        @Override
        public boolean onLongClick(View v) {
            if (mActionCallbacks != null) {
                mActionCallbacks.onLongClickListener(toDoList.get(getAdapterPosition()));
            }
            return true;
        }
    }

    void addActionCallback(ActionCallback actionCallbacks) {
        mActionCallbacks = actionCallbacks;
    }
}
