@extends('backend.layouts.backend')
@section('content')
    <div class="card">
        <div class="card-header">
            <h2>Users</h2>
        </div>
        <div class="card-body">
            <table class="table">
                <tr>
                    <th>Name</th>
                    <th class="text-center">Member since</th>
                    <th class="text-center">Action</th>
                </tr>
                @forelse($users as $user)
                    <tr>
                        <td><a href="{{route('backend.user.show', $user->id)}}">{{$user}}</a></td>
                        <td class="text-center">{{$user->created_at->diffForHumans()}}</td>
                        <td class="text-center">
                            <a href="{{route('backend.user.show', $user->id)}}"><span class="ti-eye"></span></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td><h3 class="text-muted text-center">NO USER YET</h3></td>
                    </tr>
                @endforelse
            </table>
        </div>
    </div>
@endsection
