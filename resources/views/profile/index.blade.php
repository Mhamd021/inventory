@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{asset('css/table.css')}}" type="text/css" media="all" />

<title>Users</title>
    <div class="parent">
    <main class="table">
        <section class="table__header">
            <center><h1>Users</h1></center>
         </section>
      <section class="table__body">
        <table>
          <thead>
            <tr>
              <th>name</th>
              <th>email</th>
              <th>created-at</th>
              <th>edit</th>
            </tr>
          </thead>
        <tbody>
        @each('profile.partials.user_list_partial', $users, 'user','profile.partials.user_list_noItems')
        </tbody>
      </table>
      </section>
    </main>
</div>
@endsection
