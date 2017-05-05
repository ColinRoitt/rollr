//THIS CODE IS MODIFIED FROM ACTIVITY 17
		/////////////SETUP CHECKING BROWSER CAPABILITIES

		var xmlhttp,alerted
		/*@cc_on @*/
		/*@if (@_jscript_version >= 5)
		// JScript gives us Conditional compilation, we can cope with old IE versions.
		  try {
		  xmlhttp=new ActiveXObject("Msxml2.XMLHTTP")
		 } catch (e) {
		  try {
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP")
		  } catch (E) {
		   alert("You must have Microsofts XML parsers available")
		  }
		 }
		@else
		 alert("You must have JScript version 5 or above.")
		 xmlhttp=false
		 alerted=true
		@end @*/
		if (!xmlhttp && !alerted) {
		 // Non ECMAScript Ed. 3 will error here (IE<5 ok), nothing I can
		 // realistically do about it, blame the w3c or ECMA for not
		 // having a working versioning capability in  <SCRIPT> or
		 // ECMAScript.
		 try {
		  xmlhttp = new XMLHttpRequest();
		 } catch (e) {
		  alert("You need a browser which supports an XMLHttpRequest Object.\nMozilla build 0.9.5 has this Object and IE5 and above, others may do, I don't know, any info jim@jibbering.com")
		 }
		}

		/////////////INTERESTING PART OF THE SCRIPT

		function RSchangex() {
		 if (xmlhttp.readyState==4) {
		  document.getElementById('msgList').innerHTML=xmlhttp.responseText;
		 }
		}

		function go() {
      i++;
      console.log("I have run " + i);
		if (xmlhttp) {
		  d=document;
		  xmlhttp.open("GET", chatLog, true);
		  xmlhttp.onreadystatechange=RSchangex;
		  xmlhttp.send(null);
      setTimeout('go()', 1000);
		 }
		}

    function RSchangey() {
		 if (xmlhttp.readyState==4) {
		  console.log("message sent");
      //document.getElementById('msgList').innerHTML=xmlhttp.responseText;
		 }
		}

    function send() {
		if (xmlhttp) {
      x = document.getElementById("sendMsgBox");
      msg = x.value;
      x.value = "";
		  xmlhttp.open("GET", "sendMsg.php?name=" + name + "&message=" + msg + "&file=" + chatLog, true);
		  xmlhttp.onreadystatechange=RSchangey;
		  xmlhttp.send(null);
		 }
		}

    name = user;
    chatLog = roomId + '_chatLog.txt';
    var i = 0;
    setTimeout('go()', 1000);
