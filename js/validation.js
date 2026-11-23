function validateStudentForm() {

    const registerNumber = document.getElementById("register_number").value.trim();
    const studentName = document.getElementById("student_name").value.trim();
    const course = document.getElementById("course").value.trim();
    const semester = document.getElementById("semester").value;
    const email = document.getElementById("email").value.trim();
    const contact = document.getElementById("contact_number").value.trim();

    if (!registerNumber || !studentName || !course ||
        !semester || !email || !contact) {
        alert("Please fill all fields.");
        return false;
    }

    if (!/^[A-Za-z ]+$/.test(studentName)) {
        alert("Student name should contain only letters.");
        return false;
    }

    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        alert("Please enter a valid email address.");
        return false;
    }

    if (!/^[0-9]{10,15}$/.test(contact)) {
        alert("Contact number must contain 10 to 15 digits.");
        return false;
    }

    if (Number(semester) < 1 || Number(semester) > 8) {
        alert("Semester must be between 1 and 8.");
        return false;
    }

    return true;
}
