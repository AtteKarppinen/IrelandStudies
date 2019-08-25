public class Demo {


public static void main(String[] args){

   Button b = new Button();
   b.setOnClickListener(
   
   new View.OnClickListener()
   {
      public void onClick()
      {
         System.out.println("I was clicked!");
      }
   }
   );

   b.callOnClick();
}
} 