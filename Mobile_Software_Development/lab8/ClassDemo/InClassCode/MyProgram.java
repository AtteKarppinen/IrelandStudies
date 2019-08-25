	public class MyProgram{


		public static void main(String[] args){

			MyThread t = new MyThread();
			t.start();

			for(int i = 0; i < 100; i++){
				System.out.println("Main!");
			}
		}

	}