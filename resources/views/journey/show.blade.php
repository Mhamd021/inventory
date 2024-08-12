<x-app-layout>
    <meta charset="utf-8" />
    <title>Getting started with the Mapbox Directions API</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://api.tiles.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.js"></script>
    <link href="https://api.tiles.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('show.css') }}">


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
           {{$jou->headline}}

        </h2>


    </x-slot>
    <input hidden class="input" name="start_lat" type="text" id="lat"value="{{ $jou->start_point->latitude }}">
    <input hidden class="input" name="start_lng" type="text"
        id="lng"value="{{ $jou->start_point->longitude }}">
    <input hidden class="input" hidden name="end_lat" type="text" id="lat2"
        value="{{ $jou->end_point->latitude }}">
    <input hidden class="input" hidden name="end_lng" type="text"
        id="lng2"value="{{ $jou->end_point->longitude }}">


    <div class="parent">
        <div class="map" id="map"></div>
        <div id="instructions"></div>
    </div>
    <div class="informations">


            <h1 style="font-weight: bold ; margin: 10px">Description</h1>
        <label style=""> {{ $jou->description }}</label>



            <h1>            Start Date :            </h1>

            <label for=""> {{ $jou->start_day }}</label>


            <h1>End Date :</h1>
        <label > {{ $jou->last_day }}</label>



           <h1> journey charg :</h1>
        <label for=""> {{ $jou->journey_charg }} $</label>



            <h1>max number :</h1>
        <label for=""> {{ $jou->max_number }} people</label>



    </div>
</x-app-layout>


<script  type="module">
    Echo.channel('chat')
.listen('NewMessage', (e) => {
    console.log(e.message);
});
</script>

<script>
    // add the JavaScript here
    let lat = document.getElementById('lat').value;
    let lng = document.getElementById('lng').value;
    let lat2 = document.getElementById('lat2').value;
    let lng2 = document.getElementById('lng2').value;
    mapboxgl.accessToken =
        'pk.eyJ1IjoiZG9uMjEiLCJhIjoiY2xramN3d2RkMHRsNzNwa2dmdnIyZnBxMiJ9.ZXAz_MdYN4tANHbAALm5KQ ';
    const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v12',
        center: [lat, lng],
        zoom: 6
    });

    const start = [lat, lng];
    const second = [lat2, lng2];

    // create a function to make a directions request
    async function getRoute(end) {

        const query = await fetch(
            `https://api.mapbox.com/directions/v5/mapbox/driving/${start[0]},${start[1]};${second[0]},${second[1]}?steps=true&geometries=geojson&access_token=${mapboxgl.accessToken}`, {
                method: 'GET'
            }
        );
        const json = await query.json();
        const data = json.routes[0];
        const route = data.geometry.coordinates;
        const geojson = {
            type: 'Feature',
            properties: {},
            geometry: {
                type: 'LineString',
                coordinates: route
            }
        };
        // if the route already exists on the map, we'll reset it using setData
        if (map.getSource('route')) {
            map.getSource('route').setData(geojson);
        }
        // otherwise, we'll make a new request
        else {
            map.addLayer({
                id: 'route',
                type: 'line',
                source: {
                    type: 'geojson',
                    data: geojson
                },
                layout: {
                    'line-join': 'round',
                    'line-cap': 'round'
                },
                paint: {
                    'line-color': '#3887be',
                    'line-width': 5,
                    'line-opacity': 0.75
                }
            });
        }
        // add turn instructions here at the end
        // get the sidebar and add the instructions
        const instructions = document.getElementById('instructions');
        const steps = data.legs[0].steps;

        let tripInstructions = '';
        for (const step of steps) {
            tripInstructions += `<li>${step.maneuver.instruction}</li>`;
        }
        instructions.innerHTML = `<p><strong>Trip duration: ${Math.floor(
  data.duration / 60
)} min 🚴 </strong></p><ol>${tripInstructions}</ol>`;
    }

    map.on('load', () => {

        getRoute(start);

        // Add starting point to the map
        map.addLayer({
            id: 'point',
            type: 'circle',
            source: {
                type: 'geojson',
                data: {
                    type: 'FeatureCollection',
                    features: [{
                        type: 'Feature',
                        properties: {},
                        geometry: {
                            type: 'Point',
                            coordinates: start
                        }
                    }]
                }
            },
            paint: {
                'circle-radius': 10,
                'circle-color': '#3887be'
            }
        });
        map.addLayer({
            id: 'end',
            type: 'circle',
            source: {
                type: 'geojson',
                data: {
                    type: 'FeatureCollection',
                    features: [{
                        type: 'Feature',
                        properties: {},
                        geometry: {
                            type: 'Point',
                            coordinates: second
                        }
                    }]
                }
            },
            paint: {
                'circle-radius': 10,
                'circle-color': '#f30'
            }
        });

        getRoute(start, second);
    });

    // this is where the code from the next step will go
</script>















{{-- <x-app-layout>


    <div class="parent">
        <div class="map" id="map"></div>
    </div>




</x-app-layout> --}}
