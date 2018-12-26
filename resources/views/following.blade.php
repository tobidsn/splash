@extends('layouts.profile')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Following') }}</div>
                <div class="card-body"> 
                    <div class="list-group">
                    @forelse ($list as $following)
                        <a href="{{ url('/' . $following->username) }}" class="list-group-item">
                            <h4 class="list-group-item-heading">{{ $following->name }}</h4>
                            <p class="list-group-item-text">{{ $following->username }}</p>
                        </a>
                    @empty
                        <p>No users</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection