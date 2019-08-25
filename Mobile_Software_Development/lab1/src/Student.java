import java.util.Random;

public class Student extends Person implements PublishDetails{

    private static int studentId;
    private String courseCode;
    private int uniqueId = 0;

    public Student(String name, char gender, int studentId, String courseCode) {
        super(name, gender);
        this.courseCode = courseCode;
    }

    public Student(String name, char gender, String courseCode) {
        super(name, gender);
        this.courseCode = courseCode;
        studentId = uniqueId++;
    }

    @Override
    public String confirmDetails() {
        // Fair enough?
        return null;
    }

    @Override
    public String getCourseCode() {
        return courseCode;
    }

    @Override
    public String toString() {
        return "Student{" +
                "studentId='" + studentId + '\'' +
                ", courseCode='" + courseCode + '\'' +
                ", name='" + name + '\'' +
                ", gender=" + gender +
                '}';
    }
}
