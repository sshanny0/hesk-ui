<?php
global $hesk_settings, $hesklang;
/**
 * @var array $currentCategory
 * @var array $subcategories
 * @var string $subcategoriesWidth
 * @var string $parentLink
 * @var array $articlesInCategory
 * @var array $serviceMessages
 * @var boolean $noSearchResults
 * @var array $topArticles
 * @var array $latestArticles
 * @var array $latestArticles
 * @var bool $customerLoggedIn - `true` if a customer is logged in, `false` otherwise
 * @var array $customerUserContext - User info for a customer if logged in.  `null` if a customer is not logged in.
 */

// This guard is used to ensure that users can't hit this outside of actual HESK code
if (!defined('IN_SCRIPT')) {
    die();
}

require_once(TEMPLATE_PATH . 'customer/util/alerts.php');
require_once(TEMPLATE_PATH . 'customer/util/kb-search.php');
require_once(TEMPLATE_PATH . 'customer/util/rating.php');
require_once(TEMPLATE_PATH . 'customer/partial/login-navbar-elements.php');

$service_message_type_to_class = array(
    '0' => 'none',
    '1' => 'success',
    '2' => '', // Info has no CSS class
    '3' => 'warning',
    '4' => 'danger'
);
?>

<!--home page-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?php echo $hesk_settings['tmp_title']; ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
        <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0" />
        
        <!-- Bootstrap -->
        <link href="<?php echo TEMPLATE_PATH; ?>customer/css/version-01/bootstrap.min.css" rel="stylesheet">

        <!-- Bootstrap Icons -->
        <link href="<?php echo TEMPLATE_PATH; ?>customer/vendor/bootstrap-icons-1.13.1/bootstrap-icons.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link rel="stylesheet" media="all" href="<?php echo TEMPLATE_PATH; ?>customer/css/app<?php echo $hesk_settings['debug_mode'] ? '' : '.min'; ?>.css?<?php echo $hesk_settings['hesk_version']; ?>" />
        <link rel="stylesheet" href="<?php echo TEMPLATE_PATH; ?>customer/css/version-01/style.css">
        <link rel="stylesheet" href="<?php echo TEMPLATE_PATH; ?>customer/chatbot-api/ui/style.css">
        <link rel="stylesheet" href="<?php echo TEMPLATE_PATH; ?>customer/vendor/fontawesome-free-7.2.0-web/css/all.min.css">

        <!--Aos -->
        <link rel="stylesheet" href="<?php echo TEMPLATE_PATH; ?>customer/vendor/aos-master/dist/aos.css" />

        <style>
            <?php outputSearchStyling(); ?>
        </style>
        <?php include(TEMPLATE_PATH . '../../head.txt'); ?>
    </head>
    <body>
        <!--header section -->
        <header>
            <!-- Navbar (اختياري) -->
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
        <!-- Breadcrumbs Section -->
        <section class="hero-modern">
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
                    
                    <!-- Item Ketiga (Looping Kategori) -->
                    <?php foreach ($hesk_settings['public_kb_categories'][$currentCategory['id']]['parents'] as $parent_id): ?>
                    <div class="breadcrumbs__pointer">
                        <a href="knowledgebase.php<?php if ($parent_id > 1) echo "?category={$parent_id}"; ?>">
                            <span><?php echo $hesk_settings['public_kb_categories'][$parent_id]['name']; ?></span>
                        </a>
                    </div>
                    <?php endforeach; ?>
                    
                    <!-- Item Terakhir (Halaman Aktif) -->
                    <div class="breadcrumbs__pointer breadcrumbs__pointer--last breadcrumbs__pointer--current">
                        <div class="last"><?php echo $currentCategory['name']; ?></div>
                    </div>
                </div>
        </section>
        <!-- Search Bar Section -->
        <section class="container appointment-bar">

            <div class="row g-4 align-items-end">

                <div class="col-md-10">
                    <div class="search-wrapper">
                        <h2 class="search__title"><?php echo $hesklang['how_can_we_help']; ?></h2>
                        <?php displayKbSearch(); ?>
                    </div>                
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn make-btn w-100">
                        Cari
                    </button>
                </div>

                <?php if ($noSearchResults): ?>
                    <div class="alert alert-warning">
                        <strong><?php echo $hesklang['no_results_found']; ?></strong><br>
                        <?php echo $hesklang['nosr']; ?>
                    </div>
                <?php endif; ?>

                <?php hesk3_show_messages($serviceMessages); ?>

            </div>

        </section>

        <!-- Knowledge Base Header -->
        <section class="container my-5">
            <div class="row g-0">
                <div class="col-12">
                    <div class="appointment-box p-5">
                        <h3 class="fw-bold text-white">
                            <?php echo $currentCategory['name']; ?>
                        </h3>
                        <p class="text-white mb-0">
                            Browse articles and resources available in this category.
                        </p>
                    </div>
                </div> 
            </div>
        </section>

                <!-- Subcategories -->
                <?php if (count($subcategories) > 0): ?>
                    <section class="container mb-5">

                        <div class="row g-4">

                            <?php foreach ($subcategories as $subcategory): ?>

                                <div class="col-md-6 col-lg-4">

                                    <div class="appointment-box p-4 h-100">

                                        <h4 class="fw-bold text-white mb-3">
                                            <a href="knowledgebase.php?category=<?php echo $subcategory['subcategory']['id']; ?>"
                                            class="fw-bold text-white text-decoration-none">
                                                <?php echo $subcategory['subcategory']['name']; ?>
                                            </a>
                                        </h4>

                                        <ul class="list-unstyled mb-0">

                                            <?php foreach ($subcategory['articles'] as $article): ?>
                                                <li class="mb-2">
                                                    <a href="knowledgebase.php?article=<?php echo $article['id']; ?>"
                                                    class="text-white text-decoration-none">
                                                        • <?php echo $article['subject']; ?>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>

                                            <?php if ($subcategory['displayShowMoreLink']): ?>
                                                <li class="mt-3">
                                                    <a href="knowledgebase.php?category=<?php echo $subcategory['subcategory']['id']; ?>"
                                                    class="text-white fw-bold">
                                                        <?php echo $hesklang['m']; ?> →
                                                    </a>
                                                </li>
                                            <?php endif; ?>

                                        </ul>

                                    </div>

                                </div>

                            <?php endforeach; ?>

                        </div>

                    </section>
                <?php endif; ?>

                <!-- Articles -->
                <?php if (count($articlesInCategory) > 0): ?>

                    <section class="container mb-5">

                        <div class="row g-4">

                            <?php foreach ($articlesInCategory as $article): ?>

                                <div class="col-md-6">

                                    <a href="knowledgebase.php?article=<?php echo $article['id']; ?>"
                                    class="text-decoration-none">

                                        <div class="appointment-box p-4 h-100">

                                            <h4 class="fw-bold text-white">
                                                <?php echo $article['subject']; ?>
                                            </h4>

                                            <p class="text-white mb-3">
                                                <?php echo $article['content_preview']; ?>
                                            </p>

                                            <?php if ($hesk_settings['kb_views']): ?>
                                                <small class="text-white">
                                                    👁 <?php echo $article['views_formatted']; ?>
                                                </small>
                                            <?php endif; ?>

                                        </div>

                                    </a>

                                </div>

                            <?php endforeach; ?>

                        </div>

                    </section>

                <?php endif; ?>

                <!-- Empty Category -->
                <?php if (!count($articlesInCategory) && !count($subcategories)): ?>

                    <section class="container my-5">

                        <div class="appointment-box p-5 text-center">

                            <h4 class="text-white mb-3">
                                <?php echo $hesklang['noac']; ?>
                            </h4>

                            <a href="javascript:history.go(-1)"
                            class="btn btn-light">
                                <?php echo $hesklang['back']; ?>
                            </a>

                        </div>

                    </section>

                <?php endif; ?>

                <?php if (count($topArticles) > 0 || count($latestArticles) > 0): ?>
                <section class="container my-5" data-aos="fade-up">
                    <h2 class="text-center fw-bold">
                        <a href="knowledgebase.php" class="blog-tag" style="font-size: calc(1.325rem + 0.9vw);">
                            <?php echo $hesklang['sc']; ?>
                        </a>
                    </h2>

                    <div class="tab-menu text-center mb-4">

                        <?php if (count($topArticles) > 0): ?>
                            <button class="tab-menu-link is-active" data-content="item-1">
                                <span class="fw-bold"><?php echo $hesklang['popart']; ?></span>
                            </button>
                        <?php endif; ?>

                        <?php if (count($latestArticles) > 0): ?>
                            <button class="tab-menu-link <?php echo count($topArticles) === 0 ? 'is-active' : ''; ?>" data-content="item-2">
                                <span class="fw-bold"><?php echo $hesklang['latart']; ?></span>
                            </button>
                        <?php endif; ?>

                    </div>

                    <div class="tab-bar">

                        <!-- TOP ARTICLES -->
                        <?php if (count($topArticles) > 0): ?>
                            <div class="tab-bar-content is-active" id="item-1">

                                <?php foreach ($topArticles as $article): ?>
                                    <a href="knowledgebase.php?article=<?php echo $article['id']; ?>" class="preview">

                                        <div class="circle-knowledge">
                                            <i class="bi bi-bookmark-star-fill"></i>
                                        </div>

                                        <div class="preview__text">
                                            <h5 class="preview__title">
                                                <?php echo $article['subject']; ?>
                                            </h5>

                                            <p>
                                                <span class="lightgrey">
                                                    <?php echo $hesklang['kb_cat']; ?>:
                                                </span>

                                                <span class="ml-1">
                                                    <?php echo $article['category']; ?>
                                                </span>
                                            </p>

                                            <p class="navlink__descr">
                                                <?php echo $article['content_preview']; ?>
                                            </p>
                                        </div>

                                        <?php if ($hesk_settings['kb_views'] || $hesk_settings['kb_rating']): ?>
                                            <div class="rate">

                                                <?php if ($hesk_settings['kb_views']): ?>
                                                    <div style="margin-right:10px;display:flex;">
                                                        <svg class="icon icon-eye-close">
                                                            <use xlink:href="<?php echo TEMPLATE_PATH; ?>customer/img/sprite.svg#icon-eye-close"></use>
                                                        </svg>

                                                        <span class="lightgrey">
                                                            <?php echo $article['views_formatted']; ?>
                                                        </span>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if ($hesk_settings['kb_rating']): ?>
                                                    <?php echo hesk3_get_customer_rating($article['rating']); ?>

                                                    <?php if ($hesk_settings['kb_views']): ?>
                                                        <span class="lightgrey">
                                                            (<?php echo $article['votes_formatted']; ?>)
                                                        </span>
                                                    <?php endif; ?>

                                                <?php endif; ?>

                                            </div>
                                        <?php endif; ?>

                                    </a>
                                <?php endforeach; ?>

                            </div>
                        <?php endif; ?>

                        <!-- LATEST ARTICLES -->
                        <?php if (count($latestArticles) > 0): ?>
                            <div class="tab-bar-content <?php echo count($topArticles) === 0 ? 'is-active' : ''; ?>" id="item-2">

                                <?php foreach ($latestArticles as $article): ?>
                                    <a href="knowledgebase.php?article=<?php echo $article['id']; ?>" class="preview">

                                        <div class="circle-knowledge">
                                            <i class="bi bi-bookmark-star-fill"></i>
                                        </div>

                                        <div class="preview__text">
                                            <h5 class="preview__title">
                                                <?php echo $article['subject']; ?>
                                            </h5>

                                            <p>
                                                <span class="lightgrey">
                                                    <?php echo $hesklang['kb_cat']; ?>:
                                                </span>

                                                <span class="ml-1">
                                                    <?php echo $article['category']; ?>
                                                </span>
                                            </p>

                                            <p class="navlink__descr">
                                                <?php echo $article['content_preview']; ?>
                                            </p>
                                        </div>

                                        <?php if ($hesk_settings['kb_views'] || $hesk_settings['kb_rating']): ?>
                                            <div class="rate">

                                                <?php if ($hesk_settings['kb_views']): ?>
                                                    <div style="margin-right:10px;display:flex;">
                                                        <svg class="icon icon-eye-close">
                                                            <use xlink:href="<?php echo TEMPLATE_PATH; ?>customer/img/sprite.svg#icon-eye-close"></use>
                                                        </svg>

                                                        <span class="lightgrey">
                                                            <?php echo $article['views_formatted']; ?>
                                                        </span>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if ($hesk_settings['kb_rating']): ?>
                                                    <?php echo hesk3_get_customer_rating($article['rating']); ?>

                                                    <?php if ($hesk_settings['kb_views']): ?>
                                                        <span class="lightgrey">
                                                            (<?php echo $article['votes_formatted']; ?>)
                                                        </span>
                                                    <?php endif; ?>

                                                <?php endif; ?>

                                            </div>
                                        <?php endif; ?>

                                    </a>
                                <?php endforeach; ?>

                            </div>
                        <?php endif; ?>

                        <div class="view-all text-center mt-4">
                            <a href="knowledgebase.php" class="btn knowledge-btn">
                                <?php echo $hesklang['viewkb']; ?>
                            </a>
                        </div>

                    </div>
                </section>
                <?php endif; ?>
            </div>
        </div>

        <!-- Footer Section -->
        <footer class="footer-section py-4 mt-4">

            <div class="container">

                <hr class="my-4">

                <!-- Bottom Bar -->
                <div
                    class="d-flex justify-content-between align-items-center flex-wrap">

                    <div
                        class="d-flex align-items-center gap-2 logo">
                        <i class="fa-solid fa-headset"></i>
                        <strong> <?php echo $hesk_settings['hesk_title']; ?></strong>
                    </div>

                    <small class="text-muted">
                        Copyright © Politeknik Siber dan Sandi Negara
                    </small>
                </div>
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
            </div>
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
<script src="<?php echo TEMPLATE_PATH; ?>customer/js/version-01/main.js"></script>
    </body>
</html>