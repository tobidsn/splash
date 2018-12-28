@extends('layouts.profile')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Tweets') }}</div>
                <div class="card-body"> 
                    <div class="list-group">
                    @forelse ($user->tweets()->get() as $tweet)
                        <a href="#" class="list-group-item">
                            <h4 class="list-group-item-heading">{{ $tweet->body }}</h4>
                            <p class="list-group-item-text">{{ $tweet->created_at }}</p>
                        </a>
                    @empty
                        <p>No tweet</p>
                    @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection