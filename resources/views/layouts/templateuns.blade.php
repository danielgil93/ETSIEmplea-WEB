<!DOCTYPE html>
<html>
<head>
    @include('includes.head')
</head>
<body>
    @include('includes.headeruns')

    @if(Session::has('message'))
    	<div class="container">
    		<div class="alert alert-success notify">{{ Session::get('message') }}</div>
    	</div>
    @endif

    @yield('content')
</body>
</html>