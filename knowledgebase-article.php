<?php
global $hesk_settings, $hesklang;
/**
 * @var array $article
 * @var array $attachments
 * @var boolean $showRating
 * @var string $categoryLink
 * @var array $relatedArticles
 * @var bool $customerLoggedIn - `true` if a customer is logged in, `false` otherwise
 * @var array $customerUserContext - User info for a customer if logged in.  `null` if a customer is not logged in.
 */

// This guard is used to ensure that users can't hit this outside of actual HESK code
if (!defined('IN_SCRIPT')) {
    die();
}

require_once(TEMPLATE_PATH . 'customer/util/alerts.php');
require_once(TEMPLATE_PATH . 'customer/util/rating.php');
require_once(TEMPLATE_PATH . 'customer/util/kb-search.php');
require_once(TEMPLATE_PATH . 'customer/partial/login-navbar-elements.php');
?>
<!--service pege-->
<!DOCTYPE html>
<html lang="en" dir="ltr">
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
                        <h4 class="fw-bold m-0 Logo">
                            <a href="<?php echo $hesk_settings['hesk_url']; ?>" class="header__logo">
                                <?php echo $hesk_settings['hesk_title']; ?>
                            </a>
                        </h4>
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

                    <div class="breadcrumbs__pointer breadcrumbs__pointer--first">
                        <a href="<?php echo $hesk_settings['site_url']; ?>">
                            <span><?php echo $hesk_settings['site_title']; ?> &gt; </span>
                        </a>
                    </div>

                    <div class="breadcrumbs__pointer">
                        <a href="<?php echo $hesk_settings['hesk_url']; ?>">
                            <span><?php echo $hesk_settings['hesk_title']; ?> &gt; </span>
                        </a>
                    </div>

                    <?php foreach ($hesk_settings['public_kb_categories'][$article['catid']]['parents'] as $parent_id): ?>
                    <div class="breadcrumbs__pointer">
                        <a href="knowledgebase.php<?php if ($parent_id > 1) echo '?category=' . $parent_id; ?>">
                            <span>
                                <?php echo $hesk_settings['public_kb_categories'][$parent_id]['name']; ?> &gt;
                            </span>
                        </a>
                    </div>
                    <?php endforeach; ?>

                    <div class="breadcrumbs__pointer">
                        <a href="knowledgebase.php<?php if ($article['catid'] > 1) echo '?category=' . $article['catid']; ?>">
                            <span>
                                <?php echo $hesk_settings['public_kb_categories'][$article['catid']]['name']; ?> &gt;
                            </span>
                        </a>
                    </div>

                    <div class="breadcrumbs__pointer breadcrumbs__pointer--last breadcrumbs__pointer--current">
                        <div class="last">
                            <?php echo $article['subject']; ?>
                        </div>
                    </div>

                </div>
            </nav>
        </div>

        <!-- Article Section -->
        <section class="container py-5">
            <div class="row g-4">

                <!-- Main Article -->
                <div class="col-md-8">
                    <div class="service-card h-100">

                        <h1 class="mb-3">
                            <?php echo $article['subject']; ?>
                        </h1>

                        <div class="article-content browser-default">
                            <?php echo $article['content']; ?>
                        </div>

                        <?php if (count($attachments)): ?>
                        <hr>

                        <h5>Attachments</h5>

                        <?php foreach ($attachments as $attachment): ?>
                            <div class="mb-2">
                                <svg class="icon icon-attach">
                                    <use xlink:href="<?php echo TEMPLATE_PATH; ?>customer/img/sprite.svg#icon-attach"></use>
                                </svg>

                                <a href="download_attachment.php?kb_att=<?php echo $attachment['id']; ?>"
                                rel="nofollow">
                                    <?php echo $attachment['name']; ?>
                                </a>
                            </div>
                        <?php endforeach; ?>

                        <?php endif; ?>

                        <?php if ($showRating): ?>
                        <hr>

                        <div id="rate-me" class="d-flex align-items-center gap-2 flex-wrap">
                            <span><?php echo $hesklang['rart']; ?></span>

                            <a href="javascript:"
                            onclick="HESK_FUNCTIONS.rate('rate_kb.php?rating=5&amp;id=<?php echo $article['id']; ?>','article-rating');document.getElementById('rate-me').innerHTML='<?php echo hesk_slashJS($hesklang['tyr']); ?>';"
                            class="link-primary">
                                <?php echo $hesklang['yes_title_case']; ?>
                            </a>

                            <span>|</span>

                            <a href="javascript:"
                            onclick="HESK_FUNCTIONS.rate('rate_kb.php?rating=1&amp;id=<?php echo $article['id']; ?>','article-rating');document.getElementById('rate-me').innerHTML='<?php echo hesk_slashJS($hesklang['tyr']); ?>';"
                            class="link-primary">
                                <?php echo $hesklang['no_title_case']; ?>
                            </a>
                        </div>
                        <?php endif; ?>

                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-md-4">
                    <div class="row g-4">

                        <!-- Article Details -->
                        <div class="col-12">
                            <div class="service-card">

                                <h5>Article Details</h5>

                                <div class="mb-2">
                                    <strong><?php echo $hesklang['aid']; ?>:</strong>
                                    <?php echo $article['id']; ?>
                                </div>

                                <div class="mb-2">
                                    <strong><?php echo $hesklang['category']; ?>:</strong>
                                    <a href="<?php echo $categoryLink; ?>">
                                        <?php echo $article['cat_name']; ?>
                                    </a>
                                </div>

                                <?php if ($hesk_settings['kb_date']): ?>
                                <div class="mb-2">
                                    <strong><?php echo $hesklang['dta']; ?>:</strong>
                                    <?php echo hesk_date($article['dt'], true); ?>
                                </div>
                                <?php endif; ?>

                                <?php if ($hesk_settings['kb_views']): ?>
                                <div class="mb-2">
                                    <strong><?php echo $hesklang['views']; ?>:</strong>
                                    <?php echo $article['views_formatted']; ?>
                                </div>
                                <?php endif; ?>

                                <?php if ($hesk_settings['kb_rating']): ?>
                                <div class="mb-2">
                                    <strong><?php echo $hesklang['rating']; ?>:</strong>

                                    <div id="article-rating">
                                        <?php echo hesk3_get_customer_rating($article['rating']); ?>

                                        <?php if ($hesk_settings['kb_views']): ?>
                                            <span class="text-muted">
                                                (<?php echo $article['votes_formatted']; ?>)
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <hr>

                                <a href="javascript:history.go(<?php echo isset($_GET['rated']) ? '-2' : '-1'; ?>)"
                                class="link-primary fw-semibold">
                                    ← <?php echo $hesklang['back']; ?>
                                </a>

                            </div>
                        </div>

                        <!-- Related Articles -->
                        <?php if (count($relatedArticles) > 0): ?>
                        <div class="col-12">
                            <div class="service-card">

                                <h5><?php echo $hesklang['relart']; ?></h5>

                                <ul class="list-unstyled mb-0">
                                    <?php foreach ($relatedArticles as $id => $subject): ?>
                                    <li class="mb-2">
                                        <a href="knowledgebase.php?article=<?php echo $id; ?>">
                                            <?php echo $subject; ?>
                                        </a>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>

                            </div>
                        </div>
                        <?php endif; ?>

                    </div>
                </div>

            </div>
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
