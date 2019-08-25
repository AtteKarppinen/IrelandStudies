package Assignment2;
import lejos.robotics.RegulatedMotor;
import lejos.robotics.RegulatedMotorListener;
import lejos.hardware.motor.*;
import lejos.utility.Delay;



public class Movement {
	
	EV3LargeRegulatedMotor leftMotor, rightMotor;
	EV3MediumRegulatedMotor servo;
	RegulatedMotor[] motorSync;
	long difference;
	int servoAngle = 150;
	final RegulatedMotorListener listener = new RegulatedMotorListener() {
		long startTime, stopTime;
		@Override
		public void rotationStarted(final RegulatedMotor motor, final int tachoCount, final boolean stalled, final long timeStamp) {
			System.out.println("Started");
			startTime = timeStamp;
		}
		
		@Override
		public void rotationStopped(final RegulatedMotor motor, final int tachoCount, final boolean stalled, final long timeStamp) {			
			stopTime = timeStamp;
			difference = (stopTime - startTime);
			System.out.println(difference);
			
		}
	};
	
	private int speedUnit = 360;

	public Movement(EV3LargeRegulatedMotor leftMotor, EV3LargeRegulatedMotor rightMotor) {
		this.leftMotor = leftMotor;
		this.rightMotor = rightMotor;
		motorSync = new RegulatedMotor[] {rightMotor};
		

	}
	
	public Movement(EV3MediumRegulatedMotor servo) {
		this.servo = servo;
	}
	
	public void forward() {
		leftMotor.addListener(listener);
		leftMotor.setSpeed(speedUnit);
		rightMotor.setSpeed(speedUnit);
		leftMotor.synchronizeWith(motorSync);
		leftMotor.startSynchronization();
		leftMotor.forward();
		rightMotor.forward();
		leftMotor.endSynchronization();		
	}
	
	public void forwardGivenTime(int time) {
		leftMotor.addListener(listener);
		leftMotor.setSpeed(speedUnit);
		rightMotor.setSpeed(speedUnit);
		leftMotor.synchronizeWith(motorSync);
		leftMotor.startSynchronization();
		leftMotor.forward();
		rightMotor.forward();
		leftMotor.endSynchronization();	
		Delay.msDelay(time);
		stop();
	}
	
	public void moveGivenUnits(int movementUnit, int movementMultiplier) {
		leftMotor.setSpeed(speedUnit);
		rightMotor.setSpeed(speedUnit);
		leftMotor.synchronizeWith(motorSync);
		leftMotor.startSynchronization();
		leftMotor.rotate(movementUnit * movementMultiplier);
		rightMotor.rotate(movementUnit * movementMultiplier);
		leftMotor.endSynchronization();
		leftMotor.waitComplete();
		rightMotor.waitComplete();
	}
	
	public void turnLeft() {
		leftMotor.removeListener();
		leftMotor.setSpeed(speedUnit/2);
		rightMotor.setSpeed(speedUnit/2);
		leftMotor.synchronizeWith(motorSync);
		leftMotor.startSynchronization();
		leftMotor.stop();
		rightMotor.forward();
		leftMotor.endSynchronization();
	}
	
	public void turnLeft90() {
		leftMotor.removeListener();
		leftMotor.setSpeed(speedUnit);
		rightMotor.setSpeed(speedUnit);
		leftMotor.synchronizeWith(motorSync);
		leftMotor.startSynchronization();
		leftMotor.rotate(-180);
		rightMotor.rotate(180);
		leftMotor.endSynchronization();
		leftMotor.waitComplete();
		rightMotor.waitComplete();
	}
	
	public void turnRight() {
		leftMotor.removeListener();
		leftMotor.setSpeed(speedUnit/2);
		rightMotor.setSpeed(speedUnit/2);
		leftMotor.synchronizeWith(motorSync);
		leftMotor.startSynchronization();
		leftMotor.forward();
		rightMotor.stop();
		leftMotor.endSynchronization();
	}
	
	public void turnRight90() {
		leftMotor.removeListener();
		leftMotor.setSpeed(speedUnit);
		rightMotor.setSpeed(speedUnit);
		leftMotor.synchronizeWith(motorSync);
		leftMotor.startSynchronization();
		leftMotor.rotate(180);
		rightMotor.rotate(-180);
		leftMotor.endSynchronization();
		leftMotor.waitComplete();
		rightMotor.waitComplete();
	}
	
	public void turn180() {
		leftMotor.removeListener();
		leftMotor.setSpeed(speedUnit);
		rightMotor.setSpeed(speedUnit);
		leftMotor.synchronizeWith(motorSync);
		leftMotor.startSynchronization();
		leftMotor.rotate(360);
		rightMotor.rotate(-360);
		leftMotor.endSynchronization();
		leftMotor.waitComplete();
		rightMotor.waitComplete();
	}
	//Rotate to left around axis
	public void axisTurnLeft() {
		leftMotor.setSpeed(speedUnit/2);
		rightMotor.setSpeed(speedUnit/2);
		leftMotor.synchronizeWith(motorSync);
		leftMotor.startSynchronization();
		leftMotor.backward();
		rightMotor.forward();
		leftMotor.endSynchronization();
	}
	//Rotate to right around axis
	public void axisTurnRight() {
		leftMotor.setSpeed(speedUnit/2);
		rightMotor.setSpeed(speedUnit/2);
		leftMotor.synchronizeWith(motorSync);
		leftMotor.startSynchronization();
		leftMotor.forward();
		rightMotor.backward();
		leftMotor.endSynchronization();
	}
	
	public void backward() {
		leftMotor.setSpeed(speedUnit);
		rightMotor.setSpeed(speedUnit);
		leftMotor.synchronizeWith(motorSync);
		leftMotor.startSynchronization();
		leftMotor.backward();
		rightMotor.backward();
		leftMotor.endSynchronization();
	}
	
	public void stop() {
		leftMotor.synchronizeWith(motorSync);
		leftMotor.startSynchronization();
		leftMotor.stop();
		rightMotor.stop();
		leftMotor.endSynchronization();
	}

	public void servoUp() {
		servo.rotate(servoAngle);
	}
	
	public void servoDown() {
		servo.rotate(-servoAngle);
	}
	
	public long getDriveTime() {
		
		return difference;
	}
	
	public void resetTimer() {
		leftMotor.removeListener();
	}

}


