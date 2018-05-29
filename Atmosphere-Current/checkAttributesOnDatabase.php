<?php
//Written by Nick Baker and Jacob Long
//Debugged by Matt Bailey and Manan Shah
//Tested by Nick Baker and Matt Bailey

$conn = new mysqli("mysql.eecs.ku.edu", "nrbaker", "nickb12", "nrbaker");//get the information of the database that is being used.
/* check connection */
// $cover ='No';
// $linelength1 ='Long';
// $lineLengthOther = 'Medium';
// $formAT = 'No';
// $CasualAT = 'No';
// $partyambience = 'No';
// $laidAmb = 'No';

if ($conn->connect_errno)
{
    printf("Connect failed: %s\n", $conn->connect_error);
    exit();
}
//isset($_POST['test'])
if(isset($_POST["cov"]))
{
  $cover = 'No';

}
else
{
  $cover = 'Yes';

}
if(isset($_POST["line"]))
{
  $linelength = 'Short';

}
else
{
  $linelength = 'Long';
  $lineLengthOther = 'Medium';
}
if(isset($_POST["formatt"]))
{
  $fA = 'Yes';
}
else
{
  $fA = 'No';
}

if(isset($_POST["casatt"]))
{
  $CasualAT = 'Yes';
}
else
{
  $CasualAT = 'No';
}

if(isset($_POST["partyam"]))
{
  $partyamb = 'Yes';
}
else
{
  $partyamb = 'No';
}
//store variables from  myUI.html
if(isset($_POST["laidam"]))
{
  $laidAmb = 'Yes';
}
else
{
  $laidAmb= 'No';
}


if(!(isset($_POST["formatt"]) || isset($_POST["casatt"])))//checks to see if both ambiences are true
{

    echo "<script>
alert('Sorry you must select at least one form of Attire');
window.location.href='https://people.eecs.ku.edu/~nrbaker/448Project/AttributeCheckList.html';
</script>";
}
if(!(isset($_POST["laidam"]) || isset($_POST["partyam"])))//checks to see if both ambiences are true
{
    echo "<script>
alert('Sorry you must select at least one form of Atmosphere');
window.location.href='https://people.eecs.ku.edu/~nrbaker/448Project/AttributeCheckList.html';
</script>";
}
if(isset($_POST["formatt"]) && isset($_POST["casatt"]))//checks to see if both ambiences are true
{
    echo "<script>
alert('Sorry cannot select both Formal and Casual Attire');
window.location.href='https://people.eecs.ku.edu/~nrbaker/448Project/AttributeCheckList.html';
</script>";
}
if(isset($_POST["laidam"]) && isset($_POST["partyam"]))//checks to see if both ambiences are true
{
    echo "<script>
alert('Sorry cannot select both Party Ambience and Laid Back Ambience');
window.location.href='https://people.eecs.ku.edu/~nrbaker/448Project/AttributeCheckList.html';
</script>";
}

//if line is not selected, choose from line lengths of medium and long
if(!(isset($_POST["line"])))
{
  $queryALL= "SELECT * FROM BarList
    WHERE Cover = '$cover'
    and (LineLength = '$linelength' or LineLength = '$lineLengthOther')
    and (FormalAttire = '$fA')
    and (CasualAttire = '$CasualAT')
    and (PartyAmbience = '$partyamb')
    and (LaidBackAmbience = '$laidAmb')";
}
else // if line IS selected, find all rows related to line length being short
{
  $queryALL= "SELECT * FROM BarList
    WHERE Cover = '$cover'
    and (LineLength = '$linelength')
    and (FormalAttire = '$fA')
    and (CasualAttire = '$CasualAT')
    and (PartyAmbience = '$partyamb')
    and (LaidBackAmbience = '$laidAmb')";
}



$resultBarNames = $conn->query($queryALL);
$numRows = 0;
$num = mysql_affected_rows();
$myString= '';
    while($row = $resultBarNames->fetch_assoc())
    {
        $numRows = $numRows +1;
        $myString= $myString.$row["Bar_Name"].',';

        // echo $row["Cover"];
    }
//echo $queryALL;
if($numRows <= 0)
{
  echo "<script>
alert('Sorry No Bars have been found matching these attributes');
window.location.href='https://people.eecs.ku.edu/~nrbaker/448Project/AttributeCheckList.html';
</script>";
}
else if($numRows == 1)
{
  if(strpos($myString, ',') !== false)
  {
    $myString = str_replace(',','',$myString);
  }
  $slashName = addslashes($myString);
  $querySingleBar = "SELECT Bar_Name, Bar_Description, Bar_Rating, LineLength, FormalAttire, CasualAttire, Cover, PartyAmbience, LaidBackAmbience, Bar_Image FROM BarList WHERE Bar_Name='$slashName'";
  //echo $querySingleBar; TEST
  if ($resultSingleBar = $conn->query($querySingleBar))
  {

    $row2 = $resultSingleBar->fetch_assoc();
    //fetch the bar Name from the database
    $theName = $row2["Bar_Name"];
    $theDes = $row2["Bar_Description"];
    $theRate = $row2["Bar_Rating"];
    $theLength = $row2["LineLength"];
    $theFormal = $row2["FormalAttire"];
    $theCasual = $row2["CasualAttire"];
    $theCover = $row2["Cover"];
    $theParty = $row2["PartyAmbience"];
    $theLaidBack = $row2["LaidBackAmbience"];
    $theImage = $row2["Bar_Image"];
      /*fetch associative array */

      //checks for empty string case in the text field.

      //if the variable count equals the string length of the database Bar name, execute to the next html page

    header("Location:https://people.eecs.ku.edu/~nrbaker/448Project/attributeMapPage.html?name=$theName&des=$theDes&BR=$theRate&ll=$theLength&form1=$theFormal&cas=$theCasual&cov=$theCover&part=$theParty&laid=$theLaidBack&im=$theImage");

      //else if a valid non-empty name could not be found on the database, run this code.

  //free up the memory
  $resultSingleBar->free();

  }
}
else
{

  header("Location:https://people.eecs.ku.edu/~nrbaker/448Project/barListScript.html?myList=$myString");
}





// $queryBarDes = "SELECT Bar_Description FROM BarList WHERE Bar_Name='$name'";
// if ($resultBarName = $conn->query($queryCover))
// {
//   while ($row = mysql_fetch_assoc($resultBarName))
//   {
//        echo $row["Bar_Name"];
//   }
  //$row = $resultBarName->fetch_array();
  // for($i =0; $i<22; $i++)
  // {
  //   if($row["Bar_Name"] == )
  // }

  //fetch the bar Name from the database
  // $theName = $row["Bar_Name"];
  // $theDes = $row["Bar_Description"];
  // $theRate = $row["Bar_Rating"];
  // $theLength = $row["LineLength"];
  // $theFormal = $row["FormalAttire"];
  // $theCasual = $row["CasualAttire"];
  // $theCover = $row["Cover"];
  // $theParty = $row["PartyAmbience"];
  // $theLaidBack = $row["LaidBackAmbience"];
    /*fetch associative array */
  //   for($i=0; $i<strlen($name); $i++)
  //   {
  //     if(($theName[$i] == $name[$i]) || (strtolower($theName[$i] == $theName[$i])))
  //     {
  //        header("Location:https://people.eecs.ku.edu/~nrbaker/448Project/MapPageScript.html?name=$theName&des=$theDes&BR=$theRate&ll=$theLength&form1=$theFormal&cas=$theCasual&cov=$theCover&part=$theParty&laid=$theLaidBack");
  //     }
  //     else
  //     {
  //        echo "<script>
  //  alert('Bar Name or Attribute could not be found!');
  //  window.location.href='https://people.eecs.ku.edu/~nrbaker/448Project/myUI.html';
  //  </script>";
  //       break;
  //     }
  //   }
  //   if(($theName == $name)|| (strtolower($theName) == $name))//check if bar Name from text field is equal to the database values
  //   {
  //
 // header("Location:https://people.eecs.ku.edu/~nrbaker/448Project/MapPageScript.html?name=$theName&des=$theDes&BR=$theRate&ll=$theLength&form1=$theFormal&cas=$theCasual&cov=$theCover&part=$theParty&laid=$theLaidBack");
  //
  //
  //    }   	//printf ("%s\n", $row["Username"]);	printf ("%s\n", $row2["Hased_password"]);
  //    else
  //    {
  //       echo "<script>
 // alert('Bar Name or Attribute could not be found!');
 // window.location.href='https://people.eecs.ku.edu/~nrbaker/448Project/myUI.html';
 // </script>";
  //    }
$resultBarNames->free();
//free up the memory
//}


/* close connection */
$conn->close();
?>
