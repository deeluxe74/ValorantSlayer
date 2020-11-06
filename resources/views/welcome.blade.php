<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Valorant Slayer Victory</title>
        
        <link rel="icon" type="image/png" sizes="512x512" href="logox512.png">
        
        <link rel="manifest"  href="{{ asset('manifest.json') }}">
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Css -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Carter+One|Montserrat:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    </head>
    <body>
       <div id="app">
           <index></index>
       </div>
    </body>
    <script>
        if ('serviceWorker' in navigator ) {
          window.addEventListener('load', function() {
              navigator.serviceWorker.register('/service-worker.js').then(function(registration) {
                  // Registration was successful
                  console.log('ServiceWorker registration successful');
              }, function(err) {
                  // registration failed :(
                  console.log('ServiceWorker registration failed');
              });
          });
        }
    </script>
</html>
