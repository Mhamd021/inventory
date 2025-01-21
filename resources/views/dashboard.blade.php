@extends('layouts.app')
@section('content')

   <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

    {{-- <script >

      Pusher.logToConsole = true;

      var pusher = new Pusher('7c415ea90b098cf04fd2', {
        cluster: 'ap2'
      });

      var channel = pusher.subscribe('EditJourney-channel');
      channel.bind('EditJourney', function(data) {
        toastr.success(JSON.stringify(data.journey.headline));


      });
    </script> --}}

@endsection
