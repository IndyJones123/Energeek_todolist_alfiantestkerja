<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Document')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Google Fonts Poppins --> 
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400&display=swap" rel="stylesheet">
</head>
<body>
    <div class="max-h-min min-h-screen md:pl-10 md:pr-10 md:pt-5 md:pb-5 2xl:pl-20 2xl:pr-20 2xl:pt-5 2xl:pb-5 bg-[#FAFAFA]">
        @yield('content')
    </div>
</body>
</html>
