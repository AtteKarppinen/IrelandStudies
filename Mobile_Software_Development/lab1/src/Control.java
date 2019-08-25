public class Control {
    public static void main(String[] args) {
        Person person1 = new Person("John Doe", 'M');
        Person person2 = new Person("Jane Doe", 'F');
        Student student1 = new Student("Student", 'M', 1234, "CMPU 0000");
        Student student2 = new Student("Student", 'M', "CMPU 0000");

        System.out.println(person1.toString());
        System.out.println(person2.toString());
        System.out.println(student1.toString());
        System.out.println(student2.toString());
    }
}
