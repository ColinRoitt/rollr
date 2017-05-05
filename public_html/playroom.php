
<?php include "header.php";

//functions

function genRoomId(){
  $length = 20;
  $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $URD = '';
  for ($i = 0; $i < $length; $i++) {
      $URD .= $chars[rand(0, strlen($chars) - 1)];
  }
  return $URD;
}

function runQuery($sqlCommand){
  $dbconfig = parse_ini_file("/var/sites/c/colinroitt.uk/dbConf.ini"); //get log in details from config ini file
  $servername = $dbconfig[rollr_servername];
  $username = $dbconfig[rollr_username];
  $password = $dbconfig[rollr_password];

  $conn = mysqli_connect($servername, $username, $password);    //connect

//check if connected
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error()); //die function exits current php script
  }

  $sql = $sqlCommand;

  if(mysqli_query($conn, $sql)){
    $response = true;
  }else{
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    $response = false;
  }


  mysqli_close($conn);
  return $response;

}

function runFetchQuery($sqlCommand){
  $dbconfig = parse_ini_file("/var/sites/c/colinroitt.uk/dbConf.ini"); //get log in details from config ini file
  $servername = $dbconfig[rollr_servername];
  $username = $dbconfig[rollr_username];
  $password = $dbconfig[rollr_password];

  $conn = mysqli_connect($servername, $username, $password);    //connect

//check if connected
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error()); //die function exits current php script
  }

  //$sql = $sqlCommand;
  $sqlr = mysqli_query($conn, $sqlCommand);
  echo "<script>alert(". mysqli_error .")</script>";
  $r = mysqli_fetch_assoc($sqlr);
  mysqli_close($conn);

  return $r;
}

//get details from form

$roomName = $_POST["roomName"];
if($_POST["roomPassword"] == "Optional"){
  $roomPassword = "";
}else{
  $roomPassword = $_POST["roomPassword"];
}

//make room code

if($_POST["submitionType"] == "create"){ //came from make page

  echo"THIS IS MAKE PAGE";
  $roomId = genRoomId();
  $creation = date('Y/m/d h:i:s a', time());
  $sqlMakeNewRoom = "INSERT INTO colinroi_rollr.rooms VALUES('$roomId', '$roomName', '$roomPassword', '$creation')";

  //create text file for chat
  $chatLog = fopen($roomId . "_chatLog.txt", "w");
  echo "<script>var roomId = '$roomId' </script>";

  //create text file for share link log
  $shareLog = fopen($roomId . "_shareLog.txt", "w");

  //create text file for die log
  $shareLog = fopen($roomId . "_dieLog.txt", "w");

  if(runQuery($sqlMakeNewRoom)){
    $render = true;
  }else{
    $render = false;
  }

}else{      //join room code
  echo"THIS IS JOIN PAGE";
  $sqlGetRoom = "SELECT * FROM colinroi_rollr.rooms WHERE roomName = '$roomName' AND roomPassword = '$roomPassword'";
  $sqlResult = runFetchQuery($sqlGetRoom);
  if($sqlResult["roomId"] == ""){
    echo "no server found";
    $render = false;
  }else{
    if($sqlResult["roomPassword"] == $roomPassword){
      $render = true;
      $roomId = $sqlResult["roomId"];
      echo "<script>var roomId = '$roomId' </script>";
    }else{
      echo "password incorrect";
      $render = false;
    }
  }

}


//render code
if($render){

?>
<!--content goes here-->
<div class="heading">
  <h2>Play Area - <?php echo $roomName ?></h2>

<div class="playArea">

  <div class="diceArea">

    <div class="heading">
      Dice
    </div>

    <div class="dice">
      <img id="dice" src="http://dev.colinroitt.uk/rollr/assets/die/1.png" />
    </div>

    <div class="controls">
      <button id="rolld4" onclick="">roll d4</button>
      <button id="rolld6" onclick="">roll d6</button>
      <button id="rolld8" onclick="">roll d8</button>
      <button id="rolld10" onclick="">roll d10</button>
      <button id="rolld12" onclick="">roll d12</button>
      <button id="rolld20" onclick="">roll d20</button>
      <button id="rolld100" onclick="">roll d100</button>
    </div>

    <br />

    <div class="prevRollsListCont">
      <div id="rollList" class="prevRollsList" >
        d6 - 1
      </div>
    </div>

    <button id="clearList" class="clearButton">Clear MY dice history</button>

  </div>
  <div class="chatArea">
    <div class="heading">
      Chatroom
    </div>

    <div class="chatCont">
      <div class="messageWindow">
        <textarea readonly id="msgList" class="msgList" line=3 cols=27></textarea>

      </div>
      <div class="chatMenu">

        <button id="setName" class="menuButton">set name</button>
        <button id="sendMsg" class="menuButton" onclick="send()">send</button>

      </div>
      <div class="chatSendMessage">
        <textarea id="sendMsgBox" class="sendMsgBox" line=3 cols=27></textarea>

      </div>
    </div>

  </div>
  <div class="shareArea">
    <div class="heading">
      Share box
    </div>

    <button id="setImage">set image</button>

    <a id="currentHref" href="https://pbs.twimg.com/media/C3qPDQeWMAEN48m.jpg" target="_blank">
        <div class="imgCont">
          <img id="currentImg"src="https://pbs.twimg.com/media/C3qPDQeWMAEN48m.jpg" />
        </div>
    </a>

  </div>
</div>

<script>

  function randomNum(max, die){
    if(max == 100){
      num = (Math.floor((Math.random() * 10) + 1)) * 10;
    }else{
      num = Math.floor((Math.random() * max) + 1);
    }
    sendNewDie(num);
    document.getElementById("dice").src = "http://dev.colinroitt.uk/rollr/assets/die/" + num + ".png";
    list = document.getElementById("rollList");
    list.innerHTML = die + " - " + num + "<br/>" + list.innerHTML;
  }

  function clearList(){
    document.getElementById("rollList").innerHTML = "";
  }

  function setName(){
    user = prompt("Enter your new nikname");
  }

  function setImage(){
    newUrl = "";
    newUrl = prompt("Enter new image URL");
    if(newUrl != ""){
      setNew(newUrl);
    }
  }

  document.getElementById('rolld4').onclick = function(){
    randomNum(4, "d4");
  }

  document.getElementById('rolld6').onclick = function(){
    randomNum(6, "d6");
  }

  document.getElementById('rolld8').onclick = function(){
    randomNum(8, "d8");
  }

  document.getElementById('rolld10').onclick = function(){
    randomNum(10, "d10");
  }

  document.getElementById('rolld12').onclick = function(){
    randomNum(12, "d12");
  }

  document.getElementById('rolld20').onclick = function(){
    randomNum(20, "d20");
  }

  document.getElementById('rolld100').onclick = function(){
    randomNum(100, "d100");
  }

  document.getElementById('clearList').onclick = function(){
    clearList();
  }

  document.getElementById('setName').onclick = function(){
    setName();
  }

  document.getElementById('setImage').onclick = function(){
    setImage();
  }

  alert("THIS IS A PROTOTYPE. Some items may be slow to update depending on the network circumstances and limitations of your browsers JS implementation.")
  var user = prompt("Enter your new nikname");

  var textarea = document.getElementById('msgList');
  textarea.scrollTop = textarea.scrollHeight;

</script>
<script src="updateChat.js"></script>
<script src="updateShareBox.js"></script>
<script src="updateDieList.js"></script>


<?php include "footer.php";

}else{
  echo "<div class=heading>
          <h2>THERE HAS BEEN A CATASTROPHIC ERROR</h2>";
  if($_POST["submit"] == "Create"){
          echo "<P>
                  please contact the developer
                </P>";
  }else{
    echo "<p>
            you may have entered some data with an error
          </p>";

  }
  echo "</div>";
}



?>
