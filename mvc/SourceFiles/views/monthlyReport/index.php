<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://localhost/mvc/Source%20Files/public/css/default.css">

    <script>
        function showResult(str) {
            if (str.length==0) {
                document.getElementById("livesearch").innerHTML="";
                document.getElementById("livesearch").style.border="0px";
                return;
            }
            var xmlhttp=new XMLHttpRequest();
            xmlhttp.onreadystatechange=function() {
                if (this.readyState==4 && this.status==200) {

                    document.getElementById("livesearch").innerHTML=this.responseText;
                    document.getElementById("livesearch").style.border="1px solid #A5ACB2";
                }
            }
            xmlhttp.open("GET","liveSearch?q="+str,true);
            xmlhttp.send();
        }
    </script>
</head>
<body>
<a href="check">Back</a>
<form>

    <input id="i1" type="text" size="30" onkeyup="showResult(this.value)">
    <div class="container">
        <div class="row">
            <div class="col" id="livesearch"></div>
        </div>
    </div>

</form>

</body>
</html>
