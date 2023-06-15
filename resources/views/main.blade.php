<!DOCTYPE html>
<html lang="en">
<head>
    <title>Test App</title>
    @include('partials.header')
</head>
<body>
<div class="container mt-4">

    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if(session('company_symbol'))
        @include('content.company')  <!-- only load on demand -->
        @if (empty($historical_data))
        @else
            @include('content.chart')
        @endif
        @include('content.datatable')
    @else
        @include('content.form')
    @endif

</div>
<footer>
    @include('partials.footer')
</footer>
</body>
</html>
