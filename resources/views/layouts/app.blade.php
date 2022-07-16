<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>@yield('title')</title>
  @stack('prepend-style')
  @include('includes.style')
  @livewireStyles
  @stack('addon-style')
</head>
<body>

  <div id="mytask-layout" class="theme-indigo">
    @include('includes.sidebar')
    <div class="main px-lg-4 px-md-4">
      {{-- @include('includes.navbar') --}}
      @yield('content')
    </div>
  </div>


  @stack('prepend-script')
  @include('includes.script')
  @livewireScripts
  @stack('addon-script')
  
</body>
</html>