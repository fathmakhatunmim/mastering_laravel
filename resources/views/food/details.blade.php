<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="shortcut icon" href="images/favicon.png" type="">

  <title> Feane </title>

<link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/details.css') }}">

</head>



@extends('layout.backend_master')

@section('master_content')

<!-- BIG FOOD DETAILS -->
<div class="container mt-5 mb-5">
    <div class="big-food-card p-4 shadow-sm rounded bg-white">
        <div class="row align-items-center">

            <!-- Left: Big Image -->
            <div class="col-md-6 text-center">
                @if($food->img)
                    <img src="{{ asset('uploads/'.$food->img) }}"
                         class="img-fluid rounded big-food-img"
                         alt="{{ $food->name }}">
                @endif
            </div>

            <!-- Right: Big Info -->
            <div class="col-md-6">
                <h2 class="fw-bold mb-3">{{ $food->name }}</h2>
                <p class="text-muted mb-3">{{ $food->description }}</p>
                <h4 class="text-success mb-4">$ {{ $food->price }}</h4>

                <button class="btn btn-success btn-lg" onclick="openBook()">Buy Now</button>
            </div>

        </div>
    </div>
</div>


      <!-- book section -->
<section id="book" class="book_section layout_padding" style="display:none;">

    <div class="container">
      <div class="heading_container">
        <h2>
          Book A Table
        </h2>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form_container">
            <form action="{{route('food.OrderStore')}}" method="POST">
                @csrf
              <div>
                <input type="text" class="form-control" placeholder="Your Name" name="name" />
            @if ($errors->has('name'))
            <span class="text-danger">{{ $errors->first('name') }}</span>
        @endif

              </div>
              <div>
                <input type="text" class="form-control" placeholder="Phone Number" name="pNumber"/>
                 @if ($errors->has('pNumber'))
            <span class="text-danger">{{ $errors->first('pNumber') }}</span>
        @endif
              </div>
              <div>
                <input type="email" class="form-control" placeholder="Your Email" name="email"/>
                 @if ($errors->has('email'))
            <span class="text-danger">{{ $errors->first('email') }}</span>
        @endif
              </div>
              <div>
                <select name="person" class="form-control nice-select wide" >
                  <option value="" disabled selected>
                    How many persons?
                  </option>
                  <option value="2">
                    2
                  </option>
                  <option value="3">
                    3
                  </option>
                  <option value="4">
                    4
                  </option>
                  <option value="5">
                    5
                  </option>
                </select>
                @if ($errors->has('person'))
            <span class="text-danger">{{ $errors->first('person') }}</span>
        @endif
              </div>
              <div>
                <input type="date" class="form-control" name="date">
                @if ($errors->has('date'))
            <span class="text-danger">{{ $errors->first('date') }}</span>
        @endif
              </div>
              <div class="btn_box">
                <button type="submit">
                  Book Now
                </button>
              </div>
            </form>
          </div>
        </div>
        <div class="col-md-6">
          <div class="map_container ">
            <div id="googleMap"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end book section -->

<!-- SMALL FOODS -->
<section id="menu" class="food_section layout_padding-bottom">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Our Menu
        </h2>
      </div>

      <ul class="filters_menu">
        <li class="active" data-filter="*">All</li>
        <li data-filter=".burger">Burger</li>
        <li data-filter=".pizza">Pizza</li>
        <li data-filter=".pasta">Pasta</li>
        <li data-filter=".fries">Fries</li>
      </ul>


<div class="filters-content">
    <div class="row grid">
        @foreach ($foods as $food)
            <div class="col-lg-4 col-sm-6 all {{ $food->category }}">
                <div class="box">
                    <div class="img-box">
                        <img src="{{ asset('uploads/'.$food->img) }}" alt="{{ $food->name }}">
                    </div>

<a href="{{ route('food.details', $food->id) }}" style="text-decoration:none; color:inherit;">
  <div class="detail-box">
      <h5>{{ $food->name }}</h5>
      <p>{{ $food->description }}</p>
            
      <div class="options">
         
      <h6>${{ $food->price }}</h6>
        

                    <a href="">
                      <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 456.029 456.029" style="enable-background:new 0 0 456.029 456.029;" xml:space="preserve">
                        <g>
                          <g>
                            <path d="M345.6,338.862c-29.184,0-53.248,23.552-53.248,53.248c0,29.184,23.552,53.248,53.248,53.248
                         c29.184,0,53.248-23.552,53.248-53.248C398.336,362.926,374.784,338.862,345.6,338.862z" />
                          </g>
                        </g>
                        <g>
                          <g>
                            <path d="M439.296,84.91c-1.024,0-2.56-0.512-4.096-0.512H112.64l-5.12-34.304C104.448,27.566,84.992,10.67,61.952,10.67H20.48
                         C9.216,10.67,0,19.886,0,31.15c0,11.264,9.216,20.48,20.48,20.48h41.472c2.56,0,4.608,2.048,5.12,4.608l31.744,216.064
                         c4.096,27.136,27.648,47.616,55.296,47.616h212.992c26.624,0,49.664-18.944,55.296-45.056l33.28-166.4
                         C457.728,97.71,450.56,86.958,439.296,84.91z" />
                          </g>
                        </g>
                        <g>
                          <g>
                            <path d="M215.04,389.55c-1.024-28.16-24.576-50.688-52.736-50.688c-29.696,1.536-52.224,26.112-51.2,55.296
                         c1.024,28.16,24.064,50.688,52.224,50.688h1.024C193.536,443.31,216.576,418.734,215.04,389.55z" />
                          </g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                      </svg>
                    </a>
                 </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
</div>    
  </section>
 
        </div> 
    </div>
</div>


@endsection
 <!-- jQery -->
<script src="{{ asset('frontend/js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('frontend/js/bootstrap.js') }}"></script>
<script src="{{ asset('frontend/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('frontend/js/custom.js') }}"></script>

<script>
function openBook() {
    // #book element select
    const $book = $('#book');

    // show the element
    $book.show(); // display:block

    // scroll to element
    $('html, body').animate({
        scrollTop: $book.offset().top
    }, 600); // 600ms smooth scroll
}
</script>
