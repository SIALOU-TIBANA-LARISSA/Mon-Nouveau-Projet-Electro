<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body style="margin:0; font-family:Arial, sans-serif; background:#f4f6f9;">
    <div style="display:flex; min-height:100vh;">

        {{-- MENU --}}
        @include('admin.partials.sidebar')

        {{-- CONTENU --}}
        <div style="flex:1;">
            @include('admin.partials.header')

            <main style="padding:20px;">
                @yield('content')
            </main>
        </div>

    </div>
</body>
</html>
