package Assignment2;

import lejos.hardware.Button;
import lejos.hardware.lcd.LCD;
import lejos.hardware.sensor.EV3UltrasonicSensor;
import lejos.hardware.port.MotorPort;
import lejos.hardware.port.SensorPort;
import lejos.hardware.sensor.EV3GyroSensor;
import lejos.hardware.sensor.EV3ColorSensor;
import lejos.hardware.sensor.EV3TouchSensor;
import lejos.robotics.RegulatedMotor;
import lejos.robotics.SampleProvider;
import lejos.hardware.device.tetrix.*;
import lejos.utility.Delay;
import lejos.hardware.motor.*;


public class Assignment {

	
	private static EV3UltrasonicSensor uSensor = new EV3UltrasonicSensor(SensorPort.S4);

	public static void main(String[] args) {

		float distanceValue = 0;
		float colorValue = 0;
		EV3MediumRegulatedMotor servoMotor = new EV3MediumRegulatedMotor(MotorPort.A);
		EV3ColorSensor lSensor = new EV3ColorSensor(SensorPort.S3);
		EV3LargeRegulatedMotor leftMotor = new EV3LargeRegulatedMotor(MotorPort.B);
		EV3LargeRegulatedMotor rightMotor = new EV3LargeRegulatedMotor(MotorPort.C);
		

		//Object for handling movement		
		final Movement move = new Movement(leftMotor, rightMotor);  
		final Movement servo = new Movement(servoMotor);
		
		final Sensors sensors = new Sensors(uSensor, lSensor);


		System.out.print("Ready");
		Button.waitForAnyPress();

		
		//Go forward until wall is reached
		move.forward();		
		distanceValue = sensors.getDistance();
		
		while(distanceValue > 4) {
			distanceValue = sensors.getDistance();	
	}	
		
		
		move.stop();
		servo.servoDown();
		move.turnLeft90();
		move.turnRight90();
		
		
		servo.servoUp();
		servoMotor.close();
		uSensor.close();
		lSensor.close();
		leftMotor.close();
		rightMotor.close();
	}
	
//	public void closeSensors() {
//		servoMotor.close();
//		uSensor.close();
//		lSensor.close();
//		leftMotor.close();
//		rightMotor.close();
//	}
	
}
