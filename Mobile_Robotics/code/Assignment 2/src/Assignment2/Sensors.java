package Assignment2;
import lejos.hardware.sensor.EV3UltrasonicSensor;
import lejos.robotics.SampleProvider;
import lejos.hardware.port.SensorPort;
import lejos.hardware.sensor.EV3ColorSensor;

public class Sensors {

	EV3UltrasonicSensor ultraSonicSensor;
	EV3ColorSensor colorSensor;
	final SampleProvider uSample;
	final SampleProvider cSample;

	float [] cSamples;
	float [] uSamples;
	
	
	public Sensors(EV3UltrasonicSensor ultraSonicSensor, EV3ColorSensor colorSensor) {
		this.ultraSonicSensor = ultraSonicSensor;
		uSample = ultraSonicSensor.getDistanceMode();
		uSamples = new float[uSample.sampleSize()];
		
		this.colorSensor = colorSensor;
		cSample = colorSensor.getColorIDMode();
		cSamples = new float[cSample.sampleSize()];
	}
	
	public float getDistance() {
		float distance;		
		uSample.fetchSample(uSamples, 0);
		distance = uSamples[0] * 100;
		return distance;
	}
	
	public float getColor() {
		float color;
		cSample.fetchSample(cSamples, 0);
		color = cSamples[0];
		return color;
	}
}
