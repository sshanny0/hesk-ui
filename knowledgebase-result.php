<?php
global $hesk_settings, $hesklang;
/**
 * @var array $articles List of search results
 * @var bool $customerLoggedIn
 * @var bool $customerLoggedIn - `true` if a customer is logged in, `false` otherwise
 * @var array $customerUserContext - User info for a customer if logged in.  `null` if a customer is not logged in.
 */

// This guard is used to ensure that users can't hit this outside of actual HESK code
if (!defined('IN_SCRIPT')) {
    die();
}

require_once(TEMPLATE_PATH . 'customer/util/kb-search.php');
require_once(TEMPLATE_PATH . 'customer/util/rating.php');
require_once(TEMPLATE_PATH . 'customer/partial/login-navbar-elements.php');
?>

<!--home page-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?php echo $hesk_settings['tmp_title']; ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
        <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0" />
        <?php include(HESK_PATH . 'inc/favicon.inc.php'); ?>
        <meta name="format-detection" content="telephone=no" />        
        <!-- Bootstrap -->
        <link href="<?php echo TEMPLATE_PATH; ?>customer/css/version-01/bootstrap.min.css" rel="stylesheet">

        <!-- Bootstrap Icons -->
        <link href="<?php echo TEMPLATE_PATH; ?>customer/vendor/bootstrap-icons-1.13.1/bootstrap-icons.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link rel="stylesheet" media="all" href="<?php echo TEMPLATE_PATH; ?>customer/css/app<?php echo $hesk_settings['debug_mode'] ? '' : '.min'; ?>.css?<?php echo $hesk_settings['hesk_version']; ?>" />
        <link rel="stylesheet" href="<?php echo TEMPLATE_PATH; ?>customer/css/version-01/style.css">
        <link rel="stylesheet" href="<?php echo TEMPLATE_PATH; ?>customer/vendor/fontawesome-free-7.2.0-web/css/all.min.css">

        <!--Aos -->
        <link rel="stylesheet" href="<?php echo TEMPLATE_PATH; ?>customer/vendor/aos-master/dist/aos.css" />

        <style>
            <?php outputSearchStyling(); ?>
        </style>
        <?php include(TEMPLATE_PATH . '../../head.txt'); ?>
    </head>
    <body>
        <?php renderCommonElementsAfterBody(); ?>
        <!--header section -->
        <header>
            <!-- Navbar (اختياري) -->
            <nav class="navbar main-nav fixed-top py-3 navbar-expand-lg">
                <div
                    class="container d-flex justify-content-between align-items-center">

                    <!-- Logo -->
                    <div class="d-flex align-items-center gap-2 brand-logo">
                        <i class="fa-solid fa-headset"></i>
                        <h4 class="fw-bold m-0 Logo"> <?php echo $hesk_settings['hesk_title']; ?></h4>
                        <?php renderLoginNavbarElements($customerUserContext); ?>
                        <?php renderNavbarLanguageSelect(); ?>
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

        <!-- Breadcrumbs & Search Section -->
        <section class="hero-modern" style="min-height: 140px; padding-top: 95px;">
        </section>

        <section class="container appointment-bar">
            <div class="row g-4">
                <div class="col-12">
                    <div class="search-wrapper">
                        <?php displayKbSearch(); ?>
                    </div>                
                </div>

                <?php if ($noSearchResults): ?>
                    <div class="alert alert-warning w-100">
                        <strong><?php echo $hesklang['no_results_found']; ?></strong><br>
                        <?php echo $hesklang['nosr']; ?>
                    </div>
                <?php endif; ?>

                <?php hesk3_show_messages($serviceMessages); ?>
            </div>
        </section>

        <div class="container mt-4 mb-2">
            <nav class="breadcrumbs-outside">
                <div class="breadcrumbs__main">
                    <!-- Item Pertama -->
                    <div class="breadcrumbs__pointer breadcrumbs__pointer--first">
                        <a href="<?php echo $hesk_settings['site_url']; ?>">
                            <span><?php echo $hesk_settings['site_title']; ?></span>
                        </a>
                    </div>
                    
                    <!-- Item Kedua -->
                    <div class="breadcrumbs__pointer">
                        <a href="<?php echo $hesk_settings['hesk_url']; ?>">
                            <span><?php echo $hesk_settings['hesk_title']; ?></span>
                        </a>
                    </div>
                    
                    <!-- Item Ketiga (Knowledgebase) -->
                    <div class="breadcrumbs__pointer">
                        <a href="knowledgebase.php">
                            <span><?php echo $hesklang['kb_text']; ?></span>
                        </a>
                    </div>
                    
                    <!-- Item Terakhir (Halaman Aktif) -->
                    <div class="breadcrumbs__pointer breadcrumbs__pointer--last breadcrumbs__pointer--current">
                        <div class="last"><?php echo $hesklang['sr']; ?></div>
                    </div>
                </div>
            </nav>
        </div>

        <!-- SEARCH RESULT -->
        <section class="container mb-5">

            <div class="block__head mb-4">
                <h1 class="h-3 text-center">
                    <?php echo $hesklang['sr']; ?> (<?php echo count($articles); ?>)
                </h1>
            </div>

            <?php foreach ($articles as $article): ?>

                <div class="job-box d-md-flex align-items-center justify-content-between mb-30">

                    <div class="job-left my-4 d-md-flex align-items-center flex-wrap">

                        <div class="img-holder mr-md-4 mb-md-0 mb-4 mx-auto mx-md-0 d-flex">
                            KB
                        </div>

                        <div class="job-content">

                            <h5 class="text-center text-md-left">
                                <?php echo $article['subject']; ?>
                            </h5>

                            <ul class="d-md-flex flex-wrap">

                                <?php if ($hesk_settings['kb_views']): ?>
                                    <li class="mr-md-4">
                                        👁 <?php echo $article['views_formatted']; ?> Views
                                    </li>
                                <?php endif; ?>

                                <?php if ($hesk_settings['kb_rating']): ?>
                                    <li class="mr-md-4">
                                        ⭐ <?php echo $article['rating']; ?>
                                    </li>
                                    <li class="mr-md-4">
                                        🗳 <?php echo $article['votes_formatted']; ?> Votes
                                    </li>
                                <?php endif; ?>

                            </ul>

                            <p class="mt-2 mb-0">
                                <?php echo $article['content_preview']; ?>
                            </p>

                        </div>

                    </div>

                    <div class="job-right my-4 flex-shrink-0">
                        <a href="knowledgebase.php?article=<?php echo $article['id']; ?>"
                        class="btn btn-light d-block w-100 d-sm-inline-block">
                            Read Article
                        </a>
                    </div>

                </div>

            <?php endforeach; ?>

        </section>
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
        <?php include(TEMPLATE_PATH . '../../footer.txt'); ?>
        <script src="<?php echo TEMPLATE_PATH; ?>customer/js/jquery-3.5.1.min.js"></script>
        <script src="<?php echo TEMPLATE_PATH; ?>customer/js/hesk_functions.js?<?php echo $hesk_settings['hesk_version']; ?>"></script>
        <?php outputSearchJavascript(); ?>
        <script src="<?php echo TEMPLATE_PATH; ?>customer/js/svg4everybody.min.js"></script>
        <script src="<?php echo TEMPLATE_PATH; ?>customer/js/selectize.min.js?<?php echo $hesk_settings['hesk_version']; ?>"></script>
        <script src="<?php echo TEMPLATE_PATH; ?>customer/js/app<?php echo $hesk_settings['debug_mode'] ? '' : '.min'; ?>.js?<?php echo $hesk_settings['hesk_version']; ?>"></script>
        <script src="<?php echo TEMPLATE_PATH; ?>customer/vendor/aos-master/dist/aos.js"></script>                                           
        <script src="<?php echo TEMPLATE_PATH; ?>customer/js/version-01/bootstrap.bundle.min.js"></script>
    </body>
</html>