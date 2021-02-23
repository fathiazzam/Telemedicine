
      <div class="jumbotron text-center" style="background-color: #00a400;">
        <h1 style="color: white" class="text-center">Telmed</h1>
        <p style="color: white" class="text-center">Care with Heart and Science</p>
      </div>
      <form name="form1" id="form1" class="text-center" action="<?php echo base_url('login')?>" method="POST">
        <input type="text" placeholder="Username" name="username" required>
        <input type="password" placeholder="Password" name="password" required>
        <input type="submit" class="btn btn-primary" value="Login" name="submit" >
        <br></br>
        <p>Belum punya akun? Silahkan mendaftar <a href="<?php echo base_url('register');?>" method="POST">disini</a></p>
      </form>
 



