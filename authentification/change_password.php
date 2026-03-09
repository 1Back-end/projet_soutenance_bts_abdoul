<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Kodinger">
	<link rel="apple-touch-icon" sizes="180x180" href="../assets/img/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/img/favicons/favicon-16x16.png">
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicons/favicon.ico">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title><?php echo strtoupper(ucfirst(str_replace(".php", "", basename($_SERVER['PHP_SELF']))));?></title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/my-login.css">
	<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

</head>

<?php include ("process_change_password.php")?>
<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100 mt-5 pb-5">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper">
					<?php if (!empty($erreur)) : ?>
						<div class="alert alert-danger text-center" role="alert">
							<?= htmlspecialchars($erreur) ?>
						</div>
					<?php endif; ?>
					<?php if (!empty($success)) : ?>
						<div class="alert alert-success text-center" role="alert">
							<?= htmlspecialchars($success) ?>
						</div>
					<?php endif; ?>

					<div class="card fat">
						<div class="card-body">
							<h4 class="card-title">Changer votre mot de passe</h4>
							<form method="POST">

								<div class="form-group">
									<label for="current_password">Ancien mot de passe <span class="text-danger">*</span></label>
									<input id="current_password" type="password" class="form-control shadow-none" name="current_password" required>
								</div>

								<div class="form-group">
									<label for="new_password">Nouveau mot de passe <span class="text-danger">*</span></label>
									<input id="new_password" type="password" class="form-control shadow-none" name="new_password" required>
								</div>

								<div class="form-group">
									<label for="confirm_password">Confirmer le nouveau mot de passe <span class="text-danger">*</span></label>
									<input id="confirm_password" type="password" class="form-control shadow-none" name="confirm_password" required>
								</div>

								<div class="form-group m-0">
									<button type="submit" name="submit" class="btn btn-primary btn-block shadow-none">
										Changer le mot de passe
									</button>
								</div>

							</form>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</section>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="js/my-login.js"></script>
</body>
</html>