<?php

//Written by Nick Baker
//Debugged by Matt Bailey
//Tested by Manan Shah and Jacob Long

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
$name = $_POST["mySearch"];//store variables from  myUI.html
$slashName = addslashes($name);

$queryBarName = "SELECT Bar_Name, Bar_Description, Bar_Rating, LineLength, FormalAttire, CasualAttire, Cover, PartyAmbience, LaidBackAmbience FROM BarList WHERE Bar_Name='$slashName'";
$queryBarDes = "SELECT Bar_Description FROM BarList WHERE Bar_Name='$slashName'";
$queryBarImage = "SELECT Bar_Image FROM BarList WHERE Bar_Name='$slashName'";

if ($resultBarName = $conn->query($queryBarName))
{
  if($resultBarImage = $conn->query($queryBarImage))
  {
    $row2 = $resultBarImage->fetch_assoc();
  }


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
  $theImage = $row2["Bar_Image"];
    /*fetch associative array */
    for($i=0; $i<strlen($name); $i++)
    {
      //for loop that checks every index from the user input to the database name
      if(($theName[$i] == $name[$i]) || (strtolower($theName[$i] == $theName[$i])))
      {
          $count = $count +1;

      }
    }

    //checks for empty string case in the text field.
    if(strlen($name) <= 0)
    {
      echo "<script>
      alert('Field is empty! Please put in a valid non-empty Bar Name.');
      window.location.href='https://people.eecs.ku.edu/~nrbaker/448Project/myUI.html';
      </script>";//redirect to home page
    }
    //if the variable count equals the string length of the database Bar name, execute to the next html page
    else if($count == strlen($theName))
    {
      header("Location:https://people.eecs.ku.edu/~nrbaker/448Project/MapPageScript.html?name=$theName&des=$theDes&BR=$theRate&ll=$theLength&form1=$theFormal&cas=$theCasual&cov=$theCover&part=$theParty&laid=$theLaidBack&im=$theImage");
    }
    //else if a valid non-empty name could not be found on the database, run this code.
    else
    {
      // echo $queryBarName;
      // echo $queryBarImage;
       echo "<script>
 alert('Bar Name or Attribute could not be found!');
 window.location.href='https://people.eecs.ku.edu/~nrbaker/448Project/myUI.html';
 </script>";
  }
//free up the memory
$resultBarName->free();
$resultBarImage->free();

}


/* close connection */
$conn->close();
?>
