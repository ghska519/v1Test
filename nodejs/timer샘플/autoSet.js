
  var xhttp;
  if(window.XMLHttpRequest){
    xhttp = new XMLHttpRequest();
  }else{// IE5, IE6
    xhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
  xhttp.onreadystatechange = function(){
    if(xhttp.readyState == 4 && xhttp.status == 200){
      //jobj = JSON.parse(xhttp.responseText);
      console.log(xhttp.responseText);
    }
  };
  xhttp.open('GET','http://super.hnallnew.com/Main/checkLimitData',true);
  xhttp.send();
