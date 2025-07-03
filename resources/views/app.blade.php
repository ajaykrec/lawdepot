<!doctype html>
<html class="no-js" lang="en">    
    <head>
        <meta charset="utf-8">  
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />      
        <meta name="viewport" content="width=device-width, initial-scale=1.0">  
        <!-- favicon icon -->
        <link rel="shortcut icon" href="/frontend-assets/images/favicon.png">
        <link rel="apple-touch-icon" href="/frontend-assets/images/apple-touch-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/frontend-assets/images/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/frontend-assets/images/apple-touch-icon-114x114.png">
        <!-- Google Web Fonts -->        
        <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&amp;family=Montserrat:ital,wght@0,100..900;1,100..900&amp;display=swap" rel="stylesheet">    
        <!-- style sheets and font icons  -->
        <link rel="stylesheet" href="/frontend-assets/css/vendors.min.css"/>
        <link rel="stylesheet" href="/frontend-assets/css/icon.min.css"/>
        <link rel="stylesheet" href="/frontend-assets/css/style.css"/>
        <link rel="stylesheet" href="/frontend-assets/css/responsive.css"/>
        <link rel="stylesheet" href="/frontend-assets/css/hosting.css" />
        <link rel="stylesheet" href="/frontend-assets/css/nprogress.min.css" />
        <!-- jquery -->
        <script src="/frontend-assets/js/jquery.js"></script>
        @viteReactRefresh
        @vite([
          'resources/css/app.css', 
          'resources/js/app.jsx'
        ])
        @inertiaHead       
    </head>
    <body>    
    @routes
    @inertia    
    <div id="main-modal"></div>     
    
    <script type="text/javascript" src="/frontend-assets/js/vendors.min.js"></script>
    <script type="text/javascript" src="/frontend-assets/js/main.js"></script>    
    </body>  
</html>