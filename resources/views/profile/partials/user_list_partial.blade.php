<tr>

  <td>{{ $user->name }}</td>
  <td>{{ $user->email }}</td>
  <td>{{ $user->created_at }}</td>
  <td><a href="{{ route('profile.edit',$user) }}"><button class="btn">edit </button></a> </td>
          </tr>
