@extends('layouts.app')
@section('content')

@vite(['resources/js/app.js', 'resources/css/app.css'])
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://api.tiles.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.js"></script>
    <link href="https://api.tiles.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.css" rel="stylesheet" />
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
                    <div class="save_cancel">
                        <button type="button" class="save" id="saveButton" onclick="closeModal('mapModal')">save</button>
                        <button type="button" class="cancel" onclick="closeModal('mapModal')">close</button>

                    </div>
                </div>
            </div>
            <div class="save_cancel">
                <button style="color: white" class="save" type="submit"><i style="color: white"
                        class="fas fa-check-circle">&nbsp;</i> save</button>

                <a style="text-decoration: none ; color:white" href="{{ route('dashboard') }}">
                    <button class="cancel" type="button">
                        <i style="color: white" class="fas fa-times-circle"></i> cancel </button>
                </a>

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

@endsection
