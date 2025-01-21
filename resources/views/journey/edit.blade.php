@extends('layouts.app')
@section('content')
    <script src="https://api.tiles.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.js"></script>
    <link href="https://api.tiles.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        img
        {
            border-radius: 5px;
            margin-bottom: 10px;
            border: 1px solid white;
            box-shadow: 3px 3px 8px grey;
            margin-top: 20px;
        }
    </style>
    <title>journeys</title>
    <form class="F" action="{{ route('journey.update', $journey) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="create">
            <p>headline</p>
            <input class="form-input" type="text" name="headline" value= "{{ $journey->headline }}" required />
            @error('headline')
                <span class="invalid-feedback" role="alert">
                    <strong style="color: red">{{ $message }}</strong>
                </span>
            @enderror
            <p>start-date</p>
            <input class="form-input" type="date" name="start_day" value="{{ $journey->start_day }}" required />
            @error('start_day')
                <span class="invalid-feedback" role="alert">
                    <strong style="color: red">{{ $message }}</strong>
                </span>
            @enderror
            <p>end-date</p>
            <input class="form-input" type="date" name="last_day" value="{{ $journey->last_day }}" required />
            @error('last_day')
                <span class="invalid-feedback" role="alert">
                    <strong style="color: red">{{ $message }}</strong>
                </span>
            @enderror
            <p>description</p>
            <input class="form-input" type="text" name="description" value="{{ $journey->description }}" required />
            @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong style="color: red">{{ $message }}</strong>
                </span>
            @enderror
            <p>charg</p>
            <input class="form-input" type="number" name="journey_charg" value="{{ $journey->journey_charg }}" required />
            @error('journey_charg')
                <span class="invalid-feedback" role="alert">
                    <strong style="color: red">{{ $message }}</strong>
                </span>
            @enderror
            <p>max_number</p>
            <input class="form-input" type="number" name="max_number" value="{{ $journey->max_number }}" required />
            

            <p>points</p>
            <div class="input-container">
                <div id="points">
                    @foreach ($journey->points as $index => $point)
                        <div class="point" id="point-{{ $index }}">
                            <input type="hidden" name="points[{{ $index }}][id]" value="{{ $point->id }}">
                            <input type="text" name="points[{{ $index }}][point_description]"
                                value="{{ $point->point_description }}" placeholder="Description" required>
                            <button class="cancel" type="button"
                                onclick="openMap('lat{{ $index }}', 'lng{{ $index }}')">location</button>
                            <input type="text" id="lat{{ $index }}" name="points[{{ $index }}][latitude]"
                                value="{{ $point->location->latitude }}" placeholder="Latitude" readonly>
                            <input type="text" id="lng{{ $index }}"
                                name="points[{{ $index }}][longitude]" value="{{ $point->location->longitude }}"
                                placeholder="Longitude" readonly>
                                @if ($point->image)
                                <img src="{{ asset($point->image) }}" alt="Current Image" style=" height: 75px; width: 75px;">
                            @endif
                            <input type="file" name="points[{{ $index }}][image]">

                            <button class="cancel" type="button"
                                onclick="removePoint({{ $point->id }}, {{ $index }})">remove</button>
                        </div>
                    @endforeach
                </div>
                <button class="save" type="button" onclick="addPoint()">add point</button>
            </div>

            <div id="mapModal" class="modal">
                <div class="modal-content">
                    <p>Please Choose your point on the map</p>
                    <div id="map" class="map-container"></div>
                    <button id="saveButton" onclick="savePoint()">Save Point</button>
                </div>
            </div>
            <div class="save_cancel">
                <button style="color: white" class="save" type="submit"><i style="color: white"
                        class="fas fa-check-circle">&nbsp;</i> save</button>

                <button class="cancel" type="button"><i style="color: white" class="fas fa-times-circle"></i><a
                        style="text-decoration: none ; color:white" href="{{ route('dashboard') }}"> cancel</a></button>

                <button class="delete" type="button" onclick="deletejourney({{ $journey->id }})"><i
                        style="color: white" class="fas fa-times-circle"></i> delete</button>

            </div>

        </div>

    </form>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
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
            map.on('click', (event) =>
            {
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

        function savePoint()
        {
            document.getElementById('mapModal').style.display = 'none';
            event.preventDefault();
        }

        function addPoint() {
            let index = document.querySelectorAll('.point').length;
            let pointHtml =
                ` <div class="point" id="point-${index}">
                    <input type="text" name="points[${index}][point_description]" placeholder="Description" required>
                     <button class="cancel" onclick="openMap('lat${index}', 'lng${index}')">location</button>
                      <input type="text" id="lat${index}" name="points[${index}][latitude]" placeholder="Latitude" readonly>
                      <input type="text" id="lng${index}" name="points[${index}][longitude]" placeholder="Longitude" readonly>
                        <input type="file" name="points[${index}][image]">
                         <button class="cancel" type="button" onclick=" removePoint(null,${index})" >remove</button>
                       </div> `;
            document.getElementById('points').insertAdjacentHTML('beforeend', pointHtml);
        }

        function removePoint(pointId, index)
         {
            if (pointId !== null)
            {
                $.ajax({
                    url: `/points/${pointId}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        if (response.success) {
                            document.getElementById(`point-${index}`).remove();
                        } else {
                            alert('Failed to delete the point.');
                        }
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseText);
                    }
                });
            }
            else
            {
                document.getElementById(`point-${index}`).remove();
            }
        }

        function deletejourney(journeyId)
        {
            const form = $('<form>' ,
                {
                    method : 'POST',
                    action : `/journey/${journeyId}`,
                });
                form.append($('<input>' ,
                {
                    type : 'hidden',
                    name : '_token',
                    value: '{{ csrf_token() }}'
                } ));
                form.append($('<input>' ,
                {
                    type : 'hidden',
                    name : '_method',
                    value : 'DELETE'
                }));
                $('body').append(form);
        if (confirm(`Are you sure you want to delete this journey`)) {
            form.submit();
        }
        }
    </script>
@endsection
