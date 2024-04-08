<!DOCTYPE html>
<html>

<head>
    @include('backend.dashboard.components.head')
    <title>@yield('title')</title>
    @yield('css')
</head>

<body>
    <div id="wrapper">
        @include('backend.dashboard.components.sidebar')
      
        <div id="page-wrapper" class="gray-bg">
            @include('backend.dashboard.components.nav')
        <div class="wrapper wrapper-content">
            @yield('content')
            @include('backend.dashboard.components.footer')
        </div>
        </div>
    </div>
    
    @include('backend.dashboard.components.script')
    @yield('script')
</body>
</html>
