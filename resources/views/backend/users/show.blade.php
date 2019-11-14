@extends('backend.layouts.backend')
@section('content')
    <div class="card">
        <div class="card-header">
            <h2>{{$user}}</h2>
            <span class="text-muted">Member since: {{$user->created_at->diffForHumans()}}</span>
        </div>
        <div class="card-body row">
            <div class="col-6 border-right">
                <table class="table">
                    <tr>
                        <th>Email</th>
                        <td>{{$user->email}}</td>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <td>{{ucfirst(optional($user->profile)->gender)}}</td>
                    </tr>
                    <tr>
                        <th>DOB</th>
                        <td>{{optional($user->profile)->dob}}</td>
                    </tr>
                </table>
            </div>
            <div class="col-6">
            </div>
        </div>
    </div>
@endsection
