class View {

OnClickListener mOnClickListener;

public void setOnClickListener( OnClickListener l){

   mOnClickListener = l;

}

public void callOnClick()
{

   mOnClickListener.onClick();
}

interface OnClickListener {

   public void onClick();

}


}