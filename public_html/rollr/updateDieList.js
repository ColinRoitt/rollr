
		/////////////SETUP CHECKING BROWSER CAPABILITIES

		var xmlhttpl,alerted
		/*@cc_on @*/
		/*@if (@_jscript_version >= 5)
		// JScript gives us Conditional compilation, we can cope with old IE versions.
		  try {
		  xmlhttpl=new ActiveXObject("Msxml2.XMLHTTP")
		 } catch (e) {
		  try {
			xmlhttpl=new ActiveXObject("Microsoft.XMLHTTP")
		  } catch (E) {
		   alert("You must have Microsofts XML parsers available")
		  }
		 }
		@else
		 alert("You must have JScript version 5 or above.")
		 xmlhttpl=false
		 alerted=true
		@end @*/
		if (!xmlhttpl && !alerted) {
		 // Non ECMAScript Ed. 3 will error here (IE<5 ok), nothing I can
		 // realistically do about it, blame the w3c or ECMA for not
		 // having a working versioning capability in  <SCRIPT> or
		 // ECMAScript.
		 try {
		  xmlhttpl = new XMLHttpRequest();
		 } catch (e) {
		  alert("You need a browser which supports an XMLHttpRequest Object.\nMozilla build 0.9.5 has this Object and IE5 and above, others may do, I don't know, any info jim@jibbering.com")
		 }
		}

		/////////////INTERESTING PART OF THE SCRIPT

		function RSchangek() {
		 if (xmlhttpl.readyState==4) {
			 if(xmlhttpl.responseText != ""){
				 document.getElementById("dice").src = "http://dev.colinroitt.uk/rollr/assets/die/" + xmlhttpl.responseText + ".png";
			 }
		 }
		}

		function gop() {
      a++;
      console.log("dice updated " + a);
			if (xmlhttpl) {
			  d=document;
			  xmlhttpl.open("GET", dieLog, true);
			  xmlhttpl.onreadystatechange=RSchangek;
			  xmlhttpl.send(null);
	      setTimeout('gop()', 1000);

			 }
		}

    function RSchangeb() {
		 if (xmlhttpl.readyState==4) {
		 console.log("Dice set");

      //document.getElementById('msgList').innerHTML=xmlhttp.responseText;
		 }
		}

    function sendNewDie(roll) {
		if (xmlhttpl) {
		  xmlhttpl.open("GET", "setDie.php?die=" + roll + "&file=" + dieLog, true);
		  xmlhttpl.onreadystatechange=RSchangeb;
		  xmlhttpl.send(null);
		 }
		}

    dieLog = roomId + '_dieLog.txt';
    var a = 0;
    setTimeout('gop()', 1000);
