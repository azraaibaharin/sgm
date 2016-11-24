@extends('layouts.admin')

@section('content')
<form class="form-horizontal" role="form" method="POST" action="{{ url('/home/edit') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="container">
        <div class="row">
            {{-- Nuna --}}
            <div class="col-md-8 col-md-offset-2">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success" role="alert">{{ $message }}</div>
                @endif
                <div class="panel panel-default">
                    <div class="panel-heading">Nuna</div>
                    <div class="panel-body">
                        <div class="form-group{{ $errors->has('nuna_text') ? ' has-error' : '' }}">
                            <label for="nuna_text" class="col-md-2 control-label">Text</label>

                            <div class="col-md-9">
                                <textarea id="nuna_text" class="form-control" name="nuna_text" rows="3" required autofocus>{{ old('nuna_text') ? old('nuna_text') : $nuna_text }}</textarea>

                                @if ($errors->has('nuna_text'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nuna_text') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('nuna_img') ? ' has-error' : '' }}">
                            <label for="nuna_img" class="col-md-2 control-label">Image</label>

                            <div class="col-md-9">
                                @if ($nuna_img)
                                    <img src="{{ asset('img/'.$nuna_img) }}" class="img-thumbnail" alt="">
                                @endif

                                <input id="nuna_img" type="file" class="form-control" name="nuna_img" autofocus>
                                <small>* for a nice look, minimum size: 735px x 500px</small>
        
                                @if ($errors->has('nuna_img'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nuna_img') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Babyhood --}}
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Babyhood</div>
                    <div class="panel-body">
                        <div class="form-group{{ $errors->has('babyhood_text') ? ' has-error' : '' }}">
                            <label for="babyhood_text" class="col-md-2 control-label">Text</label>

                            <div class="col-md-9">
                                <textarea id="babyhood_text" class="form-control" name="babyhood_text" rows="3" required autofocus>{{ old('babyhood_text') ? old('babyhood_text') : $babyhood_text }}</textarea>

                                @if ($errors->has('babyhood_text'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('babyhood_text') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('babyhood_img') ? ' has-error' : '' }}">
                            <label for="babyhood_img" class="col-md-2 control-label">Image</label>

                            <div class="col-md-9">
                                @if ($babyhood_img)
                                    <img src="{{ asset('img/'.$babyhood_img) }}" class="img-thumbnail" alt="">
                                @endif

                                <input id="babyhood_img" type="file" class="form-control" name="babyhood_img" autofocus>
                                <small>* for a nice look, minimum size: 735px x 500px</small>

                                @if ($errors->has('babyhood_img'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('babyhood_img') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- About --}}
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">About</div>
                    <div class="panel-body">
                        <div class="form-group{{ $errors->has('about_text') ? ' has-error' : '' }}">
                            <label for="about_text" class="col-md-2 control-label">Text</label>

                            <div class="col-md-9">
                                <textarea id="about_text" class="form-control" name="about_text" required autofocus rows="6">{{ old('about_text') ? old('about_text') : $about_text }}</textarea>

                                @if ($errors->has('about_text'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('about_text') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Tagline --}}
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Tagline</div>
                    <div class="panel-body">
                        <div class="form-group{{ $errors->has('tagline_title') ? ' has-error' : '' }}">
                            <label for="tagline_title" class="col-md-2 control-label">Title</label>

                            <div class="col-md-9">
                                <input id="tagline_title" type="text" class="form-control" name="tagline_title" value="{{ old('tagline_title') ? old('tagline_title') : $tagline_title }}" required autofocus />

                                @if ($errors->has('tagline_title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tagline_title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('tagline_text') ? ' has-error' : '' }}">
                            <label for="tagline_text" class="col-md-2 control-label">Text</label>

                            <div class="col-md-9">
                                <textarea id="tagline_text" class="form-control" name="tagline_text" rows="6" autofocus>{{ old('tagline_text') ? old('tagline_text') : $tagline_text }}</textarea>

                                @if ($errors->has('tagline_text'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tagline_text') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('tagline_img') ? ' has-error' : '' }}">
                            <label for="tagline_img" class="col-md-2 control-label">Image</label>

                            <div class="col-md-9">
                                @if ($tagline_img)
                                    <img src="{{ asset('img/'.$tagline_img) }}" class="img-thumbnail" alt="">
                                @endif

                                <input id="tagline_img" type="file" class="form-control" name="tagline_img" autofocus>
                                <small>* maximum image height is 300px</small>

                                @if ($errors->has('tagline_img'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tagline_img') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Event --}}
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Event</div>
                    <div class="panel-body">
                        <div class="form-group{{ $errors->has('event_title') ? ' has-error' : '' }}">
                            <label for="event_title" class="col-md-2 control-label">Title</label>

                            <div class="col-md-9">
                                <input id="event_title" type="text" class="form-control" name="event_title" value="{{ old('event_title') ? old('event_title') : $event_title }}" required autofocus>

                                @if ($errors->has('event_title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('event_title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('event_text') ? ' has-error' : '' }}">
                            <label for="event_text" class="col-md-2 control-label">Text</label>

                            <div class="col-md-9">
                                <textarea id="event_text" class="form-control" name="event_text" rows="6" autofocus>{{ old('event_text') ? old('event_text') : $event_text }}</textarea>

                                @if ($errors->has('event_text'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('event_text') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('event_img') ? ' has-error' : '' }}">
                            <label for="event_img" class="col-md-2 control-label">Image</label>

                            <div class="col-md-9">
                                @if ($event_img)
                                    <img src="{{ asset('img/'.$event_img) }}" class="img-thumbnail" alt="">
                                @endif

                                <input id="event_img" type="file" class="form-control" name="event_img" autofocus>
                                <small>* maximum image height is 300px</small>

                                @if ($errors->has('event_img'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('event_img') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Product of The Month --}}
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Product of The Month</div>
                    <div class="panel-body">
                        <div class="form-group{{ $errors->has('potm_title') ? ' has-error' : '' }}">
                            <label for="potm_title" class="col-md-2 control-label">Title</label>

                            <div class="col-md-9">
                                <input id="potm_title" type="text" class="form-control" name="potm_title" value="{{ old('potm_title') ? old('potm_title') : $potm_title }}" required autofocus>

                                @if ($errors->has('potm_title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('potm_title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('potm_text') ? ' has-error' : '' }}">
                            <label for="potm_text" class="col-md-2 control-label">Text</label>

                            <div class="col-md-9">
                                <textarea id="potm_text" class="form-control" name="potm_text" rows="6" autofocus>{{ old('potm_text') ? old('potm_text') : $potm_text }}</textarea>

                                @if ($errors->has('potm_text'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('potm_text') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('potm_img') ? ' has-error' : '' }}">
                            <label for="potm_img" class="col-md-2 control-label">Image</label>

                            <div class="col-md-9">
                                @if ($potm_img)
                                    <img src="{{ asset('img/'.$potm_img) }}" class="img-thumbnail" alt="">
                                @endif

                                <input id="potm_img" type="file" class="form-control" name="potm_img" autofocus>
                                <small>* maximum image height is 300px</small>

                                @if ($errors->has('potm_img'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('potm_img') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Facebook --}}
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Facebook URL</div>
                    <div class="panel-body">
                        <div class="form-group{{ $errors->has('facebook_babyhood_url') ? ' has-error' : '' }}">
                            <label for="facebook_babyhood_url" class="col-md-2 control-label">Babyhood</label>

                            <div class="col-md-9">
                                <input id="facebook_babyhood_url" type="text" class="form-control" name="facebook_babyhood_url" value="{{ old('facebook_babyhood_url') ? old('facebook_babyhood_url') : $facebook_babyhood_url }}" autofocus />

                                @if ($errors->has('facebook_babyhood_url'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('facebook_babyhood_url') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('facebook_nuna_url') ? ' has-error' : '' }}">
                            <label for="facebook_nuna_url" class="col-md-2 control-label">Nuna</label>

                            <div class="col-md-9">
                                <input id="facebook_nuna_url" type="text" class="form-control" name="facebook_nuna_url" value="{{ old('facebook_nuna_url') ? old('facebook_nuna_url') : $facebook_nuna_url }}" autofocus />

                                @if ($errors->has('facebook_nuna_url'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('facebook_nuna_url') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Instagram --}}
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Instagram URL</div>
                    <div class="panel-body">
                        <div class="form-group{{ $errors->has('instagram_babyhood_url') ? ' has-error' : '' }}">
                            <label for="instagram_babyhood_url" class="col-md-2 control-label">Babyhood</label>

                            <div class="col-md-9">
                                <input id="instagram_babyhood_url" type="text" class="form-control" name="instagram_babyhood_url" value="{{ old('instagram_babyhood_url') ? old('instagram_babyhood_url') : $instagram_babyhood_url }}" autofocus />

                                @if ($errors->has('instagram_babyhood_url'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('instagram_babyhood_url') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('instagram_nuna_url') ? ' has-error' : '' }}">
                            <label for="instagram_nuna_url" class="col-md-2 control-label">Nuna</label>

                            <div class="col-md-9">
                                <input id="instagram_nuna_url" type="text" class="form-control" name="instagram_nuna_url" value="{{ old('instagram_nuna_url') ? old('instagram_nuna_url') : $instagram_nuna_url }}" autofocus />

                                @if ($errors->has('instagram_nuna_url'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('instagram_nuna_url') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                
            {{-- Contact --}}
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Contact</div>
                    <div class="panel-body">
                        <div class="form-group{{ $errors->has('contact_email') ? ' has-error' : '' }}">
                            <label for="contact_email" class="col-md-2 control-label">Email</label>

                            <div class="col-md-9">
                                <input id="contact_email" type="text" class="form-control" name="contact_email" value="{{ old('contact_email') ? old('contact_email') : $contact_email }}" required autofocus />

                                @if ($errors->has('contact_email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('contact_email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 bottom-margin-sm">
                <button type="submit" class="center-block btn btn-default">
                    Submit
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
