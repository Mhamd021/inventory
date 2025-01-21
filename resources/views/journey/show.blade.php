@extends('layouts.app')
@section('content')
    <meta charset="utf-8" />
    <title>journeys</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://api.mapbox.com/mapbox-gl-js/v3.8.0/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v3.8.0/mapbox-gl.js"></script>

    <link rel="stylesheet" href="{{asset('css/show.css')}}">



    <div id="map"> </div>
    {{-- <p>{{$journey->headline}}</p>
    <p>{{$journey->start_day}}</p>
    <p>{{$journey->last_day}}</p>
    <p>{{$journey->journey_charg}}</p>
    <p>{{$journey->max_number}}</p>
    <p>{{$journey->description}}</p> --}}



    <script>
        const points = @json($points);
        if(points !== null)
        {
            mapboxgl.accessToken =
            'pk.eyJ1IjoiZG9uMjEiLCJhIjoiY20yOTZtMjhoMDB3YzJqczc2YWhtenJrNiJ9.IKwkfvJWrxOZkYBlwsAhNA';
        const map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v12',
            center: [points[0].location.coordinates[0],points[0].location.coordinates[1]],
            zoom: 7
        });
        map.on('load', () => {
            points.forEach(point => {
                const coordinates = [point.location.coordinates[0], point.location.coordinates[1]];
                const description = point.point_description;
                console.log('Adding marker at:', coordinates);
                // Debugging log
                const el = document.createElement('div');
                el.className = 'marker';
                el.textContent = point.order;
                // Create a popup with an image and description
                const popup = new mapboxgl.Popup({
                    offset: 25
                }).setHTML(
                    ` <img src="{{ asset('${point.image}') }}" alt="Beautiful Place" " /> <p>${description}</p> `
                    );
                new mapboxgl.Marker(el).setLngLat(coordinates).setPopup(popup).addTo(map);
            });
        });
        }
        else
        {
            console.log("no points!!");
        }

    </script>
@endsection
