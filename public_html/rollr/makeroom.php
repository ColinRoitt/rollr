<?php include "header.php" ?>
<!-- content goes here -->

<script src="validateName.js"></script>

<div class="heading">
  <h2>Please enter the new room details</h2>
</div>

<div class="form-cont">
  <form action="playroom.php" method="post" id="actionForm">
    Room name:<br>
    <input id="nameInput" type="text" name="roomName" ><br>
    Room Password:<br>
    <input id="passwordInput" type="text" name="roomPassword" value="Optional"><br/><br/>
    <input type="hidden" name="submitionType" value="create" />
    <input disabled="enabled" id="goButtozz\n" class="button" type="submit" name="submit" value="Create"/>
  </form>
</div>
<div class="padder53"></div>


<script>

function removeWord(){                 //removes the optional word from password box when it is got focus.
  if(this.value == "Optional"){   //checks if box content is word
    this.value = "";
  }
}

function addWord(){                 //adds optional word back when got focus
  if(this.value == ""){   //checks if box content is empty
    this.value = "Optional";
  }
}

document.getElementById('actionForm').onsubmit = function(){
  pwrdIn = document.getElementById('passwordInput');
  pwrdIn.value = SHA512(pwrdIn.value);    //this is  function call to someone else's SHA512 js implementation. I DID NOT WRITE THE SHA512 FUNCTION. Credit in jsEncrypt.js
}

document.getElementById('passwordInput').onfocus = removeWord;     //prepares events
document.getElementById('passwordInput').onblur = addWord;

</script>
<script src='jsEncrypt.js'></script>


<?php include "footer.php" ?>
