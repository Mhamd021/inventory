@extends('layouts.app')
@section('content')
<title>journeys</title>
<link rel="stylesheet" href="{{asset('css/table.css')}}" type="text/css" media="all" />
    <div class="parent">
    <main class="table">
        <section class="table__header">
            <center><h1>Trashed journeys</h1></center>
         </section>
      <section class="table__body">
        <table>
          <thead>
            <tr>
              <th>name</th>
              <th>charg</th>
              <th>max_Number</th>
              <th>deleted_at</th>
              <th>restore</th>
              <th>delete</th>
            </tr>
          </thead>
        <tbody>
            @each('journey.partials.journey_trash_list',$trashed_journeys ,'journey','journey.partials.journey_trash_noItems' )

        </tbody>
      </table>
      </section>
    </main>
</div>
@endsection

