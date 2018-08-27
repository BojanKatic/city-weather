<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css" >
    <title>Weather </title>
  </head>
  <body>
    <!-- inputs for city pick -->
    <div class="destination_inputs">
        <div class="row margin_top10">
            <div class="col-6">
                <p>Type departure city</p>
                <input type="text" id="departure" value="" />
            </div>
            <div class="col-6">
                <p>Type destination city</p>
                <input type="text" id="destination" value="" />            
            </div>       
        </div>    
    </div>
    <!-- button that triger ajax and show respnse -->
    <div class="press_button">
        <button id="proba">Get result</button>
    </div>





<div class="container grafik_ilustration margin_top50">

</div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>

    <script>


    $("#proba").click(function(){
        
            navigator.geolocation.getCurrentPosition(function(position) {
                var departureCord = $('#departure').val();
                var destinationCord = $('#destination').val();

                var view_data;
                $.ajax({
                    type: 'POST',
                    url: 'ajax.php',
                    data: {departure:  departureCord,  destination: destinationCord},
                    success: function(msg){
                        $(".grafik_ilustration").html(msg)
                    }
            });
        });
    });
    </script>




  </body>
</html>