package assignment;
import lejos.hardware.Button;
import lejos.hardware.lcd.LCD;
import lejos.hardware.sensor.EV3UltrasonicSensor;
import lejos.hardware.port.MotorPort;
import lejos.hardware.port.SensorPort;
import lejos.hardware.sensor.EV3GyroSensor;
import lejos.robotics.SampleProvider;
import lejos.hardware.motor.*;

public class assignment {
    
    private static final int SPEED_HIGH = 50;
    private static final int SPEED_LOW = 25;
	private static EV3UltrasonicSensor usensor = new EV3UltrasonicSensor(SensorPort.S4);
	public static void main(String[] args) {
		EV3GyroSensor gsensor = new EV3GyroSensor(SensorPort.S2);

		UnregulatedMotor leftMotor = new UnregulatedMotor(MotorPort.B);
		UnregulatedMotor rightMotor = new UnregulatedMotor(MotorPort.C);
	
		LCD.drawString("Assignment 1", 0, 0);
		Button.waitForAnyPress();
		LCD.clear();
		gsensor.reset();
		
		final SampleProvider uSample = usensor.getDistanceMode();
		final SampleProvider gSample = gsensor.getAngleMode();
		float distanceValue = 0;
		int angleValue;
		float [] uSamples = new float[uSample.sampleSize()];
		float [] gSamples = new float[gSample.sampleSize()];
			
		uSample.fetchSample(uSamples, 0);
		distanceValue = (float)uSamples[0] * 100;
		gSample.fetchSample(gSamples, 0);
		angleValue = (int)gSamples[0];
		
		leftMotor.forward();
		rightMotor.forward();
		leftMotor.setPower(SPEED_HIGH);
        rightMotor.setPower(SPEED_HIGH);
        
        int adjustedSpeed = SPEED_HIGH;
		
		while(distanceValue > 25) {
			uSample.fetchSample(uSamples, 0);
            distanceValue = (float)uSamples[0] * 100;

            // Test wether robot is going straight and fix if needed
            gSample.fetchSample(gSamples, 0);
			angleValue = (int)gSamples[0];
            if (angleValue < 0) {
                if (adjustedSpeed >= 60) {
					// If going too fast, reset speed and focus on the other motor
					adjustedSpeed = SPEED_HIGH + 2;
					leftMotor.setPower(adjustedSpeed);
				}
				else {
					adjustedSpeed =+ 2;
					rightMotor.setPower(adjustedSpeed);
				}
            }
            else if (angleValue > 0) {
                if (adjustedSpeed >= 60) {
					// If going too fast, reset speed and focus on the other motor
					adjustedSpeed = SPEED_HIGH + 2;
					rightMotor.setPower(adjustedSpeed);
				}
				else {
					adjustedSpeed += 2;
					leftMotor.setPower(adjustedSpeed);
				}
			}
			else {
				adjustedSpeed = SPEED_HIGH;
			}
		}
		
		leftMotor.stop();
		rightMotor.stop();
		
		leftMotor.backward();
		rightMotor.forward();
		leftMotor.setPower(SPEED_LOW);
		rightMotor.setPower(SPEED_LOW);
		
		while(angleValue < 180) {
			gSample.fetchSample(gSamples, 0);
			angleValue = Math.abs((int)gSamples[0]);
		}

		leftMotor.close();
		rightMotor.close();
		gsensor.close();
		
	}

}


