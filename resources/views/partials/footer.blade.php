 <!-- footer -->
 <div class="container-fluid">
                        <div class="footer">
                           <p>Copyright © 2018 Designed by html.design. All rights reserved.<br><br>
                              Distributed By: <a href="https://themewagon.com/">ThemeWagon</a>
                           </p>
                        </div>
                     </div>
                  </div>
                  <!-- end dashboard inner -->
               </div>
            </div>
         </div>
      </div>
      <!-- jQuery -->
      <!-- <script src="{{ env_asset('js/jquery.min.js') }}"></script> -->
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

      <script src="{{ env_asset('js/popper.min.js') }}"></script>
      <script src="{{ env_asset('js/bootstrap.min.js') }}"></script>
      <!-- wow animation -->
      <script src="{{ env_asset('js/animate.js') }}"></script>
      <!-- select country -->
      <script src="{{ env_asset('js/bootstrap-select.js') }}"></script>
      <!-- owl carousel -->
      <script src="{{ env_asset('js/owl.carousel.js') }}"></script> 
      <!-- chart js -->
      <script src="{{ env_asset('js/Chart.min.js') }}"></script>
      <script src="{{ env_asset('js/Chart.bundle.min.js') }}"></script>
      <script src="{{ env_asset('js/utils.js') }}"></script>
      <script src="{{ env_asset('js/analyser.js') }}"></script>
      <!-- nice scrollbar -->
      <script src="{{ env_asset('js/perfect-scrollbar.min.js') }}"></script>
      <script>
         var ps = new PerfectScrollbar('#sidebar');
      </script>
      <!-- custom js -->
      <script src="{{ env_asset('js/custom.js') }}"></script>
      <!-- calendar file css -->     
      <script src="{{ env_asset('js/semantic.min.js') }}"></script>

      <!-- Todo : stack and push scripts to here -->

      <script>
    var $ = jQuery.noConflict();
</script>
      @stack('scripts')

   </body>
</html>