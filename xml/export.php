<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit();
}

require_once "../config/database.php";

$sql = "SELECT * FROM students ORDER BY id DESC";
$result = $conn->query($sql);

$xml = new DOMDocument("1.0", "UTF-8");
$xml->formatOutput = true;

$root = $xml->createElement("students");
$xml->appendChild($root);

while ($row = $result->fetch_assoc()) {
    $student = $xml->createElement("student");

    foreach ($row as $key => $value) {
        $element = $xml->createElement($key);
        $element->appendChild($xml->createTextNode((string)$value));
        $student->appendChild($element);
    }

    $root->appendChild($student);
}

$file = __DIR__ . "/students.xml";

if ($xml->save($file)) {
    header("Location: display.php?exported=1");
    exit();
} else {
    die("Unable to create XML file. Check folder permissions.");
}
?>
