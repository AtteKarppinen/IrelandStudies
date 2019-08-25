package Assignment2;

import java.util.ArrayList;
import java.util.Collections;

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

		int arrSize = 1;	// TODO remove
		int driveTime;
		ArrayList<Integer> moveList = new ArrayList<Integer>();
		ArrayList<String> turnList = new ArrayList<String>();
		float distanceValue = 0;
		float colorValue = 0;
		EV3MediumRegulatedMotor servoMotor = new EV3MediumRegulatedMotor(MotorPort.A);
		EV3ColorSensor lSensor = new EV3ColorSensor(SensorPort.S3);
		EV3LargeRegulatedMotor leftMotor = new EV3LargeRegulatedMotor(MotorPort.B);
		EV3LargeRegulatedMotor rightMotor = new EV3LargeRegulatedMotor(MotorPort.C);

		// Object for handling movement
		final Movement move = new Movement(leftMotor, rightMotor);
		final Movement servo = new Movement(servoMotor);

		final Sensors sensors = new Sensors(uSensor, lSensor);

		System.out.print("Ready");
		Button.waitForAnyPress();

		// Go forward until wall is reached. Loop until white surface reached
		colorValue = sensors.getColor();

		solve:
		while (colorValue != 6) { // 6 = white

			move.forward();
			distanceValue = sensors.getDistance();

			while (distanceValue > 15) {
				distanceValue = sensors.getDistance();
				colorValue = sensors.getColor();
				if(colorValue == 6) {
					move.stop();
					driveTime = (int) move.getDriveTime();
					moveList.add(driveTime);
					break solve;
				}
			}

			move.stop();
			driveTime = (int) move.getDriveTime();
			moveList.add(driveTime);
			move.turnRight90();
			distanceValue = sensors.getDistance();

			if (distanceValue < 30) {
				move.turn180();
				turnList.add("right");
			} else {
				turnList.add("left");
			}

			colorValue = sensors.getColor();

		}

		// Start approaching block
		move.resetTimer();
		move.forward();

		while (distanceValue > 4) {
			distanceValue = sensors.getDistance();
		}

		driveTime = (int) move.getDriveTime();
		move.stop();
		moveList.add(driveTime);

		// Catch lego block
		servo.servoDown();
		move.turn180();

		// Return sequence
		// Remove null elements from arrayListss, if any
//		moveList.removeAll(Collections.singleton(null));
//		turnList.removeAll(Collections.singleton(null));
		int x = moveList.size();
		int y = turnList.size();
		int moveIndex;
		int turnIndex;
		while (x > 0) {
			moveIndex = x - 1;
			turnIndex = y - 1;
			move.forwardGivenTime(moveList.get(moveIndex));

			if (turnList.get(turnIndex) == "right") {
				move.turnRight90();
			} else if (turnList.get(turnIndex) == "left") {
				move.turnLeft90();
			}
			x--;
			y--;
		}

		move.stop();
		servo.servoUp();
		Button.waitForAnyPress();
		servoMotor.close();
		uSensor.close();
		lSensor.close();
		leftMotor.close();
		rightMotor.close();
	}

}
