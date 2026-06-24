<?php
global $hesk_settings, $hesklang;

// This guard is used to ensure that users can't hit this outside of actual HESK code
if (!defined('IN_SCRIPT')) {
    die();
}
?>

<!--service pege-->
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="UTF-8">
        <title><?php echo $hesk_settings['hesk_title']; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
        <?php include(HESK_PATH . 'inc/favicon.inc.php'); ?>
        <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0" />        
        <!-- Bootstrap -->
        <link href="<?php echo TEMPLATE_PATH; ?>customer/css/version-01/bootstrap.min.css" rel="stylesheet">

        <!-- Bootstrap Icons -->
        <link href="<?php echo TEMPLATE_PATH; ?>customer/vendor/bootstrap-icons-1.13.1/bootstrap-icons.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link rel="stylesheet" media="all" href="<?php echo TEMPLATE_PATH; ?>customer/css/app<?php echo $hesk_settings['debug_mode'] ? '' : '.min'; ?>.css?<?php echo $hesk_settings['hesk_version']; ?>" />
        <link rel="stylesheet" href="<?php echo TEMPLATE_PATH; ?>customer/css/version-01/style.css">
        <link rel="stylesheet" href="<?php echo TEMPLATE_PATH; ?>customer/css/version-01/dropdown.css">
        <link rel="stylesheet" href="<?php echo TEMPLATE_PATH; ?>customer/vendor/fontawesome-free-7.2.0-web/css/all.min.css">

        <!--Aos -->
        <link rel="stylesheet" href="<?php echo TEMPLATE_PATH; ?>customer/vendor/aos-master/dist/aos.css" />
    </head>

    <body>
        <!--hero section-->
        <section class="hero-section">

            <div class="container text-center">

                <h1 class="hero-title">
                    Professional & Modern Dental Care
                </h1>

                <p class="hero-text">
                    We provide advanced and high-quality dental solutions
                    to keep your smile healthy and bright.
                </p>

                <a href="#" class="btn-page hero-btn px-5 py-2">
                    Book an Appointment
                </a>

            </div>

        </section>

        <!-- Bootstrap JS && custom js-->
        <script
            src="js/bootstrap.bundle.min.js"></script>
        <script src="js/main.js"></script>
    </body>
</html>
