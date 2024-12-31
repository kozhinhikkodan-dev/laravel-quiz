<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>Pluto - Responsive Bootstrap Admin Panel Templates</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- site icon -->
      <link rel="icon" href="{{ env_asset('images/fevicon.png') }}" type="image/png" />
      <!-- bootstrap css -->
      <link rel="stylesheet" href="{{ env_asset('css/bootstrap.min.css') }}" />
      <!-- site css -->
      <link rel="stylesheet" href="{{ env_asset('style.css') }}" />
      <!-- responsive css -->
      <link rel="stylesheet" href="{{ env_asset('css/responsive.css') }}" />
      <!-- color css -->
      <link rel="stylesheet" href="{{ env_asset('css/colors.css') }}" />
      <!-- select bootstrap -->
      <link rel="stylesheet" href="{{ env_asset('css/bootstrap-select.css') }}" />
      <!-- scrollbar css -->
      <link rel="stylesheet" href="{{ env_asset('css/perfect-scrollbar.css') }}" />
      <!-- custom css -->
      <link rel="stylesheet" href="{{ env_asset('css/custom.css') }}" />
      <!-- calendar file css -->
      <link rel="stylesheet" href="{{ env_asset('js/semantic.min.css') }}" />
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
   </head>
   <body class="inner_page login">
      <div class="full_container">
         <div class="container">
            <div class="center verticle_center full_height">
               <div class="login_section">
                  <div class="logo_login">
                     <div class="center">
                        <img width="210" src="{{ env_asset('images/logo/logo.png') }}" alt="#" />
                     </div>
                  </div>

                  <!-- @php
                     var_dump(session()->all());
                  @endphp -->

                  @session('success')
                     <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                     </div>
                  @endif

                  @session('login-error')
                     <div class="alert alert-danger" role="alert">
                        {{ session('login-error') }}
                     </div>
                  @endif


                  <div class="login_form">
                     <form method="post" action="{{ (request()->routeIs('admin.login')) ? route('admin.login.process') : route('login.process') }}">
                        @csrf
                        <fieldset>
                           <div class="field">
                              <label class="label_field">Email Address</label>
                              <input type="email" name="email" placeholder="E-mail" />
                              @error('email')
                                 <span class="invalid-feedback-2 text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                 </span>
                              @enderror
                           </div>
                           <div class="field">
                              <label class="label_field">Password</label>
                              <input type="password" name="password" placeholder="Password" />
                           </div>
                           <div class="field">
                              <label class="label_field hidden">hidden label</label>
                              <label class="form-check-label"><input type="checkbox" class="form-check-input"> Remember Me</label>
                              <a class="forgot" href="">Forgotten Password?</a>
                              <a class="forgot" href="{{route('register.page')}}">New Here ? Register</a>
                              @if(!request()->routeIs('admin.login'))
                           <a class="forgot" href="{{route('admin.login')}}">R u admin ? Login Here</a>
                              @else
                              <a class="forgot" href="{{route('login')}}">R u user ? Login Here</a>
                              @endif

                           </div>
                           <div class="field margin_0">
                              <label class="label_field hidden">hidden label</label>
                              <button class="main_bt">Sign In</button>
                           </div>
                        </fieldset>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- jQuery -->
      <script src="{{ env_asset('js/jquery.min.js') }}"></script>
      <script src="{{ env_asset('js/popper.min.js') }}"></script>
      <script src="{{ env_asset('js/bootstrap.min.js') }}"></script>
      <!-- wow animation -->
      <script src="{{ env_asset('js/animate.js') }}"></script>
      <!-- select country -->
      <script src="{{ env_asset('js/bootstrap-select.js') }}"></script>
      <!-- nice scrollbar -->
      <script src="{{ env_asset('js/perfect-scrollbar.min.js') }}"></script>
      <script>
         var ps = new PerfectScrollbar('#sidebar');
      </script>
      <!-- custom js -->
      <script src="{{ env_asset('js/custom.js') }}"></script>
   </body>
</html>