<!DOCTYPE html>
<html>
<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8">
	<link rel="shortcut icon" href="../vendors/images/Logo 3.svg">
	<title><?php echo strtoupper(ucfirst(str_replace(".php", "", basename($_SERVER['PHP_SELF']))));?></title>
	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">	
	<!-- Fontfaces CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<!-- Fontfaces CSS -->
	<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous">
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" type="text/css" href="../assets/vendors/styles/core.css">
	<link rel="stylesheet" type="text/css" href="../assets/vendors/styles/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="../assets/vendors/styles/style.css">
	<link rel="stylesheet" type="text/css" href="../assets/vendors/styles/main.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>

	
</head>

<body>

	<?php include("../authentification/session_user.php");?>
	<?php include("../authentification/info_access.php");?>
	<div class="header">
		<div class="header-left">
			<div class="menu-icon dw dw-menu"></div>
			<div class="search-toggle-icon dw dw-search2" data-toggle="header_search"></div>
			<div class="header-search">
				<form>
					
				</form>
			</div>
		</div>

		<div class="header-right">
			<div class="dashboard-setting user-notification">
				<div class="dropdown">
					<a class="dropdown-toggle no-arrow" href="javascript:;" data-toggle="right-sidebar">
						
					</a>
				</div>
			</div>
			
			<div class="user-info-dropdown">
				<div class="dropdown">
					<a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
					<span class="user-icon shadow-none">
					<div class="profile-wrapper position-relative d-inline-block">
						<img class="rounded-circle img-fluid" 
							src="<?= !empty($_SESSION['photo']) ? '../uploads/' . htmlspecialchars($_SESSION['photo']) : '../assets/vendors/images/profile.png'; ?>" 
							alt="Photo de profil" 
							style="width: 50px; height: 50px; object-fit: cover;">

						<!-- Indicateur en ligne -->
						<span class="online-indicator position-absolute rounded-circle border border-white"
							style="width: 15px; height: 15px; background-color: #28a745; bottom: 0; right: 0;"></span>
					</div>
				</span>

					<small class="user-name fw-bold"><?php echo htmlspecialchars($_SESSION['username']); ?></small>
					</a>
					<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
						<small><a class="dropdown-item" href="../login/profile.php"><i class="fa fa-user-md" aria-hidden="true"></i> Profile</a></small>
						<small><a class="dropdown-item" href="../authentification/logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Déconnexion</a></small>
					</div>
				</div>
			</div>
			
		</div>
	</div>

	
	<div class="left-side-bar">
		<div class="brand-logo">
			<a href="##">
				<img src="../assets/vendors/images/Logo 4 blanc.png" alt="" class="">
			</a>
			<div class="close-sidebar" data-toggle="left-sidebar-close">
				<i class="ion-close-round"></i>
			</div>
		</div>
		
		
		<div class="menu-block customscroll">
			<div class="sidebar-menu">
				<ul id="accordion-menu">
				
				<a href="../admin/dashboard.php" class="dropdown-toggle no-arrow">
                    <span class="micon fas fa-home"></span>
                    <span class="mtext">Tableau de bord</span>
                </a>

                <a href="../admin/books.php" class="dropdown-toggle no-arrow">
                    <span class="micon fas fa-book"></span>
                    <span class="mtext">Liste des livres</span>
                </a>

                <a href="../admin/authors.php" class="dropdown-toggle no-arrow">
                    <span class="micon fas fa-user"></span>
                    <span class="mtext">Liste des auteurs</span>
                </a>

                <a href="../admin/category_books.php" class="dropdown-toggle no-arrow">
                    <span class="micon fas fa-list-alt"></span>
                    <span class="mtext">Catégories de livres</span>
                </a>

                <a href="../admin/reservations.php" class="dropdown-toggle no-arrow">
                    <span class="micon fas fa-calendar-check"></span>
                    <span class="mtext">Liste des reservations</span>
                </a>

                <a href="../admin/users.php" class="dropdown-toggle no-arrow">
                    <span class="micon fas fa-users"></span>
                    <span class="mtext">Liste des utilisateurs</span>
                </a>

				</ul>
			</div>
		</div>
	</div>
	</div>
	</div>

	</div>
	<!-- js -->
	<script src="../assets/vendors/scripts/core.js"></script>
	<script src="../assets/vendors/scripts/script.min.js"></script>
	<script src="../assets/vendors/scripts/process.js"></script>
	<script src="../assets/vendors/scripts/layout-settings.js"></script>
	
	<script src="../assets/src/plugins/datatables/js/jquery.dataTables.min.js"></script>
	<script src="../assets/src/plugins/datatables/js/dataTables.responsive.min.js"></script>
	<script src="../assets/src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
</body>
</html>
