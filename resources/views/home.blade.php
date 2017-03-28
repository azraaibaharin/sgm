@extends('layouts.app')

@section('meta-fb')
<meta property="og:url"                content="http://www.supremeglobal.com.my" />
<meta property="og:type"               content="article" />
<meta property="og:title"              content="Supreme Global Marketing" />
<meta property="og:description"        content="{!! $about_text !!}" />
<meta property="og:image"              content="{{ $tagline_img }}" />
@endsection

@section('content')
{{-- Product --}}
<div id="banner" class="container-fluid">
    <div class="row">
        <div class="col-md-6 no-padding">
            <a class="img-overlay" href="{{ url('products/b/babyhood') }}"><img src="{{ asset('img/'.$babyhood_img) }}" class="img-responsive" alt="{{ $babyhood_text }}"></a>
        </div>
        <div class="col-md-6 no-padding">
            <a class="img-overlay" href="{{ url('products/b/nuna') }}"><img src="{{ asset('img/'.$nuna_img) }}" class="img-responsive" alt="{{ $nuna_text }}"></a>
        </div>
    </div>
</div>

{{-- About --}}
<div id="about" class="container top-bottom-padding-md">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <p>{!! $about_text !!}</p>
        </div>
    </div>
</div>

{{-- Feature --}}
<div id="feature" class="container-fluid bottom-margin-md">
    <div class="row bg-black">
        <div class="col-md-6 padding-md">
            <h1 class="text-center">{{ $tagline_title }}</h1>
            <p class="text-center">{!! $tagline_text !!}</p>
            @if ($tagline_link != '' && $tagline_link_text != '')
                <p class="top-padding-sm text-center"><a href="{{ $tagline_link }}">{{ $tagline_link_text }}</a></p>
            @endif
        </div>
        <div class="col-md-6 no-left-right-padding">
            @if ($tagline_link != '' && $tagline_link_text != '')<a href="{{ $tagline_link }}">@endif
                <img src="{{ asset('img/'.$tagline_img) }}" class="img-responsive center-block">
            @if ($tagline_link != '' && $tagline_link_text != '')</a>@endif
        </div>
    </div>
</div>

{{-- Event --}}
<div id="event" class="container-fluid bottom-margin-md">
    <div class="row">
        <div class="col-md-6 no-left-right-padding hidden-xs hidden-sm">
            @if ($event_link != '' && $event_link_text != '')<a href="{{ $event_link }}">@endif
                <img src="{{ asset('img/'.$event_img) }}" class="img-responsive center-block">
            @if ($event_link != '' && $event_link_text != '')</a>@endif
        </div>
        <div class="col-md-6 padding-md">
            <h1 class="text-center">{{ $event_title }}</h1>
            <p class="text-center">{!! $event_text !!}</p>
            @if ($event_link != '' && $event_link_text != '')
                <p class="top-padding-sm text-center"><a href="{{ $event_link }}">{{ $event_link_text }}</a></p>
            @endif
        </div>
        <div class="col-md-6 no-left-right-padding hidden-md hidden-lg">
            @if ($event_link != '' && $event_link_text != '')<a href="{{ $event_link }}">@endif
                <img src="{{ asset('img/'.$event_img) }}" class="img-responsive center-block">
            @if ($event_link != '' && $event_link_text != '')</a>@endif
        </div>
    </div>
</div>

{{-- Product of the month --}}
<div id="potm" class="container-fluid bottom-margin-md">
    <div class="row bg-black">
        <div class="col-md-6 padding-md">
            <h1 class="text-center">{{ $potm_title }}</h1>
            <p class="text-center">{!! $potm_text !!}</p>
            @if ($potm_link != '' && $potm_link_text != '')
                <p class="top-padding-sm text-center"><a href="{{ $potm_link }}">{{ $potm_link_text }}</a></p>
            @endif
        </div>
        <div class="col-md-6 no-left-right-padding">
            @if ($potm_link != '' && $potm_link_text != '')<a href="{{ $potm_link }}">@endif
                <img src="{{ asset('img/'.$potm_img) }}" class="img-responsive center-block">
            @if ($potm_link != '' && $potm_link_text != '')</a>@endif
        </div>
    </div>
</div>

{{-- Article --}}
{{-- <div id="article" class="container-fluid bottom-margin-md">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">Articles</h1>
        </div>
    @foreach($articles as $article)
        <div class="col-md-4">
            <h2>{{ $article->title }}</h2>
            <p>{{ $article->text }}</p>
        </div>
    @endforeach
    </div>
        <div class="col-md-12 text-center top-margin-md">
            <a href="{{ url('articles') }}" >More Articles</a>
        </div>
</div> --}}

{{-- Testimonial --}}
@if (!is_null($latestTestimonialBabyhood) && !is_null($latestTestimonialNuna))
<div id="testimonial" class="container-fluid bottom-margin-md">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center bottom-padding-sm">Testimonials</h1>
        </div>
        <div class="col-md-6 text-center babyhood padding-md">
            <a href="{{ url('testimonials/'.$latestTestimonialBabyhood->id) }}">
                <h3>{!! $latestTestimonialBabyhood->text !!}</h3>
                <small>was recently said about {{ ucfirst($latestTestimonialBabyhood->product->brand) }} {{ $latestTestimonialBabyhood->product->model }}</small>
            </a>
        </div>
        <div class="col-md-6 text-center nuna padding-md">
            <a href="{{ url('testimonials/'.$latestTestimonialNuna->id) }}">
                <h3>{!! $latestTestimonialNuna->text !!}</h3>
                <small>was recently said about {{ ucfirst($latestTestimonialNuna->product->brand) }} {{ $latestTestimonialNuna->product->model }}</small>
            </a>
        </div>
    </div>
</div>
@endif

{{-- Contact --}}
<div id="getintouch" class="container bottom-margin-md">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="text-center">
                @if ($message = session('message'))
                    <div class="alert alert-info" role="alert">{{ $message }}</div>     
                    {{ session()->flush() }}
                @endif
                <h1 class="bottom-padding-sm">Get In Touch!</h1>
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/contact') }}">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('contact_name') || $errors->has('contact_email') ? ' has-error' : '' }}">
                        <div class="col-md-6 bottom-padding-sm">
                            <input type="text" class="form-control" name="contact_name" required value="{{ old('contact_name') }}" placeholder="Name" />
                            @if ($errors->has('contact_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('contact_name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-6 bottom-padding-sm">
                            <input type="text" class="form-control" name="contact_email" required value="{{ old('contact_email') }}" placeholder="Email" />
                            @if ($errors->has('contact_email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('contact_email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('contact_message') ? ' has-error' : '' }}">
                        <div class="col-md-12">
                            <textarea class="form-control" name="contact_message" required rows="5">{{ old('contact_message') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-2">
                            <button type="submit" class="btn btn-default">
                                Submit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="getintouch2" class="container bottom-margin-md">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 text-center">
            <address>
                <strong>Supreme Global Marketing Sdn Bhd (862993-T)</strong><br>
                21-2<br>
                Jalan USJ 21/1<br>
                Subang Jaya<br>
                47630 Selangor<br>
                Malaysia<br>
                <abbr title="Phone">Call us at:</abbr> +603 8023 3277<br>
                <abbr title="Email">Email:</abbr> admin@babyhood.com.my
            </address>
        </div>
    </div>
</div>

{{-- Social Media --}}
<div id="followus" class="container-fluid padding-md bg-grey">
    <div class="row">
        <div class="col-xs-3">
            <div class="text-center">
                <a href="{{ $facebook_babyhood_url }}" target="_blank"><i class="icon-social-facebook icon-md icon-border-rd bg-blue"></i></a>
            </div>
        </div>
        <div class="col-xs-3">
            <div class="text-center">
                <a href="{{ $instagram_babyhood_url }}" target="_blank"><i class="icon-social-instagram icon-md icon-border-rd bg-blue"></i></a>
            </div>
        </div>
        <div class="col-xs-3">
            <div class="text-center">
                <a href="{{ $facebook_nuna_url }}" target="_blank"><i class="icon-social-facebook icon-md icon-border-rd bg-black"></i></a>
            </div>
        </div>
        <div class="col-xs-3">
            <div class="text-center">
                <a href="{{ $instagram_nuna_url }}" target="_blank"><i class="icon-social-instagram icon-md icon-border-rd bg-black"></i></a>
            </div>
        </div>
    </div>
</div>

{{-- Footer --}}
<div id="footer" class="container-fluid bg-dark-grey">
    <div class="row">
        <div class="col-md-12 text-center">
            <p>Copyright Supreme Global Marketing @if (Auth::guest())| <a href="{{ url('/login') }}">Login</a>@endif</p>
        </div>
    </div>
</div>
@endsection
