@extends('layouts.app')
@section('content')

@vite(['resources/js/app.js', 'resources/css/app.css'])
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                    <button title="add point" class="save" type="button" onclick="addPoint()"><i class="fas fa-plus-circle" ></i> point</button>
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
                    <div class="save_cancel">
                        <button class="save"  type="button"  id="saveButton" onclick="closeModal('mapModal')">Save</button>
                        <button type="button" class="cancel" onclick="closeModal('mapModal')">close</button>
                    </div>
                </div>
            </div>
            <div class="save_cancel">
                <button class="save" type="submit"> <i style="color: white" class="fas fa-check-circle"> &nbsp;</i>save
                </button>
                <i style="color: white" class="fas fa-times-circle"></i><a
                        style="text-decoration: none; color:white" href="{{ route('dashboard') }}"><button class="cancel" type="button"> cancel </button></a>
            </div>

        </div>

    </form>

@endsection
