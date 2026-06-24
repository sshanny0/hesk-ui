
<?php
global $hesk_settings, $hesklang;
/**
 * @var bool $customerLoggedIn - `true` if a customer is logged in, `false` otherwise
 * @var array $customerUserContext - User info for a customer if logged in.  `null` if a customer is not logged in.
 */

// This guard is used to ensure that users can't hit this outside of actual HESK code
if (!defined('IN_SCRIPT')) {
    die();
}

require_once(TEMPLATE_PATH . 'customer/util/alerts.php');
require_once(TEMPLATE_PATH . 'customer/partial/login-navbar-elements.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?php echo $hesk_settings['hesk_title']; ?></title>
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
    <?php renderCommonElementsAfterBody(); ?>
    
    <!--header section -->
    <header>
        <!-- Navbar -->
        <nav class="navbar main-nav fixed-top py-3 navbar-expand-lg">
            <div
                class="container d-flex justify-content-between align-items-center">

                <!-- Logo -->
                <div class="d-flex align-items-center gap-2 brand-logo">
                    <i class="fa-solid fa-headset"></i>
                    <h4 class="fw-bold m-0 Logo"><?php echo $hesk_settings['hesk_title']; ?></h4>
                </div>


                <!-- Burger Button (Mobile Only) -->
                <button class="navbar-toggler d-lg-none"
                    type="button"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#mobileMenu">

                    <i class="bi bi-list fs-1"></i>
                </button>

            </div>
        </nav>

        <!-- Offcanvas Mobile Menu -->
        <div class="offcanvas offcanvas-end" id="mobileMenu"
            style="background-color: #8a7aff;">

            <div class="offcanvas-header">
                <div class="d-flex align-items-center gap-2 brand-logo">
                    <i class="fa-solid fa-headset"></i>
                    <h4 class="fw-bold m-0"><?php echo $hesk_settings['hesk_title']; ?></h4>
                </div>

                <button class="btn-close"
                    data-bs-dismiss="offcanvas"></button>
            </div>

        </div>
    </header>

    <!-- BREADCRUMBS -->
    <section class="hero-modern" style="min-height: 140px; padding-top: 95px;">
    </section>

    <div class="container mt-4 mb-2">
        <nav class="breadcrumbs-outside">
            <div class="breadcrumbs__main">
                <div class="breadcrumbs__pointer breadcrumbs__pointer--first">
                    <a href="<?php echo $hesk_settings['site_url']; ?>">
                        <span><?php echo $hesk_settings['site_title']; echo(" > "); ?></span>
                    </a>
                </div>
                
                <div class="breadcrumbs__pointer">
                    <a href="<?php echo $hesk_settings['hesk_url']; ?>">
                        <span><?php echo $hesk_settings['hesk_title']; echo(" > "); ?></span>
                    </a>
                </div>
                                
                <div class="breadcrumbs__pointer breadcrumbs__pointer--last breadcrumbs__pointer--current">
                    <div class="last"><?php echo $hesklang['submit_ticket']; ?></div>
                </div>
            </div>
        </nav>
    </div>
    
    <!-- DROPDOWN MENU -->
    <form action="index.php" method="get">

        <section class="container my-5">
            <div class="helpdesk-form-container">

                <div class="custom-dropdown-wrapper">
                    <select id="ticket-category"
                            name="category"
                            class="custom-select"
                            required>

                        <option value="" disabled selected hidden>
                            Pilih Kategori Kendala...
                        </option>

                        <?php foreach ($hesk_settings['categories'] as $k => $v): ?>
                            <option value="<?php echo $k; ?>">
                                <?php echo htmlspecialchars($v['name']); ?>
                            </option>
                        <?php endforeach; ?>

                    </select>

                    <span class="dropdown-icon">▼</span>
                </div>

                <input type="hidden" name="a" value="add">

                <button type="submit" class="btn-send">
                    <span><?php echo $hesklang['c2c']; ?></span>
                    <svg class="send-icon"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                </button>

            </div>
        </section>

    </form>
<!-- Footer Section -->
<footer class="footer-section py-4 mt-4">
<?php include(TEMPLATE_PATH . '../../footer.txt'); ?>

<?php
/*******************************************************************************
The code below handles HESK licensing and must be included in the template.

Removing this code is a direct violation of the HESK End User License Agreement,
will void all support and may result in unexpected behavior.

To purchase a HESK license and support future HESK development please visit:
https://www.hesk.com/buy.php
*******************************************************************************/
/*******************************************************************************
END LICENSE CODE
*******************************************************************************/
?>
</footer>

        
        <!-- Bootstrap JS && custom js-->
        <script src="<?php echo TEMPLATE_PATH; ?>customer/js/jquery-3.5.1.min.js"></script>
        <script src="<?php echo TEMPLATE_PATH; ?>customer/js/hesk_functions.js?<?php echo $hesk_settings['hesk_version']; ?>"></script>
        <script src="<?php echo TEMPLATE_PATH; ?>customer/js/svg4everybody.min.js"></script>
        <script src="<?php echo TEMPLATE_PATH; ?>customer/js/selectize.min.js?<?php echo $hesk_settings['hesk_version']; ?>"></script>
        <script>
            $(document).ready(function() {
                $('#select_category').selectize();
            });
        </script>
        <script src="<?php echo TEMPLATE_PATH; ?>customer/js/app<?php echo $hesk_settings['debug_mode'] ? '' : '.min'; ?>.js?<?php echo $hesk_settings['hesk_version']; ?>"></script>
        <script src="<?php echo TEMPLATE_PATH; ?>customer/vendor/aos-master/dist/aos.js"></script>                                           
        <script src="<?php echo TEMPLATE_PATH; ?>customer/js/version-01/bootstrap.bundle.min.js"></script>
        <script src="<?php echo TEMPLATE_PATH; ?>customer/js/version-01/main.js"></script>
    </body>
</html>
