@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                {{ $user->name }} <br>
                {{ $user->email }}
            </div>
            <div class="col-md-8">

                <form class="form-horizontal" role="form" action="{{ url('settings') }}" method="POST">

                    {!! csrf_field() !!}

                    <div class="form-group{{ $errors->has('oldpassword') ? ' has-error' : '' }}">
                        <label for="oldpassword" class="col-md-4 control-label">Old Password</label>

                        <div class="col-md-6">
                            <input id="oldpassword" type="oldpassword" class="form-control" name="oldpassword">

                            @if ($errors->has('oldpassword'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('oldpassword') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label">Password</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="password">

                            @if ($errors->has('password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <!--  Form Input -->
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button class="btn btn-primary" type="submit">Change password</button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection