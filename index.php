
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Scrapping System</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
      body{
        margin: 20px;
      }
      #result{
        top: 10px;
      }
    </style>
  </head>
  <body>

    <form id="searchForm"  action="search.php">
      <input type="text" name="qry" id="query"  placeholder="Search..." >
      <button type="button" onclick="$('#searchForm').submit();">Search</button>
    </form>

     <!-- the result of the search will be rendered inside this div -->
     <div id="result"></div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
     <script>
           //callback handler for form submit
          $("#searchForm").submit(function(e)
          {
              var postData = $(this).serializeArray();
              var formURL = $(this).attr("action");            
              $.ajax(
              {
                  url : formURL,
                  type: "POST",
                  data : postData,
                  success:function(data, textStatus, jqXHR) 
                  {   
                    var actual = JSON.parse(data);
                    //$("#result").html(data);
                    var len = actual.length;
                    var html = "<table>";
                    for(var i=0; i<len; i++){
                      html += "<tr><td><img src='"+actual[i]['image']+"'/></td><td>"+actual[i]['title']+"</td><td>"+actual[i]['price']+"</td></tr>";
                    }
                    html +="</table>";
                    $("#result").html(html);
                   
                      //data: return data from server
                  },
                  error: function(jqXHR, textStatus, errorThrown) 
                  {
                      //if fails     
                        console.log('no') 
                  }
              });
              e.preventDefault(); //STOP default action            
          });          
         
        </script>
  </body>
</html>