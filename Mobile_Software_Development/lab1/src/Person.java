public class Person {
    public String name;
    public char gender;

    public Person(String name, char gender) {
        this.name = name;
        this.gender = gender;
    }

    @Override
    public String toString() {
        return "Person{" +
                "name='" + name + '\'' +
                ", gender=" + gender +
                '}';
    }

    public String getName() {
        return name;
    }

    public Character getGender() {
        return gender;
    }
}
