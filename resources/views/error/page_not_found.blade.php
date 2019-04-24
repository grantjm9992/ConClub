@inject('translator', 'App\Providers\TranslationProvider')
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title></title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="{{ asset('https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' ) }}" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/main.css')}}">
        <link rel="stylesheet" href="{{ asset('/css/jquery.datetimepicker.min.css')}}">
        <link type="text/css" rel="stylesheet" href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.css')}}" />
        <link type="text/css" rel="stylesheet" href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid-theme.min.css')}}" />
        <link rel="stylesheet" href="{{ asset('/css/jquery-ui.min.css')}}">
        <link rel="stylesheet" href="{{ asset('/css/styles.css')}}">
        <link rel="stylesheet" href="{{ asset('https://use.fontawesome.com/releases/v5.3.1/css/all.css')}}" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
        <style>
            body {
                padding-top: 150px;
                height: 100vh;
                width: 100vw;
                color: #fff;
            }
            @keyframes blink { 
                50% { border-right: 2px solid; } 
            }
            .message{
                font-size: 30px;
                border: none;
                animation: blink .5s step-end infinite alternate;
            }
            .fourofour {
                line-height: 140px;
                font-size: 140px;
                padding: 40px;
            }
            .content {
                width: 100%;
                text-align: center;
            }
            .msg {
                padding-bottom: 40px;
            }
        </style>
    </head>
    <body  id="gradient">
        <div class="content">
            <div class="fourofour">
                <span>4</span><span>0</span><span>4</span>
            </div>
            <div id="message_holder">
                <div class="msg">
                    <span class="message" id="message"></span>
                </div>
                <a style="font-size: 24px;"href='{{ url("/") }}' class='btn btn-outline-light'>{{ $translator->get("volver") }}</a>
            </div>
        </div>
        <script src="{{ asset('https://code.jquery.com/jquery-3.3.1.min.js')}}" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="{{ asset('js/jquery.cookie.js')}}"></script>
        <script type="text/javascript" src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.js')}}"></script>
        <script src="{{ asset('/js/main.js')}}"></script>
        <script src="{{ asset('/js/jquery-ui.min.js')}}"></script>
        <script src="{{ asset('https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js')}}" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> 
        <script>
            $(document).ready( function() 
            {
                var str = "{!! $translator->get('oops') !!}"
                var btn = "";
                var i = 0;
                setInterval( function() {
                    if ( i < str.length )
                    {
                        var html = $('#message').html();
                        $('#message').html(html + str[i]);
                        i++;
                    }
                }, 50);
                
var colors = new Array(
  [62,35,255],
  [60,255,60],
  [255,35,98],
  [45,175,230],
  [255,0,255],
  [255,128,0]);

var step = 0;
//color table indices for: 
// current color left
// next color left
// current color right
// next color right
var colorIndices = [0,1,2,3];

//transition speed
var gradientSpeed = 0.002;

function updateGradient()
{
  
  if ( $===undefined ) return;
  
var c0_0 = colors[colorIndices[0]];
var c0_1 = colors[colorIndices[1]];
var c1_0 = colors[colorIndices[2]];
var c1_1 = colors[colorIndices[3]];

var istep = 1 - step;
var r1 = Math.round(istep * c0_0[0] + step * c0_1[0]);
var g1 = Math.round(istep * c0_0[1] + step * c0_1[1]);
var b1 = Math.round(istep * c0_0[2] + step * c0_1[2]);
var color1 = "rgb("+r1+","+g1+","+b1+")";

var r2 = Math.round(istep * c1_0[0] + step * c1_1[0]);
var g2 = Math.round(istep * c1_0[1] + step * c1_1[1]);
var b2 = Math.round(istep * c1_0[2] + step * c1_1[2]);
var color2 = "rgb("+r2+","+g2+","+b2+")";

 $('#gradient').css({
   background: "-webkit-gradient(linear, left top, right top, from("+color1+"), to("+color2+"))"}).css({
    background: "-moz-linear-gradient(left, "+color1+" 0%, "+color2+" 100%)"});
  
  step += gradientSpeed;
  if ( step >= 1 )
  {
    step %= 1;
    colorIndices[0] = colorIndices[1];
    colorIndices[2] = colorIndices[3];
    
    //pick two new target color indices
    //do not pick the same as the current one
    colorIndices[1] = ( colorIndices[1] + Math.floor( 1 + Math.random() * (colors.length - 1))) % colors.length;
    colorIndices[3] = ( colorIndices[3] + Math.floor( 1 + Math.random() * (colors.length - 1))) % colors.length;
    
  }
}

setInterval(updateGradient,10);
            });
        </script>
    </body>
</html>
