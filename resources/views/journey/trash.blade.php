@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="{{asset('table.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">



    <div class="parent">
    <main class="table">
        <section class="table__header">
            <center><h1>Trashed journeys</h1></center>
         </section>
      <section class="table__body">
        <table>
          <thead>
            <tr>
              <th>Name</th>
              <th>Charg</th>
              <th>Max_Number</th>
              <th>deleted_at</th>
              <th>Restore</th>
              <th>Delete</th>
            </tr>
          </thead>
        <tbody>


        @if ($trashed_journeys->count() != null)
  @foreach ($trashed_journeys as $journey)
<tr>

  <td>{{ $journey->headline }}</td>
  <td>{{ $journey->journey_charg }}</td>
  <td>{{ $journey->max_number }}</td>
  <td>{{ $journey->deleted_at }}</td>
  <td><button class="btn"><a href="{{ route('journey.restore',$journey->id) }}">restore </a></button> </td>
  <td><a href="{{ route('journey.force_delete',$journey->id) }}"><i class="fa fa-trash-o" style="font-size:36px;color: #3c8eb4c3"></i>
  </a> </td>


          </tr>
@endforeach
@else
<td>there is no trash <i class="fas fa-trash"></i></td>
@endif
        </tbody>
      </table>
      </section>
    </main>


</div>

@endsection

