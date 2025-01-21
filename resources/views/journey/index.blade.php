    @extends('layouts.app')
    @section('content')
    <link rel="stylesheet" href="{{asset('css/table.css')}}" type="text/css" media="all" />
    <title>journeys</title>
    <div class="parent">
    <main class="table">
        <section class="table__header">
           <center><h1>All journeys</h1></center>
        </section>
        <section class="table__body">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Charg</th>
                        <th>Max_Number</th>
                        <th>Created_at</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                 @each('journey.partials.journey_list_partial',$journeys ,'journey','journey.partials.journey_list_noItems')
                </tbody>
            </table>
            {{$journeys->links()}}
        </section>
    </main>
</div>
@endsection





