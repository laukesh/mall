<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>{{ config('app.name', 'Laravel') }}</title>
            <link href='https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css' rel='stylesheet'>	
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
          <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
            <link rel="stylesheet" href="{{ asset('auth.css') }}">

        <!-- Fonts -->
     
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
       <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
    @if (Route::has('login'))
        <nav class="flex items-center justify-end gap-4">

            @auth

                <a href="{{ route('admin.dashboard') }}"
                   class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border border-[#19140035] hover:border-[#1915014a] text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                    Dashboard
                </a>

                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border border-red-500 text-red-600 hover:bg-red-600 hover:text-white rounded-sm text-sm leading-normal">
                        Logout
                    </button>
                </form>

            @else

                <a href="{{ route('login.form') }}"
                   class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">
                    Login
                </a>

                @if (Route::has('register.form'))
                    <a href="{{ route('register.form') }}"
                       class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border border-[#19140035] hover:border-[#1915014a] text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                        Register
                    </a>
                @endif

            @endauth

        </nav>
    @endif
</header>
      

        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
    </body>
</html>
