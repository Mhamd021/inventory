@extends('layouts.app')
@section('content')
    <title>journeys</title>
    <script src="https://api.tiles.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.js"></script>
    <link href="https://api.tiles.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.css" rel="stylesheet" />
    <form class="F" action="{{ route('journey.store') }}" method="post" enctype="multipart/form-data">
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
            <p>points</p>
                <div class="input-container">
                    <div id="points"></div>
                    <button class="save" type="button" onclick="addPoint()">add point</button>
                </div>


            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <div id="mapModal" class="modal">
                <div class="modal-content">

                    <p>Please Choose your point on the map</p>
                    <div id="map" class="map-container"></div>
                    <button  id="saveButton" onclick="savePoint()">Save Point</button>
                </div>
            </div>
            <div class="save_cancel">
                <button class="save" type="submit"> <i style="color: white" class="fas fa-check-circle"> &nbsp;</i>save
                </button>
                <button class="cancel" type="button"><i style="color: white" class="fas fa-times-circle"></i><a
                        style="text-decoration: none; color:white" href="{{ route('dashboard') }}"> cancel</a></button>
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

        function addPoint() {
            let index = document.querySelectorAll('.point').length;
            let pointHtml =
                ` <div class="point" id="point-${index}">
                    <input type="text" name="points[${index}][point_description]" placeholder="Description" value="{{ old('points[${index}][point_description]') }}" required>
                     <button class="cancel" onclick="openMap('lat${index}', 'lng${index}')">location</button>
                      <input type="text" id="lat${index}" name="points[${index}][latitude]" placeholder="Latitude" value="{{ old('points[${index}][latitude]') }}" readonly>
                      <input type="text" id="lng${index}" name="points[${index}][longitude]" placeholder="Longitude" value="{{ old('points[${index}][longitude]') }}" readonly>
                         <input type="file" name="points[${index}][image]" value="{{ old('points[${index}][image]') }}">
                         <button class="cancel" type="button" onclick="removePoint(${index})">remove</button>
                       </div> `;
            document.getElementById('points').insertAdjacentHTML('beforeend', pointHtml);
        }

        function removePoint(index)
         {
            let point = document.getElementById(`point-${index}`);
             point.remove();

         }
    </script>
@endsection
