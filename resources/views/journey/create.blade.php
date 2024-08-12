<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Create Journey
        </h2>
    </x-slot>
    {{-- <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
        integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" /> --}}
    <script src="https://api.tiles.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.js"></script>
    <link href="https://api.tiles.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.css" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('test.css') }}">
    <form class="F" action="{{ route('journey.store') }}" method="post">
        @csrf
        <div class="parent">
            <div class="first">
                <div class="coord">

                    <h1 style="color: #3c8eb4c3">Specifing the road</h1><br>
                    <h1> please enter the first and the second point from the map </h1><br>
                    <p class="text-gray-700" id="first-p"> first point</p>
                    <input class="input" name="start_lat" type="text" id="lat"
                        value="{{ old('start_lat') }}"><br>
                    @error('start_lat')
                        <span class="invalid-feedback" role="alert">
                            <strong style="color: red">{{ $message }}</strong>
                        </span>
                    @enderror
                    <input class="input" name="start_lng" type="text" id="lng"
                        value="{{ old('start_lng') }}"><br>
                    @error('start_lng')
                        <span class="invalid-feedback" role="alert">
                            <strong style="color: red">{{ $message }}</strong>
                        </span>
                    @enderror
                    <button hidden id="go-back" class="btn-primary">
                        <p style="color: white">Go_back</p>
                    </button>
                    <button id="save-first-point" class="btn-primary">
                        <p style="color: white">Save</p>
                    </button>
                    <p hidden class="text-gray-700" id="second-p"> second point</p>
                    <input class="input" hidden name="end_lat" type="text" id="lat2"
                        value="{{ old('end_lat') }}"><br>
                    <input class="input" hidden name="end_lng" type="text" id="lng2"
                        value="{{ old('end_lng') }}"><br>
                    <button hidden id="save-second-point" class="btn-primary">
                        <p style="color: white">Save</p>
                    </button>
                    <button hidden class="btn-primary" id="go-back2">
                        <p style="color: white">Go_back</p>
                    </button>
                </div>
                <div id="map" class="map"></div>

            </div>
            <div class="second">
                <div class="left">
                    <h1 style="color: #3c8eb4c3">Comblete The information below to create your first journey</h1><br>
                    <p>Headline</p>
                    <input class="input" type="text" name="headline" value="{{ old('headline') }}"><br>
                    @error('headline')
                        <span class="invalid-feedback" role="alert">
                            <strong style="color: red">{{ $message }}</strong><br>
                        </span>
                    @enderror
                    <p>Start Date</p>
                    <input class="input" type="date" name="start_day" value="{{ old('start_day') }}"><br>
                    @error('start_day')
                        <span class="invalid-feedback" role="alert">
                            <strong style="color: red">{{ $message }}</strong><br>
                        </span>
                    @enderror
                    <p>End Date</p>

                    <input class="input" type="date" name="last_day" value="{{ old('last_day') }}"><br>
                    @error('last_day')
                        <span class="invalid-feedback" role="alert">
                            <strong style="color: red">{{ $message }}</strong><br>
                        </span>
                    @enderror
                </div>
                <div class="right">
                    <h1 style="color: #3c8eb4c3">All the fields are required </h1><br>
                    <p>Description</p>
                    <input class="input" type= "text" name="description" value="{{ old('description') }}"><br>
                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong style="color: red">{{ $message }}</strong><br>
                        </span>
                    @enderror
                    <p>journey charg</p>
                    <input class="input" type="number" name="journey_charg" value="{{ old('journey_charg') }}"><br>
                    @error('journey_charg')
                        <span class="invalid-feedback" role="alert">
                            <strong style="color: red">{{ $message }}</strong><br>
                        </span>
                    @enderror


                    <p>Max Number</p>
                    <input class="input" type="number" name="max_number" value="{{ old('max_number') }}"><br>
                    @error('max_number')
                        <span class="invalid-feedback" role="alert">
                            <strong style="color: red">{{ $message }}</strong><br>
                        </span>
                    @enderror
                </div>

            </div>
            <button type="submit" class="btn">
                <p style="color: white">Save</p>
            </button>
        </div>





    </form>

    {{-- <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
        integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>

    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script language="JavaScript" src="http://www.geoplugin.net/javascript.gp" type="text/javascript"></script> --}}
    <script type="text/javascript">
        mapboxgl.accessToken =
            'pk.eyJ1IjoiZG9uMjEiLCJhIjoiY2xramN3d2RkMHRsNzNwa2dmdnIyZnBxMiJ9.ZXAz_MdYN4tANHbAALm5KQ ';
        const map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v12',
            center: [36.059125, 36.340569],
            zoom: 7
        });
        map.on('click', (event) => {
            const coords = Object.keys(event.lngLat).map((key) => event.lngLat[key]);
            const end = {
                type: 'FeatureCollection',
                features: [{
                    type: 'Feature',
                    properties: {},
                    geometry: {
                        type: 'Point',
                        coordinates: coords
                    }
                }]
            };
            if (map.getLayer('end')) {
                map.getSource('end').setData(end);
            } else {
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
                                    coordinates: coords
                                }
                            }]
                        }
                    },
                    paint: {
                        'circle-radius': 10,
                        'circle-color': '#f30'
                    }
                });
            }
            // this method is made for the save button to first point
            document.getElementById('save-first-point').onclick = function(event) {
                document.getElementById('lat').value = coords[0];
                document.getElementById('lng').value = coords[1];

                document.getElementById('lat').style.display = 'none';
                document.getElementById('lng').style.display = 'none';


                document.getElementById('save-second-point').style.display = "block";
                document.getElementById('lat2').style.display = 'block';
                document.getElementById('lng2').style.display = 'block';
                document.getElementById('second-p').style.display = "block";
                document.getElementById('go-back').style.display = 'block';
                document.getElementById('save-first-point').style.display = "none";
                document.getElementById('first-p').style.display = "none";
                event.preventDefault();


            }
            //the method to reEnter the first point
            document.getElementById('go-back').onclick = function(event) {
                document.getElementById('lat').style.display = 'block';
                document.getElementById('lng').style.display = 'block';
                document.getElementById('save-first-point').style.display = "block";
                document.getElementById('first-p').style.display = "block";
                document.getElementById('second-p').style.display = "none";

                document.getElementById('save-second-point').style.display = "none";
                document.getElementById('lat2').style.display = 'none';
                document.getElementById('lng2').style.display = 'none';
                document.getElementById('go-back').style.display = 'none';
                event.preventDefault();
            }
            //this method to save the second point
            document.getElementById('save-second-point').onclick = function(event) {
                document.getElementById('lat2').value = coords[0];
                document.getElementById('lng2').value = coords[1];
                document.getElementById('lat2').style.display = 'none';
                document.getElementById('lng2').style.display = 'none';
                document.getElementById('save-second-point').style.display = 'none';
                document.getElementById('second-p').style.display = "none";
                document.getElementById('go-back2').style.display = 'block';
                event.preventDefault();

            }
            document.getElementById('go-back2').onclick = function(event) {
                document.getElementById('lat').style.display = 'none';
                document.getElementById('lng').style.display = 'none';
                document.getElementById('save-first-point').style.display = "none";
                document.getElementById('save-second-point').style.display = "block";
                document.getElementById('lat2').style.display = 'block';
                document.getElementById('lng2').style.display = 'block';
                document.getElementById('second-p').style.display = "block";
                document.getElementById('go-back2').style.display = 'none';
                event.preventDefault();
            }

        });


        // var map = L.map('map').setView([35.059125, 36.340569], 13);
        // googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
        //     maxZoom: 20,
        //     subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        // }).addTo(map);
        // L.Control.geocoder().addTo(map);



        // var circle = null;
        // map.on('click', function(e) {
        //     var coord = e.latlng.toString().split(',');
        //     let lat = coord[0].split('(');
        //     let lng = coord[1].split(')');
        //     console.log("You clicked the map at latitude: " + lat[1] + " and longitude:" + lng[0]);

        //     if (circle !== null) {
        //         map.removeLayer(circle);
        //     }
        //     circle = L.circle(e.latlng).addTo(map);







        // });
    </script>

</x-app-layout>
