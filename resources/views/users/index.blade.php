@extends('layouts.app')
@section('title','User management')
@section('heading','User management')
@section('content')
<div class="page-toolbar"><div><h2>System accounts</h2><p class="muted">Manage authorized DOCUARCH users and their access roles.</p></div><a class="btn primary" href="{{ route('users.create') }}">＋ Add user</a></div>
<div class="panel"><div class="table-wrap"><table><thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Office</th><th></th></tr></thead><tbody>@forelse($users as $user)<tr><td>{{ $user->name }}</td><td>{{ $user->email }}</td><td><span class="type-pill {{ $user->role }}">{{ ucfirst($user->role) }}</span></td><td>{{ $user->office ?: '—' }}</td><td><a class="icon-link" href="{{ route('users.edit',$user) }}">Edit</a> @if($user->id !== auth()->id())<form class="inline-form" method="POST" action="{{ route('users.destroy',$user) }}" onsubmit="return confirm('Delete this user account?')">@csrf @method('DELETE')<button class="link-danger">Delete</button></form>@endif</td></tr>@empty<tr><td colspan="5" class="empty">No users found.</td></tr>@endforelse</tbody></table></div><div class="pagination">{{ $users->links() }}</div></div>
@endsection
