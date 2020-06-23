<h1>Dashboard</h1>
<?php if(isset($_SESSION['err'])): ?>
	<strong>Warning!</strong> <?= $this->session->userdata('err'); ?>
<?php endif ?>