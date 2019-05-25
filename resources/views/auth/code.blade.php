@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                 <div class="card">
                     <div class="card-header">
                          <h2>SMS Security Code</h2>
                     </div>
                     <div class="card-body">
                         @include("partials.errors")

                         <form class="form-horizontal" role="form" method="POST" action="{{ url('/code') }}">
                             {{ csrf_field() }}

                             <div class="form-group">
                                 <label for="code" class="col-md-4 control-label">Four Digit Code</label>

                                 <div class="col-md-6">
                                     <input id="code" type="text" class="form-control" name="code" value="{{ old('code') }}" required autofocus>

                                     @if ($errors->has('code'))
                                         <span class="help-block">
                                        <strong>{{ $errors->first('code') }}</strong>
                                    </span>
                                     @endif
                                 </div>
                             </div>

                             <div class="form-group">
                                 <div class="col-md-8 col-md-offset-4">
                                     <button type="submit" class="btn btn-primary">
                                         Login
                                     </button>
                                 </div>
                             </div>
                         </form>
                     </div>
                 </div>
            </div>
        </div>
    </div>
@endsection