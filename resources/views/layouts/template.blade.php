<!DOCTYPE html>
<html>
<head>
    @include('includes.head')
</head>
<body>
    @include('includes.header')

    @if(Session::has('message'))
    	<div class="container">
    		<div class="alert alert-success notify">{{ Session::get('message') }}</div>
    	</div>
    @endif
	
	@if(Session::has('errormessage'))
    	<div class="container">
    		<div class="alert alert-error notify">{{ Session::get('errormessage') }}</div>
    	</div>
    @endif

    @yield('content')

    @include('includes.footer')
</body>
</html>