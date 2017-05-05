//THIS CODE IS MODIFIED FROM ACTIVITY 17
		/////////////SETUP CHECKING BROWSER CAPABILITIES

		var xmlhttpx,alerted
		/*@cc_on @*/
		/*@if (@_jscript_version >= 5)
		// JScript gives us Conditional compilation, we can cope with old IE versions.
		  try {
		  xmlhttpx=new ActiveXObject("Msxml2.XMLHTTP")
		 } catch (e) {
		  try {
			xmlhttpx=new ActiveXObject("Microsoft.XMLHTTP")
		  } catch (E) {
		   alert("You must have Microsofts XML parsers available")
		  }
		 }
		@else
		 alert("You must have JScript version 5 or above.")
		 xmlhttpx=false
		 alerted=true
		@end @*/
		if (!xmlhttpx && !alerted) {
		 // Non ECMAScript Ed. 3 will error here (IE<5 ok), nothing I can
		 // realistically do about it, blame the w3c or ECMA for not
		 // having a working versioning capability in  <SCRIPT> or
		 // ECMAScript.
		 try {
		  xmlhttpx = new XMLHttpRequest();
		 } catch (e) {
		  alert("You need a browser which supports an XMLHttpRequest Object.\nMozilla build 0.9.5 has this Object and IE5 and above, others may do, I don't know, any info jim@jibbering.com")
		 }
		}

		/////////////INTERESTING PART OF THE SCRIPT

		function RSchangeq() {
		 if (xmlhttpx.readyState==4) {
			 if(xmlhttpx.responseText != document.getElementById("currentImg").src && xmlhttpx.responseText != undefined && xmlhttpx.responseText != ""){
				 document.getElementById("currentHref").href = xmlhttpx.responseText;
				 document.getElementById("currentImg").src = xmlhttpx.responseText;
			 }
		 }
		}

		function gos() {
      r++;
      console.log("share box updated " + r);
		if (xmlhttpx) {
		  d=document;
		  xmlhttpx.open("GET", shareLog, true);
		  xmlhttpx.onreadystatechange=RSchangeq;
		  xmlhttpx.send(null);
      setTimeout('gos()', 1000);

		 }
		}

    function RSchangeu() {
		 if (xmlhttpx.readyState==4) {
		  console.log("url set");
      //document.getElementById('msgList').innerHTML=xmlhttp.responseText;
		 }
		}

    function setNew(url) {
		if (xmlhttpx) {
		  xmlhttpx.open("GET", "setUrl.php?url=" + url + "&file=" + shareLog, true);
		  xmlhttpx.onreadystatechange=RSchangeu;
		  xmlhttpx.send(null);
		 }
		}

    shareLog = roomId + '_shareLog.txt';
    var r = 0;
    setTimeout('gos()', 1000);
