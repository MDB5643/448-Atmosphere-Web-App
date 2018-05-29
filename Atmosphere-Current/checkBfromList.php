<?php
//Written by Nick Baker
//Debugged by Jacob Long
//Tested by Matt Bailey and Manan Shah

$conn = new mysqli("mysql.eecs.ku.edu", "nrbaker", "nickb12", "nrbaker");//get the information of the database that is being used.
/* check connection */

if ($conn->connect_errno)
{
    printf("Connect failed: %s\n", $conn->connect_error);
    exit();
}
//isset($_POST['test'])
if(isset($_POST["bar"]))
{
  $barSelect = $_POST["bar"];

}
$slashName = addslashes($barSelect);

$queryBarName = "SELECT Bar_Name, Bar_Description, Bar_Rating, LineLength, FormalAttire, CasualAttire, Cover, PartyAmbience, LaidBackAmbience, Bar_Image FROM BarList WHERE Bar_Name='$slashName'";
if ($resultBarName = $conn->query($queryBarName))
{

  $row = $resultBarName->fetch_assoc();
  //fetch the bar Name from the database
  $theName = $row["Bar_Name"];
  $theDes = $row["Bar_Description"];
  $theRate = $row["Bar_Rating"];
  $theLength = $row["LineLength"];
  $theFormal = $row["FormalAttire"];
  $theCasual = $row["CasualAttire"];
  $theCover = $row["Cover"];
  $theParty = $row["PartyAmbience"];
  $theLaidBack = $row["LaidBackAmbience"];
  $theImage = $row["Bar_Image"];
    /*fetch associative array */

    //checks for empty string case in the text field.

    //if the variable count equals the string length of the database Bar name, execute to the next html page

  header("Location:https://people.eecs.ku.edu/~nrbaker/448Project/attributeMapPage.html?name=$theName&des=$theDes&BR=$theRate&ll=$theLength&form1=$theFormal&cas=$theCasual&cov=$theCover&part=$theParty&laid=$theLaidBack&im=$theImage");

    //else if a valid non-empty name could not be found on the database, run this code.

//free up the memory
$resultBarName->free();

}


/* close connection */
$conn->close();
?>
