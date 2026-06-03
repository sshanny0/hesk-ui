<?php
global $hesk_settings, $hesklang;

if (!defined('IN_SCRIPT')) {
    die();
}

/**
 * @var array $top_articles
 * @var array $latest_articles
 * @var array $service_messages
 */

$service_message_type_to_class = array(
    '0' => 'none',
    '1' => 'success',
    '2' => '', // Info has no CSS class
    '3' => 'warning',
    '4' => 'danger'
);

require_once(TEMPLATE_PATH . 'customer/util/alerts.php');
require_once(TEMPLATE_PATH . 'customer/util/kb-search.php');
require_once(TEMPLATE_PATH . 'customer/util/rating.php');
?>

<!--home page-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap -->
        <link href="<?php echo TEMPLATE_PATH; ?>customer/css/01bootstrap.min.css" rel="stylesheet">

        <!-- Bootstrap Icons -->
        <link
            href="<?php echo TEMPLATE_PATH; ?>customer/css/bootstrap-icons-1.13.1/bootstrap-icons.css"
            rel="stylesheet">

        <!-- Custom CSS -->
        <link rel="stylesheet" media="all" href="<?php echo TEMPLATE_PATH; ?>customer/css/app<?php echo $hesk_settings['debug_mode'] ? '' : '.min'; ?>.css?<?php echo $hesk_settings['hesk_version']; ?>" />
        <link rel="stylesheet" href="<?php echo TEMPLATE_PATH; ?>customer/css/01style.css">
        <link rel="stylesheet" href="<?php echo TEMPLATE_PATH; ?>customer/chatbot-api/ui/style.css">
        <link rel="stylesheet"
            href="../../public/assets/fonts/fontawesome/css/all.min.css">
        <!--Aos -->
        <link rel="stylesheet"
            href="<?php echo TEMPLATE_PATH; ?>customer/aos-master/dist/aos.css" />

        <link rel="shortcut icon" href="img/download (35).png"
            type="image/x-icon">
            <title><?php echo $hesk_settings['hesk_title']; ?></title>    

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
                        <h4 class="fw-bold m-0 Logo">
                            <?php echo $hesk_settings['hesk_title']; ?>
                        </h4>                    
                    </div>

                    <a href="index.php?a=add"
                        class="btn px-4 d-none d-lg-block">Kirim Tiket</a>

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
                        <h4 class="fw-bold m-0">
                            <?php echo $hesk_settings['hesk_title']; ?>
                        </h4>
                    </div>

                    <button class="btn-close"
                        data-bs-dismiss="offcanvas"></button>
                </div>

                <div class="offcanvas-body">

                    <a class="btn w-100 mt-3" href="index.php?a=add">Kirim Tiket</a>

                </div>

            </div>
        </header>
        <!-- Hero Section -->
        <section class="hero-modern">
            <div class="container">
                <div class="row align-items-center">

                    <!-- LEFT TEXT -->
                    <div class="col-md-6">

                        <h1 class="hero-title">
                            Halo, ada yang bisa kami bantu?
                        </h1>
                    </div>

                    <!-- RIGHT IMAGE -->
                    <div class="col-md-6 position-relative">

                        <!-- Doctor or Smile Image -->
                        <img src="<?php echo TEMPLATE_PATH; ?>customer/img/helpdesk-agent.png" class="hero-img" />
                    </div>

                </div>
            </div>
        </section>
        <!-- Appointment Bar Section -->
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

            </div>

        </section>

        <?php hesk3_show_messages($service_messages); ?>
        <!-- Features Section -->
        <section class="container py-5 features-grid" data-aos="fade-up">

            <div class="row g-4">

                <!-- Submit Ticket -->
                <div class="col-md-6 feature-col" data-aos="fade-up" data-aos-delay="200">
                    <a href="index.php?a=add" class="text-decoration-none">
                        <div class="feature-item">

                            <i class="bi bi-plus-circle-fill feature-icon"></i>

                            <h5>
                                <?php echo $hesklang['submit_ticket']; ?>
                            </h5>

                            <p>
                                <?php echo $hesklang['open_ticket']; ?>
                            </p>

                        </div>
                    </a>
                </div>

                <!-- View Existing Tickets -->
                <div class="col-md-6 feature-col" data-aos="fade-up" data-aos-delay="300">
                    <a href="ticket.php" class="text-decoration-none">
                        <div class="feature-item">

                            <i class="bi bi-card-list feature-icon"></i>

                            <h5>
                                <?php echo $hesklang['view_existing_tickets']; ?>
                            </h5>

                            <p>
                                <?php echo $hesklang['vet']; ?>
                            </p>

                        </div>
                    </a>
                </div>

                <!-- Service Catalog -->
                <div class="col-md-6 feature-col" data-aos="fade-up" data-aos-delay="400">
                    <a href="layanan.php" class="text-decoration-none">
                        <div class="feature-item">

                            <i class="bi bi-folder2-open feature-icon"></i>

                            <h5>
                                Lihat Katalog Layanan
                            </h5>

                            <p>
                                Tampilkan semua katalog layanan
                            </p>

                        </div>
                    </a>
                </div>

                <!-- FAQ -->
                <div class="col-md-6 feature-col" data-aos="fade-up" data-aos-delay="500">
                    <a href="faq.php" class="text-decoration-none">
                        <div class="feature-item">

                            <i class="bi bi-book feature-icon"></i>

                            <h5>
                                Frequently Asked Questions (FAQ)
                            </h5>

                            <p>
                                Tampilkan semua pertanyaan yang sering diajukan
                            </p>

                        </div>
                    </a>
                </div>

            </div>

        </section>
        <!-- blog section-->
        <section class="container my-5" data-aos="fade-up">
            <h2 class="text-center fw-bold">
                <a href="knowledgebase.php" class="blog-tag">Dasar Pengetahuan</a>
            </h2>

            <div class="tab-menu text-center mb-4">

                <?php if (count($top_articles) > 0): ?>
                    <button class="tab-menu-link is-active" data-content="item-1">
                        <span class="fw-bold"><?php echo $hesklang['popart']; ?></span>
                    </button>
                <?php endif; ?>

                <?php if (count($latest_articles) > 0): ?>
                    <button class="tab-menu-link <?php echo count($top_articles) === 0 ? 'is-active' : ''; ?>" data-content="item-2">
                        <span class="fw-bold"><?php echo $hesklang['latart']; ?></span>
                    </button>
                <?php endif; ?>

            </div>

            <div class="tab-bar">

                <?php if (count($top_articles) > 0): ?>
                    <div class="tab-bar-content is-active" id="item-1">

                        <?php foreach ($top_articles as $article): ?>
                            <a href="knowledgebase.php?article=<?php echo $article['id']; ?>" class="preview">

                                <div class="icon-in-circle">
                                    <i class="bi bi-journal-text"></i>
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


                <?php if (count($latest_articles) > 0): ?>
                    <div class="tab-bar-content <?php echo count($top_articles) === 0 ? 'is-active' : ''; ?>" id="item-2">

                        <?php foreach ($latest_articles as $article): ?>
                            <a href="knowledgebase.php?article=<?php echo $article['id']; ?>" class="preview">

                                <div class="icon-in-circle">
                                    <svg class="icon icon-knowledge">
                                        <use xlink:href="<?php echo TEMPLATE_PATH; ?>customer/img/sprite.svg#icon-knowledge"></use>
                                    </svg>
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

            </div>

        </section>

        <!-- Footer Section -->
        <footer class="footer-section py-5 mt-5">

            <div class="container">

                <hr class="my-4">

                <!-- Bottom Bar -->
                <div
                    class="d-flex justify-content-between align-items-center flex-wrap">

                    <div
                        class="d-flex align-items-center gap-2 logo">
                        <i class="fa-solid fa-headset"></i>
                        <strong> Help Desk Unit TI</strong>
                    </div>

                    <small class="text-muted">
                        Copyright © Politeknik Siber dan Sandi Negara
                    </small>
                </div>

            </div>

        </footer>

<!-- CHATBOT TEST -->
    <div class="chat-bot">
		<div class="chat-content hidden" id="chatBox">
			<div class="chat-header">
				<div class="profile">
					<div class="profile-image">
						<img src="<?php echo TEMPLATE_PATH; ?>customer/chatbot-api/img/icon-helpdesk.png" alt="icon-header">
					</div>
					<div>
						<p>UTI Chatbot</p>
					</div>
				</div>
				<div class="close-chat" id="closeChat">
					<svg viewBox="0 0 640 640" height="20px">
						<path fill="currentColor"
							d="M183.1 137.4C170.6 124.9 150.3 124.9 137.8 137.4C125.3 149.9 125.3 170.2 137.8 182.7L275.2 320L137.9 457.4C125.4 469.9 125.4 490.2 137.9 502.7C150.4 515.2 170.7 515.2 183.2 502.7L320.5 365.3L457.9 502.6C470.4 515.1 490.7 515.1 503.2 502.6C515.7 490.1 515.7 469.8 503.2 457.3L365.8 320L503.1 182.6C515.6 170.1 515.6 149.8 503.1 137.3C490.6 124.8 470.3 124.8 457.8 137.3L320.5 274.7L183.1 137.4z" />
					</svg>
				</div>
			</div>

			<div class="chat-body">
				<ul class="message">
					<li class="sender">
						<img src="<?php echo TEMPLATE_PATH; ?>customer/chatbot-api/img/icon-helpdesk.png" alt="icon-message">
						<div class="message-content">
							<p>Halo, silahkan beritahu saya apabila Anda memiliki pertanyaan atau membutuhkan bantuan.</p>
						</div>
					</li>
				</ul>
			</div>

			<div class="chat-footer">
				<input type="text" class="textInput" placeholder="Type your message">
				<button class="send-button">
					<svg viewBox="0 0 640 640" height="25px">
						<path fill="currentColor"
							d="M568.4 37.7C578.2 34.2 589 36.7 596.4 44C603.8 51.3 606.2 62.2 602.7 72L424.7 568.9C419.7 582.8 406.6 592 391.9 592C377.7 592 364.9 583.4 359.6 570.3L295.4 412.3C290.9 401.3 292.9 388.7 300.6 379.7L395.1 267.3C400.2 261.2 399.8 252.3 394.2 246.7C388.6 241.1 379.6 240.7 373.6 245.8L261.2 340.1C252.1 347.7 239.6 349.7 228.6 345.3L70.1 280.8C57 275.5 48.4 262.7 48.4 248.5C48.4 233.8 57.6 220.7 71.5 215.7L568.4 37.7z" />
					</svg>
				</button>
			</div>
		</div>

		<div class="floating-actions">	
			<div class="whatsapp-button">
				<a href="https://wa.me/6285281023064?text=Halo%2C%20saya%20ingin%20bertanya%20tentang" target="_blank">
					<img src="<?php echo TEMPLATE_PATH; ?>customer/chatbot-api/img/icon-wa.png" alt="WhatsApp">
				</a>
    		</div>
					
			<div class="chat-button" id="chatButton">
				<svg height="25px" viewBox="0 0 640 640">
					<path fill="currentColor"
						d="M115.9 448.9C83.3 408.6 64 358.4 64 304C64 171.5 178.6 64 320 64C461.4 64 576 171.5 576 304C576 436.5 461.4 544 320 544C283.5 544 248.8 536.8 217.4 524L101 573.9C97.3 575.5 93.5 576 89.5 576C75.4 576 64 564.6 64 550.5C64 546.2 65.1 542 67.1 538.3L115.9 448.9z" />
				</svg>
			</div>
		</div>

	</div>
    <?php
/*******************************************************************************
The code below handles HESK licensing and must be included in the template.

Removing this code is a direct violation of the HESK End User License Agreement,
will void all support and may result in unexpected behavior.

To purchase a HESK license and support future HESK development please visit:
https://www.hesk.com/buy.php
*******************************************************************************/
$hesk_settings['hesk_license']('Qo8Zm9vdGVyIGNsYXNzPSJmb290ZXIiPg0KICAgIDxwIGNsY
XNzPSJ0ZXh0LWNlbnRlciI+UG93ZXJlZCBieSA8YSBocmVmPSJodHRwczovL3d3dy5oZXNrLmNvbSIgY
2xhc3M9ImxpbmsiPkhlbHAgRGVzayBTb2Z0d2FyZTwvYT4gPHNwYW4gY2xhc3M9ImZvbnQtd2VpZ2h0L
WJvbGQiPkhFU0s8L3NwYW4+PGJyPk1vcmUgSVQgZmlyZXBvd2VyPyBUcnkgPGEgaHJlZj0iaHR0cHM6L
y93d3cuc3lzYWlkLmNvbS8/dXRtX3NvdXJjZT1IZXNrJmFtcDt1dG1fbWVkaXVtPWNwYyZhbXA7dXRtX
2NhbXBhaWduPUhlc2tQcm9kdWN0X1RvX0hQIiBjbGFzcz0ibGluayI+U3lzQWlkPC9hPjwvcD4NCjwvZ
m9vdGVyPg0K',"\104", "a809404e0adf9823405ee0b536e5701fb7d3c969");
/*******************************************************************************
END LICENSE CODE
*******************************************************************************/
?>

    <script src="<?php echo TEMPLATE_PATH; ?>customer/js/jquery-3.5.1.min.js"></script>
    <script src="<?php echo TEMPLATE_PATH; ?>customer/js/hesk_functions.js?<?php echo $hesk_settings['hesk_version']; ?>"></script>
    <?php outputSearchJavascript(); ?>
    <script src="<?php echo TEMPLATE_PATH; ?>customer/js/app<?php echo $hesk_settings['debug_mode'] ? '' : '.min'; ?>.js?<?php echo $hesk_settings['hesk_version']; ?>"></script>
    <script src="<?php echo TEMPLATE_PATH; ?>customer/js/app<?php echo $hesk_settings['debug_mode'] ? '' : '.min'; ?>.js?<?php echo $hesk_settings['hesk_version']; ?>"></script>


    <script src="<?php echo TEMPLATE_PATH; ?>customer/aos-master/dist/aos.js"></script>                                           
    <script src="<?php echo TEMPLATE_PATH; ?>customer/js/01bootstrap.bundle.min.js"></script>
    <script src="<?php echo TEMPLATE_PATH; ?>customer/js/01main.js"></script>
    <script src="<?php echo TEMPLATE_PATH; ?>customer/chatbot-api/ui/script.js"></script>
    </body>
</html>