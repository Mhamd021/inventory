<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Journey
        </h2>
    </x-slot>
    {{-- <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
        integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" /> --}}
    <script src="https://api.tiles.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.js"></script>
    <link href="https://api.tiles.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('test.css') }}">

    <form class="F" action="{{ route('journey.update', $journey) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="parent">
            <div class="first">
                <div class="coord">
                    <h1 style="color: #78c6ad">Specifing the road</h1><br>
                    <h1> please enter the first and the second point from the map </h1><br>
                    <p class="text-gray-700" id="first-p"> first point</p>
                    <input class="input" name="start_lat" type="text" id="lat"
                        value="{{ $journey->start_point->latitude }}" required><br>

                    <input class="input" name="start_lng" type="text" id="lng"
                        value="{{ $journey->start_point->longitude }}" required><br>
                    <button hidden id="go-back" class="btn-primary">
                        <p style="color: white">Go_back</p>
                    </button>
                    <button id="save-first-point" class="btn-primary" >
                        <p style="color: white">Save</p>
                    </button>
                    <p hidden id="map-message">please enter a point on the map to change the values</p>
                    <p hidden class="text-gray-700" id="second-p"> second point</p>
                    <input class="input" hidden name="end_lat" type="text" id="lat2"
                        value="{{ $journey->end_point->latitude }}" required><br>
                    <input class="input" hidden name="end_lng" type="text" id="lng2"
                        value="{{ $journey->end_point->longitude }}" required><br>
                    <button hidden id="save-second-point" class="btn-primary">
                        <p style="color: white">Save</p>
                    </button>
                    <button hidden class="btn-primary" id="go-back2">
                        <p style="color: white">Go_back2</p>
                    </button>
                </div>
                <div id="map" class="map"></div>

            </div>
            <div class="second">
                <div class="left">
                    <h1 style="color: #78c6ad">Editing journey information</h1><br>
                    <p>Headline</p>
                    <input class="input" type="text" name="headline" value="{{ $journey->headline }}" required><br>

                    <p>Start Date</p>
                    <input class="input" type="date" name="start_day" value="{{ $journey->start_day }}"
                        required><br>

                    <p>End Date</p>

                    <input class="input" type="date" name="last_day" value="{{ $journey->last_day }}" required><br>

                    <button type="submit" class="btn-primary" >
                        <p style="color: white">Save Journey</p>
                    </button>
                    {{-- <x-primary-button>{{ __('Save Journey') }}</x-primary-button> --}}


                </div>
                <div class="right">
                    <h1 style="color: #78c6ad">Click the Save button after you finish editing</h1><br>

                    <p>Description</p>
                    <input class="input" type= "text" name="description" value="{{ $journey->description }}"
                        required><br>

                    <p>journey charg</p>
                    <input class="input" type="number" name="journey_charg" value="{{ $journey->journey_charg }}"
                        required><br>


                    <p>Max Number</p>
                    <input class="input" type="number" name="max_number" value="{{ $journey->max_number }}"
                        required><br>

                </div>
            </div>



        </div>
        {{-- <button class="btn-cancel"><a href="{{ route('journey.show', compact('journey')) }}">Cancel</a></button> --}}
    </form>

    <form class="F" action="{{ route('journey.destroy', $journey) }}" method="POST">
        @csrf
        @method('delete')
        <div class="delete">
            <div class="delete2">
                <h1 class="deleteh1">
                    Delete journey
                </h1><br>
                <p>you can find deleted journeys in trashed folder and restore it</p><br>
                <button type="submit" class="btn-delete" >
                    <p style="color: white">Delete Journey</p>
                </button>
            </div>

        </div>

    </form>
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
                document.getElementById('go-back').style.display = 'block';
                document.getElementById('save-first-point').style.display = "none";
                event.preventDefault();


            }
            //the method to reEnter the first point
            document.getElementById('go-back').onclick = function(event) {
                document.getElementById('lat').style.display = 'block';
                document.getElementById('lng').style.display = 'block';
                document.getElementById('save-first-point').style.display = "block";
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
                document.getElementById('go-back2').style.display = 'none';
                event.preventDefault();
            }

        });


    </script>
    

</x-app-layout>
