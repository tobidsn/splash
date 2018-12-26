<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta id="token" name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>

    <style type="text/css">
        .no-bottom {
            bottom: 0;
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <nav class="navbar navbar-light" style="background-color: #e3f2fd;">
            <div class="container">
                <div class="col-md-2">
                    .
                </div>
            </div>
        </nav>
        <nav class="navbar navbar-light card">
            <div class="container">
                <div class="col-md-2">
                    <ul class="nav"> 
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ url('/' . $user->username) }}">
                                <strong>{{ $user->name }}</strong>
                                <small>&#64;{{ $user->username }}</small>
                            </a>
                        </li>
                    </ul>    
                </div>

                <div class="col-md-8">

                  <ul class="nav text-center"> 
                    <li class="nav-item">
                        <a class="nav-link {{ !Route::currentRouteNamed('profile') ?: 'active' }}" href="{{ url('/' . $user->username) }}">
                            <div class="text-uppercase">Tweets</div>
                            <div>0</div>
                        </a>
                    </li>
                    @if ($is_edit_profile)
                    <li class="nav-item">
                        <a class="nav-link {{ !Route::currentRouteNamed('following') ?: 'active' }}" href="{{ url('/following') }}">
                            <div class="text-uppercase">Following</div>
                            <div>{{ $following_count }}</div>
                        </a>
                    </li>
                    @endif                
                    <li class="nav-item">
                        <a class="nav-link {{ !Route::currentRouteNamed('followers') ?: 'active' }}" href="{{ url('/' . $user->username . '/followers') }}">
                            <div class="text-uppercase">Followers</div>
                            <div>{{ $followers_count }}</div>
                        </a>
                    </li>
                  </ul>
                </div>

                <div class="col-md-2">
                    @if (Auth::check())
                        @if ($is_edit_profile)
                            <a href="#" class="navbar-btn navbar-right">
                                <button type="button" class="btn btn-default">Edit Profile</button>
                            </a>
                        @else
                            <button type="button" v-on:click="follows" class="navbar-btn navbar-right btn btn-default">@{{ followBtnText }}</button>
                        @endif
                    @endif
                </div>
            </div>
        </nav>
        </br>
        @yield('content')
    </div>

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
    <script src="https://unpkg.com/vue@2.5.21/dist/vue.js"></script>
    <script src="https://unpkg.com/vue-resource@1.2.0/dist/vue-resource.min.js"></script>
    
    <script>
        new Vue({
            el: '#app',
            data: {
                username: '{{ $user->username }}',
                isFollowing: {{ $is_following ? 1 : 0 }},
                followBtnTextArr: ['Follow', 'Unfollow'],
                followBtnText: ''
            },
            methods: {
                follows: function (event) {
                    var csrfToken = Laravel.csrfToken;
                    var url = this.isFollowing ? '/unfollows' : '/follows';
                    this.$http.post(url, {
                        'username': this.username
                    }, {
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(response => {
                        var data = response.body;
                        if (!data.status) {
                            alert(data.message);
                            return;
                        }
                        this.toggleFollowBtnText();
                    });
                },
                toggleFollowBtnText: function() {
                    this.isFollowing = (this.isFollowing + 1) % this.followBtnTextArr.length;
                    this.setFollowBtnText();
                },
                setFollowBtnText: function() {
                    this.followBtnText = this.followBtnTextArr[this.isFollowing];
                }
            },
            mounted: function() {
                this.setFollowBtnText();
            }
        });
    </script>
</body>
</html>