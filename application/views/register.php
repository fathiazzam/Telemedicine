<div class="row">
	<div class="col-sm-3"></div>
	<div class="jumbotron text-center col-sm-6" style="background-color: #00a400;">
		<form action="<?php echo base_url('regis');?>" method="POST" class="text-center">
			<h1 style="color: white">Daftar Member</h1>
			<p></p>
			<input type="text" class="form-control" placeholder="Username" name="username" required data-validation-required-message="Please enter your username" />
			<p></p>
			<input type="text" class="form-control" placeholder="Full Name" name="name" required/>
			<p></p>
			<select class="form-control" placeholder="Gender" name="gender" required>
				<option value="Laki-laki">Laki-laki</option>
				<option value="perempuan">perempuan</option>
			</select>
			<p></p>
			<input type="text" class="form-control" placeholder="e-mail" name="email" required/>
			<p></p>
			<input type="number" class="form-control" placeholder="Nomor Telepon" name="phone"/>
			<p></p>
			<input type="password" class="form-control" placeholder="Kata Sandi" name="password" required/>
			<p></p>
			<p><input type="submit" class="btn btn-danger" value="Daftar" name="register">
		</form>
		</div>
		
		<div class="col-sm-3"></div>
</div>
	<form action="<?php echo base_url('login');?>" method="POST" class="text-center">
		<p>Sudah punya akun?</p>
		<input type="submit" class="btn btn-primary" value="Masuk">
	</form>
			