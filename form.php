<?php
global $hesk_settings, $hesklang;
/**
 * @var string $categoryName
 * @var int $categoryId
 * @var array $visibleCustomFieldsBeforeMessage
 * @var array $visibleCustomFieldsAfterMessage
 * @var array $customFieldsBeforeMessage
 * @var array $customFieldsAfterMessage
 * @var bool $customerLoggedIn - `true` if a customer is logged in, `false` otherwise
 * @var array $customerUserContext - User info for a customer if logged in.  `null` if a customer is not logged in.
 */

// This guard is used to ensure that users can't hit this outside of actual HESK code
if (!defined('IN_SCRIPT')) {
    die();
}

require_once(TEMPLATE_PATH . 'customer/util/alerts.php');
require_once(TEMPLATE_PATH . 'customer/util/custom-fields.php');
require_once(TEMPLATE_PATH . 'customer/util/attachments.php');
require_once(TEMPLATE_PATH . 'customer/partial/login-navbar-elements.php');
require_once(HESK_PATH . 'inc/priorities.inc.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <title><?php echo $hesk_settings['tmp_title']; ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <?php include(HESK_PATH . 'inc/favicon.inc.php'); ?>
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0" />
    <meta name="format-detection" content="telephone=no" />
    <!-- Bootstrap -->
    <link href="<?php echo TEMPLATE_PATH; ?>customer/css/version-01/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="<?php echo TEMPLATE_PATH; ?>customer/vendor/bootstrap-icons-1.13.1/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" media="all" href="<?php echo TEMPLATE_PATH; ?>customer/css/dropzone.min.css?<?php echo $hesk_settings['hesk_version']; ?>" />
    <link rel="stylesheet" media="all" href="<?php echo TEMPLATE_PATH; ?>customer/css/app<?php echo $hesk_settings['debug_mode'] ? '' : '.min'; ?>.css?<?php echo $hesk_settings['hesk_version']; ?>" />
    <link rel="stylesheet" href="<?php echo TEMPLATE_PATH; ?>customer/css/version-01/style.css">
    <link rel="stylesheet" href="<?php echo TEMPLATE_PATH; ?>customer/css/version-01/dropdown.css">
    <link rel="stylesheet" href="<?php echo TEMPLATE_PATH; ?>customer/vendor/fontawesome-free-7.2.0-web/css/all.min.css">

    <!--Aos -->
    <link rel="stylesheet" href="<?php echo TEMPLATE_PATH; ?>customer/vendor/aos-master/dist/aos.css" />2
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

                    <svg class="icon icon-chevron-right">
                        <use xlink:href="<?php echo TEMPLATE_PATH; ?>customer/img/sprite.svg#icon-chevron-right"></use>
                    </svg>
                </div>
                
                <div class="breadcrumbs__pointer">
                    <a href="<?php echo $hesk_settings['hesk_url']; ?>">
                        <span><?php echo $hesk_settings['hesk_title']; echo(" > "); ?></span>
                    </a>

                    <svg class="icon icon-chevron-right">
                        <use xlink:href="<?php echo TEMPLATE_PATH; ?>customer/img/sprite.svg#icon-chevron-right"></use>
                    </svg>
                </div>

                <div class="breadcrumbs__pointer">
                    <a href="<?php echo $hesk_settings['hesk_url'] . '?a=add'; ?>">
                        <span><?php echo $hesklang['submit_ticket']; ?></span>
                    </a>

                    <svg class="icon icon-chevron-right">
                        <use xlink:href="<?php echo TEMPLATE_PATH; ?>customer/img/sprite.svg#icon-chevron-right"></use>
                    </svg>
                </div>
                                
                <div class="breadcrumbs__pointer breadcrumbs__pointer--last breadcrumbs__pointer--current">
                    <div class="last"><?php echo $categoryName; ?></div>
                </div>
            </div>
        </nav>
    </div>

    <div style="margin-bottom: 20px;">
        <?php hesk3_show_messages($serviceMessages); ?>
        <?php hesk3_show_messages($messages); ?>
    </div>

    <div class="page-wrapper bg-gra-03 p-t-45 p-b-50">
        <div class="wrapper wrapper--w790">
            <div class="card card-5">
                <div class="card-heading">
                    <h2 class="title"><?php echo $hesklang['submit_a_support_request']; ?></h2>
                </div>
                <div class="card-body">
                    <form class="form form-submit-ticket ticket-create <?php echo count($_SESSION['iserror']) ? 'invalid' : ''; ?>" 
                        method="post" 
                        action="submit_ticket.php?submit=1" 
                        aria-label="<?php echo $hesklang['create_a_ticket']; ?>" 
                        name="form1" 
                        id="form1" 
                        enctype="multipart/form-data" 
                        onsubmit="<?php if ($hesk_settings['submitting_wait']): ?>hesk_showLoadingMessage('recaptcha-submit');<?php endif; ?>">

                        <?php if (!$customerLoggedIn) { 
                            $name_css = 'input--style-5';
                            if (in_array('name', $_SESSION['iserror'])) { $name_css .= ' isError'; }
                        ?>
                        <div class="form-row m-b-55">
                            <div class="name"><?php echo $hesklang['name']; ?></div>
                            <div class="value">
                                <div class="input-group-desc">
                                    <input class="<?php echo $name_css; ?>" type="text" id="name" name="name" maxlength="50"
                                        value="<?php if (isset($_SESSION['c_name'])) { echo stripslashes(hesk_input($_SESSION['c_name'])); } ?>" required>
                                </div>
                            </div>
                        </div>

                        <?php 
                            $email_css = 'input--style-5';
                            if (in_array('email', $_SESSION['iserror'])) { $email_css .= ' isError'; }
                            if (in_array('email', $_SESSION['isnotice'])) { $email_css .= ' isNotice'; }
                        ?>
                        <div class="form-row">
                            <div class="name"><?php echo $hesklang['email']; ?></div>
                            <div class="value">
                                <div class="input-group">
                                    <input class="<?php echo $email_css; ?>" type="email" name="email" id="email" maxlength="1000"
                                        value="<?php if (isset($_SESSION['c_email'])) { echo stripslashes(hesk_input($_SESSION['c_email'])); } ?>" 
                                        <?php if($hesk_settings['detect_typos']) { echo ' onblur="HESK_FUNCTIONS.suggestEmail(\'email\', \'email_suggestions\', 0)"'; } ?>
                                        <?php if ($hesk_settings['require_email']) { ?>required<?php } ?>>
                                    <div id="email_suggestions"></div>
                                </div>
                            </div>
                        </div>

                        <?php if ($hesk_settings['confirm_email']): 
                            $email2_css = 'input--style-5';
                            if (in_array('email2', $_SESSION['iserror'])) { $email2_css .= ' isError'; }
                            if (in_array('email2', $_SESSION['isnotice'])) { $email2_css .= ' isNotice'; }
                            if ($customerLoggedIn) { $email2_css .= ' as-text'; }
                        ?>
                        <div class="form-row">
                            <div class="name"><?php echo $hesklang['confemail']; ?></div>
                            <div class="value">
                                <div class="input-group">
                                    <input type="<?php echo $hesk_settings['multi_eml'] ? 'text' : 'email'; ?>"
                                        class="<?php echo $email2_css; ?>" name="email2" id="email2" maxlength="1000"
                                        <?php if ($customerLoggedIn) { echo 'readonly'; } ?>
                                        value="<?php if (isset($_SESSION['c_email2'])) { echo stripslashes(hesk_input($_SESSION['c_email2'])); } ?>"
                                        <?php if ($hesk_settings['require_email']) { ?>required<?php } ?>>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php } // Akhir dari kondisi !$customerLoggedIn ?>

                        <?php if ($hesk_settings['multi_eml'] && !isset($_SESSION['c_followers'])): ?>
                        <div class="form-row" id="cc-link">
                            <div class="name"></div>
                            <div class="value">
                                <a href="#" onclick="HESK_FUNCTIONS.toggleLayerDisplay('cc-div');HESK_FUNCTIONS.toggleLayerDisplay('cc-link')">
                                    <?php echo $hesklang['add_cc']; ?>
                                </a>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if ($hesk_settings['multi_eml']): 
                            $display = isset($_SESSION['c_followers']) ? 'block' : 'none';
                            $follower_css = 'input--style-5';
                            if (in_array('followers', $_SESSION['iserror'])) { $follower_css .= ' isError'; }
                            if (in_array('followers', $_SESSION['isnotice'])) { $follower_css .= ' isNotice'; }
                        ?>
                        <div class="form-row" id="cc-div" style="display: <?php echo $display; ?>">
                            <div class="name"><?php echo $hesklang['cc']; ?></div>
                            <div class="value">
                                <div class="input-group">
                                    <input type="text" class="<?php echo $follower_css; ?>" name="follower_email" id="follower_email" maxlength="1000"
                                        value="<?php if (isset($_SESSION['c_followers'])) { echo stripslashes(hesk_input($_SESSION['c_followers'])); } ?>" 
                                        <?php if($hesk_settings['detect_typos']) { echo ' onblur="HESK_FUNCTIONS.suggestEmail(\'follower_email\', \'follower_email_suggestions\', 0)"'; } ?>>
                                    <div id="follower_email_suggestions"></div>
                                    <p style="font-size: 11px; color: #666; margin-top: 5px;">
                                        <?php if ($hesk_settings['customer_accounts'] && $hesk_settings['customer_accounts_required']) echo $hesklang['only_verified_cc'] . ' '; echo $hesklang['cc_help']; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if ($hesk_settings['cust_urgency']): ?>
                        <div class="form-row">
                            <div class="name <?php if (in_array('priority',$_SESSION['iserror'])) echo 'isErrorStr'; ?>"><?php echo $hesklang['priority']; ?></div>
                            <div class="value">
                                <div class="input-group">
                                    <div class="rs-select2 js-select-simple select--no-search">
                                        <select name="priority">
                                            <?php if ($hesk_settings['select_pri']): ?>
                                                <option value=""><?php echo $hesklang['select']; ?></option>
                                            <?php endif; ?>
                                            <?php echo hesk_get_priority_select('', 0, $_SESSION['c_priority']); ?>
                                        </select>
                                        <div class="select-dropdown"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php hesk3_output_custom_fields($customFieldsBeforeMessage); ?>

                        <?php if ($hesk_settings['require_subject'] != -1): ?>
                        <div class="form-row">
                            <div class="name"><?php echo $hesklang['subject']; ?></div>
                            <div class="value">
                                <div class="input-group">
                                    <input type="text" id="subject" name="subject" maxlength="70"
                                        class="input--style-5 <?php if (in_array('subject',$_SESSION['iserror'])) {echo 'isError';} ?>"
                                        value="<?php if (isset($_SESSION['c_subject'])) { echo stripslashes(hesk_input($_SESSION['c_subject'])); } ?>"
                                        <?php if ($hesk_settings['require_subject']) { ?>required<?php } ?>>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if ($hesk_settings['require_message'] != -1): ?>
                        <div class="form-row">
                            <div class="name"><?php echo $hesklang['message']; ?></div>
                            <div class="value">
                                <div class="input-group">
                                    <textarea class="input--style-5 <?php if (in_array('message',$_SESSION['iserror'])) {echo 'isError';} ?>"
                                            id="message" name="message" rows="12" 
                                            <?php if ($hesk_settings['require_message']) { ?>required<?php } ?>><?php if (isset($_SESSION['c_message'])) { echo stripslashes(hesk_input($_SESSION['c_message'])); } ?></textarea>
                                    
                                    <?php if (has_public_kb() && $hesk_settings['kb_recommendanswers'] && ! isset($_REQUEST['do_not_suggest'])): ?>
                                        <div class="kb-suggestions" style="margin-top: 10px;">
                                            <h2><?php echo $hesklang['sc']; ?>:</h2>
                                            <ul id="kb-suggestion-list" class="type--list"></ul>
                                            <div id="suggested-article-hidden-inputs" style="display: none"></div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php hesk3_output_custom_fields($customFieldsAfterMessage); ?>

                        <?php if ($hesk_settings['attachments']['use']): ?>
                        <div class="form-row">
                            <div class="name"><?php echo $hesklang['attachments']; ?></div>
                            <div class="value">
                                <div class="input-group">
                                    <?php hesk3_output_drag_and_drop_attachment_holder(); ?>
                                    <div class="attach-tooltype" style="margin-top: 5px;">
                                        <a class="link" href="file_limits.php" onclick="HESK_FUNCTIONS.openWindow('file_limits.php',250,500);return false;">
                                            <?php echo $hesklang['ful']; ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if ($hesk_settings['question_use'] || ($hesk_settings['secimg_use'] && $hesk_settings['recaptcha_use'] !== 1)): ?>
                        <div class="captcha-block" style="margin-bottom: 30px;">
                            <h2 style="font-size: 16px; font-weight: bold; margin-bottom: 15px;"><?php echo $hesklang['verify_header']; ?></h2>

                            <?php if ($hesk_settings['question_use']): 
                                $q_val = isset($_SESSION['c_question']) ? stripslashes(hesk_input($_SESSION['c_question'])) : '';
                            ?>
                            <div class="form-row">
                                <div class="name"><?php echo $hesk_settings['question_ask']; ?></div>
                                <div class="value">
                                    <input type="text" id="question" name="question" size="20" 
                                        class="input--style-5 <?php echo in_array('question',$_SESSION['iserror']) ? 'isError' : ''; ?>" value="<?php echo $q_val; ?>">
                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if ($hesk_settings['secimg_use'] && $hesk_settings['recaptcha_use'] != 1): ?>
                            <div class="form-row">
                                <div class="name"><?php echo $hesklang['sec_enter']; ?></div>
                                <div class="value">
                                    <?php if (isset($_SESSION['img_verified'])): ?>
                                        <?php echo $hesklang['vrfy']; ?>
                                    <?php elseif ($hesk_settings['recaptcha_use'] == 2): ?>
                                        <div class="g-recaptcha" data-sitekey="<?php echo $hesk_settings['recaptcha_public_key']; ?>"></div>
                                    <?php else: 
                                        $sec_css = in_array('mysecnum',$_SESSION['iserror']) ? 'isError' : '';
                                    ?>
                                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                                            <img name="secimg" src="print_sec_img.php?<?php echo rand(10000,99999); ?>" width="150" height="40" alt="<?php echo $hesklang['sec_img']; ?>" title="<?php echo $hesklang['sec_img']; ?>">
                                            <a class="btn btn-refresh" href="javascript:void(0)" onclick="javascript:document.form1.secimg.src='print_sec_img.php?'+ ( Math.floor((90000)*Math.random()) + 10000);">
                                                Refresh
                                            </a>
                                        </div>
                                        <input type="text" id="mysecnum" name="mysecnum" size="20" maxlength="5" autocomplete="off" class="input--style-5 <?php echo $sec_css; ?>">
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>

                        <?php if ($hesk_settings['submit_notice']): ?>
                        <div class="alert" style="background: #fdf6e2; border-left: 4px solid #f5b041; padding: 15px; margin-bottom: 30px; font-size: 13px;">
                            <b class="font-weight-bold"><?php echo $hesklang['before_submit']; ?>:</b>
                            <ul style="margin-left: 20px;">
                                <li><?php echo $hesklang['all_info_in']; ?>.</li>
                                <li><?php echo $hesklang['all_error_free']; ?>.</li>
                            </ul>
                            <br>
                            <b class="font-weight-bold"><?php echo $hesklang['we_have']; ?>:</b>
                            <ul style="margin-left: 20px;">
                                <li><?php echo hesk_htmlspecialchars(hesk_getClientIP()).' '.$hesklang['recorded_ip']; ?></li>
                                <li><?php echo $hesklang['recorded_time']; ?></li>
                            </ul>
                        </div>
                        <?php endif; ?>

                        <div>
                            <input type="hidden" name="token" value="<?php hesk_token_echo(); ?>">
                            <input type="hidden" name="category" value="<?php echo $categoryId; ?>">
                            
                            <input type="hidden" name="hx" value="3" />
                            <input type="hidden" name="hy" value="">

                            <button type="submit" class="btn make-btn w-100" id="recaptcha-submit" style="width: 100%;">
                                <?php echo $hesklang['sub_ticket']; ?>
                            </button>
                        </div>

                        <?php if ($hesk_settings['secimg_use'] && $hesk_settings['recaptcha_use'] == 1 && ! isset($_SESSION['img_verified'])): ?>
                            <div class="g-recaptcha" data-sitekey="<?php echo $hesk_settings['recaptcha_public_key']; ?>" data-bind="recaptcha-submit" data-callback="recaptcha_submitForm"></div>
                        <?php endif; ?>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="loading-overlay" class="loading-overlay">
        <div id="loading-message" class="loading-message">
            <div class="spinner"></div>
            <p><?php echo $hesklang['sending_wait']; ?></p>
        </div>
    </div>

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

<?php include(TEMPLATE_PATH . '../../footer.txt'); ?>
<script src="<?php echo TEMPLATE_PATH; ?>customer/js/jquery-3.5.1.min.js"></script>
<script src="<?php echo TEMPLATE_PATH; ?>customer/js/hesk_functions.js?<?php echo $hesk_settings['hesk_version']; ?>"></script>
<script src="<?php echo TEMPLATE_PATH; ?>customer/js/svg4everybody.min.js"></script>
<script src="<?php echo TEMPLATE_PATH; ?>customer/js/selectize.min.js?<?php echo $hesk_settings['hesk_version']; ?>"></script>
<script src="<?php echo TEMPLATE_PATH; ?>customer/js/datepicker.min.js"></script>
<script src="<?php echo TEMPLATE_PATH; ?>customer/js/dropzone.min.js"></script>
<script type="text/javascript">
(function ($) { $.fn.datepicker.language['en'] = {
    days: ['<?php echo $hesklang['d0']; ?>', '<?php echo $hesklang['d1']; ?>', '<?php echo $hesklang['d2']; ?>', '<?php echo $hesklang['d3']; ?>', '<?php echo $hesklang['d4']; ?>', '<?php echo $hesklang['d5']; ?>', '<?php echo $hesklang['d6']; ?>'],
    daysShort: ['<?php echo $hesklang['sun']; ?>', '<?php echo $hesklang['mon']; ?>', '<?php echo $hesklang['tue']; ?>', '<?php echo $hesklang['wed']; ?>', '<?php echo $hesklang['thu']; ?>', '<?php echo $hesklang['fri']; ?>', '<?php echo $hesklang['sat']; ?>'],
    daysMin: ['<?php echo $hesklang['su']; ?>', '<?php echo $hesklang['mo']; ?>', '<?php echo $hesklang['tu']; ?>', '<?php echo $hesklang['we']; ?>', '<?php echo $hesklang['th']; ?>', '<?php echo $hesklang['fr']; ?>', '<?php echo $hesklang['sa']; ?>'],
    months: ['<?php echo $hesklang['m1']; ?>','<?php echo $hesklang['m2']; ?>','<?php echo $hesklang['m3']; ?>','<?php echo $hesklang['m4']; ?>','<?php echo $hesklang['m5']; ?>','<?php echo $hesklang['m6']; ?>', '<?php echo $hesklang['m7']; ?>','<?php echo $hesklang['m8']; ?>','<?php echo $hesklang['m9']; ?>','<?php echo $hesklang['m10']; ?>','<?php echo $hesklang['m11']; ?>','<?php echo $hesklang['m12']; ?>'],
    monthsShort: ['<?php echo $hesklang['ms01']; ?>','<?php echo $hesklang['ms02']; ?>','<?php echo $hesklang['ms03']; ?>','<?php echo $hesklang['ms04']; ?>','<?php echo $hesklang['ms05']; ?>','<?php echo $hesklang['ms06']; ?>', '<?php echo $hesklang['ms07']; ?>','<?php echo $hesklang['ms08']; ?>','<?php echo $hesklang['ms09']; ?>','<?php echo $hesklang['ms10']; ?>','<?php echo $hesklang['ms11']; ?>','<?php echo $hesklang['ms12']; ?>'],
    today: '<?php echo hesk_slashJS($hesklang['r1']); ?>',
    clear: '<?php echo hesk_slashJS($hesklang['clear']); ?>',
    dateFormat: '<?php echo hesk_slashJS($hesk_settings['format_datepicker_js']); ?>',
    timeFormat: '<?php echo hesk_slashJS($hesk_settings['format_time']); ?>',
    firstDay: <?php echo $hesklang['first_day_of_week']; ?>
}; })(jQuery);
</script>
<?php
if (defined('RECAPTCHA'))
{
    echo '<script src="https://www.google.com/recaptcha/api.js?hl='.$hesklang['RECAPTCHA'].'" async defer></script>';
    echo '<script type="text/javascript">
        function recaptcha_submitForm() {
            document.getElementById("form1").submit();
        }
        </script>';
}

function hesk_jsString($str)
{
    $str  = addslashes($str);
    $str  = str_replace('<br />' , '' , $str);
    $from = array("/\r\n|\n|\r/", '/\<a href="mailto\:([^"]*)"\>([^\<]*)\<\/a\>/i', '/\<a href="([^"]*)" target="_blank"\>([^\<]*)\<\/a\>/i');
    $to   = array("\\r\\n' + \r\n'", "$1", "$1");
    return preg_replace($from,$to,$str);
} // END hesk_jsString()
?>
<script>
    $(document).ready(function() {
        $('#select_category').selectize();
        hesk_loadNoResultsSelectizePlugin('<?php echo hesk_jsString($hesklang['no_results_found']); ?>');
        <?php

        foreach ($customFieldsBeforeMessage as $customField)
        {
            if ($customField['type'] == 'select')
            {
                if ($customField['value']['is_searchable'] == 1) {
                    echo "$('#{$customField['name']}').addClass('read-write').attr('placeholder', '".$hesklang["search_by_pattern"]."').selectize({
                        delimiter: ',',
                        valueField: 'id',
                        labelField: 'displayName',
                        searchField: ['displayName'],
                        create: false,
                        copyClassesToDropdown: true,
                        plugins: ['no_results'],
                    });";
                } else {
                    echo "$('#{$customField['name']}').selectize();";
                }
            }
        }
        foreach ($customFieldsAfterMessage as $customField)
        {
            if ($customField['type'] == 'select')
            {
                if ($customField['value']['is_searchable'] == 1) {
                    echo "$('#{$customField['name']}').addClass('read-write').attr('placeholder', '".$hesklang["search_by_pattern"]."').selectize({
                        delimiter: ',',
                        valueField: 'id',
                        labelField: 'displayName',
                        searchField: ['displayName'],
                        create: false,
                        copyClassesToDropdown: true,
                        plugins: ['no_results'],
                    });";
                } else {
                    echo "$('#{$customField['name']}').selectize();";
                }
            }
        }
        ?>
    });
</script>
<?php hesk3_output_drag_and_drop_script('c_attachments'); ?>
<?php if (has_public_kb() && $hesk_settings['kb_recommendanswers']): ?>
<script type="text/javascript">
    var noArticlesFoundText = <?php echo json_encode($hesklang['nsfo']); ?>;

    $(document).ready(function() {
        HESK_FUNCTIONS.getKbTicketSuggestions($('input[name="subject"]'),
            $('textarea[name="message"]'),
            function(data) {
                $('.kb-suggestions').show();
                var $suggestionList = $('#kb-suggestion-list');
                var $suggestedArticlesHiddenInputsList = $('#suggested-article-hidden-inputs');
                $suggestionList.html('');
                $suggestedArticlesHiddenInputsList.html('');
                var format = '<a href="knowledgebase.php?article={0}" class="suggest-preview" target="_blank">' +
                    '<span class="icon-in-circle" aria-hidden="true">' +
                    '<svg class="icon icon-knowledge">' +
                    '<use xlink:href="./theme/hesk3/customer/img/sprite.svg#icon-knowledge"></use>' +
                    '</svg>' +
                    '</span>' +
                    '<div class="suggest-preview__text">' +
                    '<p class="suggest-preview__title">{1}</p>' +
                    '<p>{2}</p>' +
                    '</div>' +
                    '</a>';
                var hiddenInputFormat = '<input type="hidden" name="suggested[]" value="{0}">';
                var results = false;
                $.each(data, function() {
                    results = true;
                    $suggestionList.append(format.replace('{0}', this.id).replace('{1}', this.subject).replace('{2}', this.contentPreview));
                    $suggestedArticlesHiddenInputsList.append(hiddenInputFormat.replace('{0}', this.hiddenInputValue));
                });

                if (!results) {
                    $suggestionList.append('<li class="no-articles-found">' + noArticlesFoundText + '</li>');
                }
            }
        );
    });
</script>
<?php endif; ?>
<script src="<?php echo TEMPLATE_PATH; ?>customer/js/app<?php echo $hesk_settings['debug_mode'] ? '' : '.min'; ?>.js?<?php echo $hesk_settings['hesk_version']; ?>"></script>
<script src="<?php echo TEMPLATE_PATH; ?>customer/vendor/aos-master/dist/aos.js"></script>                                           
<script src="<?php echo TEMPLATE_PATH; ?>customer/js/version-01/bootstrap.bundle.min.js"></script>
<script src="<?php echo TEMPLATE_PATH; ?>customer/js/version-01/main.js"></script>
<?php
// Any adjustments to datepicker?
if (isset($hesk_settings['datepicker'])):
    ?>
    <script>
    $(document).ready(function () {
        const myDP = {};
        <?php
        foreach ($hesk_settings['datepicker'] as $selector => $data) {
            echo "
                myDP['{$selector}'] = $('{$selector}').datepicker(".((isset($data['position']) && is_string($data['position'])) ? "{position: '{$data['position']}'}" : "").");
            ";
            if (isset($data['timestamp']) && ($ts = intval($data['timestamp']))) {
                echo "
                    myDP['{$selector}'].data('datepicker').selectDate(new Date({$ts} * 1000));
                ";
            }
        }
        ?>
    });
    </script>
    <?php
endif;
?>

</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
<!-- end document-->