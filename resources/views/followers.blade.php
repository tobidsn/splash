@extends('layouts.profile')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Followers') }}</div>
                <div class="card-body"> 
                    <div class="list-group">
                    @forelse ($list as $followers)
                        <a href="{{ url('/' . $followers->username) }}" class="list-group-item">
                            <h4 class="list-group-item-heading">{{ $followers->name }}</h4>
                            <p class="list-group-item-text">{{ $followers->username }}</p>
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