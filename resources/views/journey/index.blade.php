<x-app-layout>

    <link rel="stylesheet" href="{{asset('table.css')}}">
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



                    @foreach ($journeys as $journey)
                        <tr>

                            <td><a href="{{ route('journey.show', $journey) }}"> {{ $journey->headline }} </a> </td>
                            <td>{{ $journey->journey_charg }}</td>
                            <td>{{ $journey->max_number }}</td>
                            <td>{{ $journey->created_at }}</td>
                            <td><button class="btn"><a href="{{ route('journey.edit', $journey) }}">edit </a></button> </td>

                        </tr>
                    @endforeach

                </tbody>

            </table>
            {{$journeys->links()}}
        </section>
    </main>
</div>


</x-app-layout>




