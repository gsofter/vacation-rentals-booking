@extends('layouts.main')

@section('content')

    <div style="height: 400px;">
      <h1>Help is working now.</h1>
    </div>

  @push('scripts')
   <script src="{{ url('dist/client/js/business/includes/help.min.js') }}"></script>
  @endpush
@stop