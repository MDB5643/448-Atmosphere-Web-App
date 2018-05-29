<?php

//Written by Jacob Long
//Debugged by Nick Baker


//storing variables from another html file.
$BarName = $_POST["Bar_Name"];
$BarDes = $_POST["Bar_Description"];
$barRate = $_POST["Bar_Rating"];
$Line = $_POST["LineLength"];
$formal = $_POST["FormalAttire"];
$casual = $_POST["CasualAttire"];
$cov = $_POST["Cover"];
$partyAm = $_POST["PartyAmbience"];
$laidback = $_POST["LaidBackAmbience"];
// $passCode = $_POST["Password"];
// $firstName = $_POST["First_Name"];
// $lastName = $_POST["Last_Name"];
// $url = $_POST["url"];

//make an instance of a new variable called conn
$conn = new mysqli("mysql.eecs.ku.edu", "nrbaker", "nickb12", "nrbaker");

//checks if the connection is available or not.
if($conn->connect_errno)
{
	printf("Connection failed: %s\n", $conn ->connect_error);//print out the connection has failed.
	exit();//exit the function.
}


//insert variables into the Users table and set them equal to the respective columns.
$insert1 = "INSERT INTO BarList (Bar_Name, Bar_Description, Bar_Rating, LineLength, FormalAttire, CasualAttire, Cover, PartyAmbience, LaidBackAmbience)
VALUES ('$BarName', '$BarDes', '$barRate', '$Line', '$formal', '$casual', '$cov', '$partyAm', '$laidback')";

// $insert2 = "INSERT INTO Image (Username, Image_URL)
// VALUES ('$Username' , '$url')";


if($conn->query($insert1)== TRUE)
{
	echo "New record created successfully!";//print out success message if both querys were made and in the database.
}
$conn->close();


?>
