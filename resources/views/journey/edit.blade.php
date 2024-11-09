@extends('layouts.app')
@section('content')
    <script src="https://api.tiles.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.js"></script>
    <link href="https://api.tiles.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.css" rel="stylesheet" />


    <form class="F" action="{{ route('journey.update', $journey) }}" method="POST">
        @csrf
        @method('PUT')
    <div class="create">
        <p>headline</p>
        <input class="form-input" type="text" name="headline" value= "{{$journey->headline}}" required />
        @error('headline')
        <span class="invalid-feedback" role="alert">
            <strong style="color: red">{{ $message }}</strong>
        </span>
    @enderror
        <p>start-date</p>
        <input class="form-input" type="date" name="start_day" value="{{$journey->start_day}}" required />
        @error('start_day')
        <span class="invalid-feedback" role="alert">
            <strong style="color: red">{{ $message }}</strong>
        </span>
    @enderror
        <p>end-date</p>
        <input class="form-input" type="date" name="last_day" value="{{$journey->last_day}}" required />
        @error('last_day')
        <span class="invalid-feedback" role="alert">
            <strong style="color: red">{{ $message }}</strong>
        </span>
    @enderror
        <p>description</p>
        <input class="form-input" type="text" name="description" value="{{$journey->description}}" required />
        @error('description')
        <span class="invalid-feedback" role="alert">
            <strong style="color: red">{{ $message }}</strong>
        </span>
    @enderror
        <p>charg</p>
        <input class="form-input" type="number" name="journey_charg" value="{{ $journey->journey_charg}}" required />
        @error('journey_charg')
        <span class="invalid-feedback" role="alert">
            <strong style="color: red">{{ $message }}</strong>
        </span>
    @enderror
        <p>max_number</p>
        <input class="form-input" type="number" name="max_number" value="{{ $journey->max_number}}" required />
        @error('max_number')
        <span class="invalid-feedback" role="alert">
            <strong style="color: red">{{ $message }}</strong>
        </span>
    @enderror
        <div class="input-container">
            <button style="color: white" onclick="openMap('lat1', 'lng1')">point1</button>
           <div>
            <input type="text" id="lat1" placeholder="Latitude" name="start_lat" value="{{ $journey->start_point->latitude }}" readonly required>
            @error('start_lat')
            <span class="invalid-feedback" role="alert">
                <strong style="color: red">{{ $message }}</strong>
            </span>
        @enderror
            <input type="text" id="lng1" placeholder="Longitude" name="start_lng" value="{{ $journey->start_point->longitude }}" readonly required>
            @error('start_lng')
            <span class="invalid-feedback" role="alert">
                <strong style="color: red">{{ $message }}</strong>
            </span>
        @enderror
           </div>
        </div>

        <div class="input-container">
            <button style="color: white" class="save" onclick="openMap('lat2', 'lng2')">point2</button>
            <div>
                <input type="text" id="lat2" placeholder="Latitude" name="end_lat" value="{{ $journey->end_point->latitude }}" readonly>
            @error('end_lat')
            <span class="invalid-feedback" role="alert">
                <strong style="color: red">{{ $message }}</strong>
            </span>
        @enderror
            <input type="text" id="lng2" placeholder="Longitude" name="end_lng" value="{{ $journey->end_point->longitude }}" readonly>
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
            <button style="color: white" class="save" type="submit"><i style="color: white" class="fas fa-check-circle">&nbsp;</i> save</button>
            <button class="cancel" type="button"><i style="color: white" class="fas fa-times-circle"></i><a style="text-decoration: none ; color:white"
                    href="{{ route('dashboard') }}"> cancel</a></button>
                    <form class="F" action="{{ route('journey.destroy', $journey) }}" method="POST">
                        @csrf
                        @method('delete')
                                <button type="submit" class="save" >
                                    <i class="fas fa-trash"></i>  delete
                                </button>


                    </form>
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

