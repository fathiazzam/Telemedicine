	
  </main>
</div>
<!-- Footer -->
<footer class="page-footer font-small cyan darken-3">

    <!-- Footer Elements -->
    <div class="container">

      <!-- Grid row-->
      <div class="row">

        <!-- Grid column -->
        <div class="col-md-12 py-5">
          <div class="mb-5 flex-center">

            
          </div>
        </div>
        <!-- Grid column -->

      </div>
      <!-- Grid row-->

    </div>
    <!-- Footer Elements -->

    <!-- Copyright -->
    <div class="footer-copyright text-center py-3">© 2018 Copyright:
      <a href="https://mdbootstrap.com/bootstrap-tutorial/"> telefkub.com</a>
    </div>
    <!-- Copyright -->

  </footer>
  <!-- Footer -->

	<?php if($this->session->id != ''):?>
	    <script src="<?php echo base_url('assets/js/notif.js') ?>"></script>
	<?php endif;?>
	<?php if($this->session->status == 1):?>
	    <script src="<?php echo base_url('node_modules/socket.io-client/dist/socket.io.js') ?>"></script>
	    <script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>    
	    <script src="<?php echo base_url('assets/js/main.js') ?>"></script>
	<?php endif;?>

</body>
  	
</html>
