<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo strtoupper(ucfirst(str_replace(".php", "", basename($_SERVER['PHP_SELF']))));?></title>

    <link href="assets/img/favicon.png" rel="icon">
    <link href="../public/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../public/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../public/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../public/assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="../public/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Main CSS File -->
    <link href="../public/assets/css/main.css" rel="stylesheet">
</head>
<body class="index-page">


    <?php include_once("../components/header.php");?>
    
   <?php include_once('../requests/session.php');?>

   <?php include_once('../requests/requests.php');?>

    <main class="main">
        <?php include_once("../components/hero_section.php");?>
        <?php include_once("../components/featured_books.php");?>
        <?php include_once("../components/about_section_01.php");?>
        <?php include_once("../components/books_section.php");?>
        <?php include_once("../components/books_section.php");?>
    </main>



    <?php include_once("../components/footer.php");?>

    




 <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="../public/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../public/assets/vendor/php-email-form/validate.js"></script>
  <script src="../public/assets/vendor/aos/aos.js"></script>
  <script src="../public/assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="../public/assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="../public/assets/js/main.js"></script>
    
</body>
</html>