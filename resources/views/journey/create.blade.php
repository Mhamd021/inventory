@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="{{ asset('applayout.css') }}" type="text/css" media="all" />
   <title>journeys</title>
    <script src="https://api.tiles.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.js"></script>
    <link href="https://api.tiles.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.css" rel="stylesheet" />
    <form class="F" action="{{ route('journey.store') }}" method="post">
        @csrf
        <div class="create">
            <p>headline</p>
            <input class="form-input" type="text" name="headline" value="{{ old('headline') }}" required />
            @error('headline')
            <span class="invalid-feedback" role="alert">
                <strong style="color: red">{{ $message }}</strong>
            </span>
        @enderror
            <p>start-date</p>
            <input class="form-input" type="date" name="start_day" value="{{ old('start_day') }}" required />
            @error('start_day')
            <span class="invalid-feedback" role="alert">
                <strong style="color: red">{{ $message }}</strong>
            </span>
        @enderror
            <p>end-date</p>
            <input class="form-input" type="date" name="last_day" value="{{ old('last_day') }}" required />
            @error('last_day')
            <span class="invalid-feedback" role="alert">
                <strong style="color: red">{{ $message }}</strong>
            </span>
        @enderror
            <p>description</p>
            <input class="form-input" type="text" name="description" value="{{ old('description') }}" required />
            @error('description')
            <span class="invalid-feedback" role="alert">
                <strong style="color: red">{{ $message }}</strong>
            </span>
        @enderror
            <p>charg</p>
            <input class="form-input" type="number" name="journey_charg" value="{{ old('journey_charg') }}" required />
            @error('journey_charg')
            <span class="invalid-feedback" role="alert">
                <strong style="color: red">{{ $message }}</strong>
            </span>
        @enderror
            <p>max_number</p>
            <input class="form-input" type="number" name="max_number" value="{{ old('max_number') }}" required />
            @error('max_number')
            <span class="invalid-feedback" role="alert">
                <strong style="color: red">{{ $message }}</strong>
            </span>
        @enderror
            <div class="input-container">
                <button onclick="openMap('lat1', 'lng1')">point1</button>
               <div>
                <input type="text" id="lat1" placeholder="Latitude" name="start_lat" value="{{old('start_lat')}}" readonly required>
                @error('start_lat')
                <span class="invalid-feedback" role="alert">
                    <strong style="color: red">{{ $message }}</strong>
                </span>
            @enderror
                <input type="text" id="lng1" placeholder="Longitude" name="start_lng" value="{{old('start_lng')}}" readonly required>
                @error('start_lng')
                <span class="invalid-feedback" role="alert">
                    <strong style="color: red">{{ $message }}</strong>
                </span>
            @enderror
               </div>
            </div>

            <div class="input-container">
                <button onclick="openMap('lat2', 'lng2')">point2</button>
                <div>
                    <input type="text" id="lat2" placeholder="Latitude" name="end_lat" value="{{old('end_lat')}}" readonly>
                @error('end_lat')
                <span class="invalid-feedback" role="alert">
                    <strong style="color: red">{{ $message }}</strong>
                </span>
            @enderror
                <input type="text" id="lng2" placeholder="Longitude" name="end_lng" value="{{old('end_lng')}}" readonly>
                @error('end_lng')
                <span class="invalid-feedback" role="alert">
                    <strong style="color: red">{{ $message }}</strong>
                </span>
            @enderror
                </div>
            </div>

            <div id="mapModal" class="modal">
                <div class="modal-content">

                    <p>Please Choose your point on the map</p>
                    <div id="map" class="map-container"></div>
                    <button id="saveButton" onclick="savePoint()">Save Point</button>
                </div>
            </div>
            <div class="save_cancel">
                <button class="save" type="submit"> <i style="color: white" class="fas fa-check-circle"> &nbsp;</i>save </button>
                <button class="cancel" type="submit"><i style="color: white" class="fas fa-times-circle"></i><a style="text-decoration: none; color:white"
                        href="{{ route('dashboard') }}"> cancel</a></button>
            </div>

        </div>

    </form>
    <script type="text/javascript">
        let marker;

        function openMap(latInputId, lngInputId) {
            const latField = document.getElementById(latInputId);
            const lngField = document.getElementById(lngInputId);
            document.getElementById('mapModal').style.display = 'flex';
            event.preventDefault();

            mapboxgl.accessToken =
                'pk.eyJ1IjoiZG9uMjEiLCJhIjoiY20yOTZtMjhoMDB3YzJqczc2YWhtenJrNiJ9.IKwkfvJWrxOZkYBlwsAhNA';
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
                latField.value = coords[1];
                lngField.value = coords[0];
            });


        }

        function savePoint() {
            document.getElementById('mapModal').style.display = 'none';
            event.preventDefault();
        }
    </script>
@endsection
