<tr>

  <td>{{ $journey->headline }}</td>
  <td>{{ $journey->journey_charg }}</td>
  <td>{{ $journey->max_number }}</td>
  <td>{{ $journey->deleted_at }}</td>
  <td><button class="btn"><a href="{{ route('journey.restore',$journey->id) }}">restore </a></button> </td>
  <td><button class="btn"><a href="{{ route('journey.force_delete',$journey->id) }}">delete </a></button> </td>

          </tr>
