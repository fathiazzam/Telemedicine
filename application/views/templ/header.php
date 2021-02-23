<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
  
	<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css') ?>">
  <script src="<?php echo base_url('assets/js/jquery-3.3.1.min.js') ?>"></script>
  <script src="<?php echo base_url('assets/js/popper.min.js') ?>"></script>
  <script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>      
  <script src="<?php echo base_url('assets/css/custom.css') ?>"></script>
  <title>Login atau Register</title>
</head>
<body>
  <nav class="navbar navbar-expand-md navbar-dark mb-4" style="background-color: #134B4B;">
    <a class="navbar-brand" href="#">
      <span><img src="<?php echo base_url('assets/img/597812.png') ?>" width="100" height="40"></span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav mr-auto">
        <?php if($this->session->username != ''):?>
        <li class="nav-item active">
          <a class="nav-link" href="home">Home<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="home"><?php echo $this->session->username;?><span class="sr-only">(current)</span></a>
        </li>  
        <li class="nav-item active">
          <a class="nav-link" href="logout">Logout<span class="sr-only">(current)</span></a>
        </li>
        <?php else:?>
        <li class="nav-item active">
          <a class="nav-link" href="login">Login<span class="sr-only">(current)</span></a>
        </li>  
        <?php endif ?>
    </div>
  </nav>
  <div class="body">
    <main role="main" class="container">
      