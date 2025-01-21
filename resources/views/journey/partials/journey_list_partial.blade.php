<tr>
    <td><a class="journey" href="{{ route('journey.show', $journey) }}"> {{ $journey->headline }} </a> </td>
    <td>{{ $journey->journey_charg }}</td>
    <td>{{ $journey->max_number }}</td>
    <td>{{ $journey->created_at }}</td>
    <td><button class="btn"><a href="{{ route('journey.edit', $journey) }}">edit </a></button> </td>
</tr>
