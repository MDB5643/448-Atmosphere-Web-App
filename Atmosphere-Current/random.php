<?php

//Written by Jacob Long and Manan Shah
//Debugged by Nick Baker and Matt Bailey

// $myname = "you'r";
// $myname =str_replace("'","\'",$myname);
// //$sql = "INSERT INTO users(Name) Values('$myname')";
// //$stmt = $conn->prepare($sql);
// //$stmt->execute();



$conn = new mysqli("mysql.eecs.ku.edu", "nrbaker", "nickb12", "nrbaker");//get the information of the database that is being used.
/* check connection */
if ($conn->connect_errno)
{
    printf("Connect failed: %s\n", $conn->connect_error);
    exit();
}
// $name = $_POST["mySearch"];//store variables from  myUI.html
// $slashName = addslashes($name);

// $queryBarName = "SELECT Bar_Name, Bar_Description, Bar_Rating, LineLength, FormalAttire, CasualAttire, Cover, PartyAmbience, LaidBackAmbience FROM BarList WHERE Bar_Name='$slashName'";
// $queryBarDes = "SELECT Bar_Description FROM BarList WHERE Bar_Name='$slashName'";
// $queryBarImage = "SELECT Bar_Image FROM BarList WHERE Bar_Name='$slashName'";
$queryRandomBar = "SELECT * FROM BarList order by RAND() LIMIT 27";

if ($resultBarName = $conn->query($queryRandomBar))
{

  $row = $resultBarName->fetch_assoc();

  $count = 0;
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

  header("Location:https://people.eecs.ku.edu/~nrbaker/448Project/MapPageScript.html?name=$theName&des=$theDes&BR=$theRate&ll=$theLength&form1=$theFormal&cas=$theCasual&cov=$theCover&part=$theParty&laid=$theLaidBack&im=$theImage");
//free up the memory
$resultBarName->free();

}


/* close connection */
$conn->close();
?>
