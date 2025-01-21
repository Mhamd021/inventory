<tr>

  <td>{{ $user->name }}</td>
  <td>{{ $user->email }}</td>
  <td>{{ $user->created_at }}</td>
  <td><button class="btn"><a href="{{ route('profile.edit',$user) }}">edit </a></button> </td>
          </tr>
