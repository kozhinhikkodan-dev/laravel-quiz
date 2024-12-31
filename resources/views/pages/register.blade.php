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
                  <div class="login_form">
                     <form method="post" action="{{ (request()->routeIs('admin.login')) ? route('admin.register') : route('register') }}">
                        @csrf
                        <fieldset>
                        <div class="field">
                              <label class="label_field">Name</label>
                              <input type="text" name="name" placeholder="name" value="{{ old('name') }}" />
                              @error('name')
                                 <span class="invalid-feedback-2 text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                 </span>
                              @enderror
                           </div>
                           <div class="field">
                              <label class="label_field">Email Address</label>
                              <input type="email" name="email" placeholder="E-mail" value="{{ old('email') }}" />
                              @error('email')
                                 <span class="invalid-feedback-2 text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                 </span>
                              @enderror
                           </div>
                           <div class="field">
                              <label class="label_field">Password</label>
                              <input type="password" name="password" placeholder="Password" />
                              @error('password')
                                 <span class="invalid-feedback-2 text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                 </span>
                              @enderror
                           </div>
                           <div class="field">
                              <label class="label_field">Confirm Password</label>
                              <input type="password" name="password_confirmation" placeholder="ConfirmPassword" />
                           </div>
                           <div class="field">
                              <label class="label_field hidden">hidden label</label>
                              <label class="form-check-label"><input type="checkbox" name="remember" class="form-check-input"> Remember Me</label>
                              <!-- <a class="forgot" href="{{route(name: 'login')}}">Are u a member ? Login</a> -->

                              @if(!request()->routeIs('admin.login'))
                           <a class="forgot" href="{{route('admin.login')}}">Are u a admin member ? Login</a>
                              @else
                              <a class="forgot" href="{{route('login')}}">Are u a member ? Login</a>
                              @endif
                              <!-- <a class="forgot" href="">Forgotten Password?</a> -->
                           </div>
                           <div class="field margin_0">
                              <label class="label_field hidden">hidden label</label>
                              <button class="main_bt">Sing In</button>
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