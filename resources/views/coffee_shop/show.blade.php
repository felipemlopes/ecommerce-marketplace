@extends('app')

@section('page-title')
    {{$coffeeShop->name}}
@endsection

@section('content')
    <div id="coffee-shop-presentation">
        <div class="container-fluid" id="show-coffee-shop">
            <div class="row">
                <div class="col-xs-12" id="coffee-shop-image" style="background-image: url({{$coffeeShop->mainImage()}})">
                </div>
            </div>
        </div>

        <div id="best-review-and-features-available">
            <div class="container" id="coffee-shop-info">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-9" id="coffee-shop-presentation-title">
                        <h1>@yield('page-title')</h1>
                        <h3>
                            <span class="glyphicon glyphicon-map-marker"></span>
                            {{$coffeeShop->location}}
                            <br class="hidden-lg">
                            <br class="hidden-lg">
                            <span class="ratings">
                                @include('coffee_shop._rating', ['rating' => $coffeeShop->getRating()])
                            </span>
                        </h3>
                    </div>
                    <div class="col-md-3 col-xs-12 col-sm-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading ">Order your coffee</div>
                            <div class="panel-body">
                                <form action="order">
                                    <label>
                                        <span class="glyphicon glyphicon-map-marker"></span>
                                        <span class="panel-input">
                                            {{$coffeeShop->name}}
                                        </span>
                                    </label>

                                    <label>
                                        <i class="fa fa-coffee"></i>
                                        <select name="" class="panel-input">
                                            <option value="">Select your drink</option>
                                        </select>
                                    </label>

                                    <label>
                                        <span class="glyphicon glyphicon-time"></span>
                                        <select name="" class="panel-input">
                                            <option value="">Pickup time</option>
                                        </select>
                                    </label>

                                    <input type="submit" class="btn btn-success" value="Place order">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container" id="coffee-shop-description">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-9">
                        <div class="row">
                            <div class="hide visible-xs-block col-xs-12 above-best-review-xs">
                                Images
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="review-container">
                                    <div class="review">
                                        @if($bestReview !== null)
                                            {{$bestReview->pivot->review === '' ? 'No comment' : $bestReview->pivot->review}}
                                        @else
                                            No review has been written yet!
                                            <a href="#reviews-for-coffeeshop">Click here</a> to write one!
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 hidden-xs">
                                Images
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container" id="coffee-shop-about">
            @if(current_user()->owns($coffeeShop) || current_user()->role === 'admin')
                <div class="row">
                    <div class="col-xs-12">
                        @if(current_user()->role === 'admin')
                            <a href="{{ route('admin.coffee-shops.show') }}" class="btn btn-primary">
                                Review performances
                            </a>
                        @else
                            <a href="{{ route('my-shop') }}" class="btn btn-primary">
                                Manage your shop
                            </a>
                        @endif
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-9">
                    <div class="row">
                        <div class="col-sm-6">
                            <h4>About the shop</h4>

                            @if(current_user()->owns($coffeeShop))
                                <a href="#" id="edit-coffeeshop-about-helper">Change description</a>
                                <p id="edit-coffeeshop-about"
                                   data-target="{{ route('coffee-shop.update', ['coffeeShop' => $coffeeShop]) }}">
                            @else
                                <p>
                            @endif
                                {{ ! $coffeeShop->about ? 'No information.' : $coffeeShop->about }}
                            </p>
                        </div>

                        <hr class="visible-xs-block">

                        <div class="col-sm-6">
                            <h4>Current deals</h4>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-xs-12">
                            <h4>Location</h4>

                            <div id="maps-container" data-position="{{$coffeeShop->getPosition()}}"></div>
                        </div>
                    </div>
                    <hr>
                    <div class="row" id="reviews-for-coffeeshop">
                        <div class="col-xs-12">
                            <h4>
                                Reviews
                                @if(Session::has('special-message'))
                                    <p class="alert alert-{{key(Session::get('special-message'))}}" style="margin-top: 10px">
                                        {{current(Session::get('special-message'))}}
                                    </p>
                                @endif

                                @if(Auth::user())
                                    @if ( ! $coffeeShop->reviews()->where('user_id', '=', current_user()->id)->count())
                                        <a href="#" id="add-review">
                                            Add your review
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ url('/auth/login') }}">Login to review this shop</a>
                                @endif
                            </h4>
                            <div class="row hide" id="add-review-form">
                                <div class="col-xs-12">
                                    <h5>Add your own review</h5>
                                    <p class="alert alert-danger hide" id="empty-rating">
                                        Heya, you forgot to give a rating!
                                    </p>
                                    <span class="ratings select-rating">
                                        Rating: @include('coffee_shop._rating', ['rating' => 0])
                                    </span>

                                    <form method="post"
                                          id="post-review"
                                          action="{{ route('coffee-shop.review', ['coffee_shop' => $coffeeShop]) }}">
                                        <div class="form-group">
                                            <textarea id="review" name="review" placeholder="Review..." class="form-control"></textarea>
                                        </div>

                                        <input type="hidden" name="rating" value="" id="rating-input">
                                        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}">
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary" value="Post review">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                @foreach($coffeeShop->reviews as $i => $review)
                                    <div class="col-xs-12 col-sm-6 {{$i > 3 ? 'hide' : ''}} @if(Auth::user() && $review->id === current_user()->id) your-review @endif ">
                                        <div class="review-container">
                                            <div class="review">
                                                {{$review->pivot->review === '' ? "No comment" : $review->pivot->review }}
                                            </div>

                                            <div class="additional-details">
                                                {{$review->pivot->created_at->format('jS M Y')}}<br>
                                                <div class="author">
                                                    {{$review->name}}
                                                </div>
                                            </div>

                                            <span class="ratings">
                                                @include('coffee_shop._rating', ['rating' => $review->pivot->rating])
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                                <a href="#" id="show-more-reviews" class="hidden-xs">Show more...</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('vendor_scripts')
    <script type="text/javascript" src="//maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
@endsection

@section('scripts')
    @if(current_user()->owns($coffeeShop))
        <script type="text/javascript" src="{{ elixir('js/shop_owner.js') }}"></script>
    @endif

    <script type="text/javascript" src="{{ elixir('js/user.js') }}"></script>
    <script type="text/javascript" src="{{ elixir('js/gmaps.js') }}"></script>
@endsection