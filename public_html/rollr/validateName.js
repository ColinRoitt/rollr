funcProcess;
var xmlHttp = createXmlHttpRequestObject();


function createXmlHttpRequestObject(){
  var xmlHttp;

  if(window.ActiveXObject){
    try{
      xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }catch(e){
      xmlHttp = false;
      //alert(e);
    }
  }else{
    try{
      xmlHttp = new XMLHttpRequest();
    }catch(y){
      xmlHttp = false;
      //alert(y);
    }
  }
  if(!xmlHttp){
    alert("error: cannot create Xml HTTP object, please contact system adminsitrator");
  }else {
    return xmlHttp;
  }
}

function funcProcess(){
  //alert("running");
  if(xmlHttp.readyState == 0 || xmlHttp.readyState==4){
    newRoomName = document.getElementById("nameInput").value;
    xmlHttp.open("GET", "checkValidRoomName.php?roomName="+newRoomName, true);
    xmlHttp.onreadystatechange = handleServerResponse;
    xmlHttp.send(null);
    //alert('something??');
    //setTimeout('funcProcess()', 1000);
  }else{
    setTimeout('funcProcess()', 1000);
  }
}

function handleServerResponse(){
  //alert('start hSR');
  if(xmlHttp.readyState == 4){
    //alert('past 4');
    if(xmlHttp.status == 200){
      //alert('past 200');
      xmlResponse = xmlHttp.responseXML;
      //xmlDocumentElement = xmlResponse.documentElement();
      message = xmlResponse.documentElement.firstChild.data;
      //alert("ll");
      //alert(message);
      if(message == "0"){
        document.getElementById("goButton").value = "create";
        document.getElementById("goButton").disabled = false;
      }else{
        document.getElementById("goButton").value = "This name is not valid";
        document.getElementById("goButton").disabled = true;
      }
      setTimeout('funcProcess()', 1000);
    }else {
      alert("Error: could not comunicate with server");
    }
  }
}
