@extends('layouts.front')

@section('content')
    <div class="container">
        <hr color="#c0c0c0">
        <div class="row">
            <div class="post">
                <div class="text">
                    <h2>プロフィールの確認</h2>
                    <div class="name">
                        {{ $profiles[0]->name }}
                    </div>
                    <div class="gender">
                        {{ $profiles[0]->gender }}
                    </div>
                    <div class="hobby">
                        {{ $profiles[0]->hobby }}
                    </div>
                    <div class="introduction">
                        {{ $profiles[0]->introduction }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
