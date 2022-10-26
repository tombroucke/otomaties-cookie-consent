<?php

$scripts = [];
$styles = [];
$filters = [];
$actions = [];
$posts = [
    69 => [
        'post_title' => 'Contact',
        'post_name' => 'contact',
        'post_type' => 'page',
        'post_status' => 'publish',
        'post_content' => 'This is the Contact page. You can edit this page in the WordPress admin.',
        'post_author' => 1,
        'post_date' => '2019-01-01 00:00:00',
        'post_date_gmt' => '2019-01-01 00:00:00',
        'post_modified' => '2019-01-01 00:00:00',
        'post_modified_gmt' => '2019-01-01 00:00:00',
        'post_parent' => 0,
        'post_excerpt' => '',
        'post_content_filtered' => '',
        'post_mime_type' => '',
        'guid' => 'http://example.com/contact',
        'menu_order' => 0,
        'pinged' => '',
        'to_ping' => '',
        'ping_status' => 'closed',
        'comment_status' => 'closed',
        'post_password' => '',
        'post_category' => [],
        'tags_input' => [],
        'tax_input' => [],
        'page_template' => '',
        'meta_input' => [],
    ],
];
$consentMode = false;
$privacyPolicyUrl = 'http://example.com/privacy-policy';
define('GTM4WP_OPTION_LOADEARLY', false);

function wp_enqueue_script(string $handle, string $src, array $deps = [], string $ver = null, bool $in_footer = false) : void 
{
    global $scripts;
    $scripts[$handle] = [
        'src' => $src,
        'deps' => $deps,
        'ver' => $ver,
        'in_footer' => $in_footer,
    ];
}

function wp_enqueue_style(string $handle, string $src, array $deps = [], string $ver = null, string $media = 'all') : void 
{
    global $styles;
    $styles[$handle] = [
        'src' => $src,
        'deps' => $deps,
        'ver' => $ver,
        'media' => $media,
    ];
}

function plugins_url(string $path, string $plugin) : string
{
    return 'http://example.com/wp-content/plugins/otomaties-cookie-consent/' . $path;
}

function wp_script_is(string $handle, string $list = 'enqueued') : bool
{
    global $scripts;
    if ($list == 'localized') {
        return isset($scripts[$handle]) && isset($scripts[$handle]['localized']) && $scripts[$handle]['localized'];
    }
    return isset($scripts[$handle]);
}

function wp_style_is(string $handle, string $list = 'enqueued') : bool
{
    global $styles;
    return isset($styles[$handle]);
}

function get_field(string $field, string $option)
{
    if ($field == 'occ_necessary_cookie_table') {
        return [
            [
                'name' => 'wordpress_test_cookie',
                'domain' => 'example.com',
                'description' => 'WordPress test cookie',
                'expiration' => 'Session',
                'regex' => false,
            ],
            [
                'name' => 'wordpress_logged_in',
                'domain' => 'example.com',
                'description' => 'WordPress logged in cookie',
                'expiration' => 'Session',
                'regex' => true,
            ]
        ];
    }
    if ($field == 'occ_necessary_title') {
        return 'Strictly necessary cookies';
    }
    if ($field == 'occ_necessary_description') {
        return 'Necessary description';
    }
    if ($field == 'occ_necessary_block_scripts') {
        return [
            [
                'script_id' => 'please-add-category',
            ]
        ];
    }
    if ($field == 'occ_consent_modal_trigger_in_menu') {
        return 'term_id_' . 69;
    }
    if ($field == 'occ_consent_modal_title') {
        return 'Consent modal title';
    }
    if ($field == 'occ_consent_modal_description') {
        return 'Consent modal description';
    }
    if ($field == 'occ_consent_modal_accept_button_label') {
        return 'Accept';
    }
    if ($field == 'occ_consent_modal_reject_button_label') {
        return 'Reject';
    }
    if ($field == 'occ_settings_modal_title') {
        return 'Settings modal title';
    }
    if ($field == 'occ_settings_modal_save_settings_button_label') {
        return 'Save settings';
    }
    if ($field == 'occ_settings_modal_accept_all_button_label') {
        return 'Accept all';
    }
    if ($field == 'occ_settings_modal_reject_all_button_label') {
        return 'Reject all';
    }
    if ($field == 'occ_settings_modal_close_button_label') {
        return 'Close';
    }
    if ($field == 'occ_settings_modal_cookie_usage_title') {
        return 'Usage title';
    }
    if ($field == 'occ_settings_modal_cookie_usage_description') {
        return 'Usage description';
    }
    if ($field == 'occ_settings_modal_contact_page') {
        return 69;
    }

    if ($field == 'occ_gtm_consent_mode' && $option == 'option') {
        global $consentMode;
        return $consentMode;
    }

    return false;
}

function __(string $text, string $domain) : string
{
    return $text;
}

function get_permalink() : string
{
    return 'http://example.com';
}

function get_post_status(int $id) : ?string
{
    global $posts;
    if (!array_key_exists($id, $posts)) {
        return false;
    }
    return $posts[$id]['post_status'];
}

function wp_localize_script(string $handle, string $name, array $data) : void
{
    global $scripts;
    $scripts[$handle]['localized'] = true;
}

function get_locale() {
    return 'en_US';
}

function add_filter(string $tag, $function_to_add, int $priority = 10, int $accepted_args = 1) : bool
{
    global $filters;
    $filters[$tag][] = [
        'function' => $function_to_add,
        'priority' => $priority,
        'accepted_args' => $accepted_args,
    ];
    return true;
}

function remove_filter(string $tag, string $function_to_remove, int $priority = 10) : bool
{
    global $filters;
    if (!isset($filters[$tag])) {
        return false;
    }
    foreach ($filters[$tag] as $key => $filter) {
        if ($filter['function'] == $function_to_remove && $filter['priority'] == $priority) {
            unset($filters[$tag][$key]);
            return true;
        }
    }
    return false;
}

function add_action(string $tag, $function_to_add, int $priority = 10, int $accepted_args = 1) : bool
{
    global $actions;
    $actions[$tag][] = [
        'function' => $function_to_add,
        'priority' => $priority,
        'accepted_args' => $accepted_args,
    ];
    return true;
}

function has_action(string $tag, string $function_to_check = null) : bool
{
    global $actions;
    print_r($actions);
    if (!isset($actions[$tag])) {
        return false;
    }
    if ($function_to_check === null) {
        return true;
    }
    foreach ($actions[$tag] as $action) {
        if ($action['function'] == $function_to_check) {
            return true;
        }
    }
    return false;
}

function remove_action(string $tag, string $function_to_remove, int $priority = 10) : bool
{
    global $actions;
    if (!isset($actions[$tag])) {
        return false;
    }
    foreach ($actions[$tag] as $key => $action) {
        if ($action['function'] == $function_to_remove && $action['priority'] == $priority) {
            unset($actions[$tag][$key]);
            return true;
        }
    }
    return false;
}

function get_privacy_policy_url() : string
{
    global $privacyPolicyUrl;
    return $privacyPolicyUrl;
}

function apply_filters(string $tag, $value)
{
    global $filters;
    if (!isset($filters[$tag])) {
        return $value;
    }
    foreach ($filters[$tag] as $filter) {
        $value = call_user_func($filter['function'], $value);
    }
    return $value;
}

function gtm4wp_wp_header_begin($echo = true)
{
    ?>
    <!-- Google Tag Manager for WordPress by gtm4wp.com -->
    <!-- GTM Container placement set to automatic -->
    <script type="text/plain" data-cookiecategory="analytics" data-cfasync="false" data-pagespeed-no-defer type="text/javascript">
        var dataLayer_content = {"pagePostType":"frontpage","pagePostType2":"single-page","pagePostAuthor":"tom"};
        dataLayer.push( dataLayer_content );
    </script>
    <script type="text/plain" data-cookiecategory="analytics" data-cfasync="false">
    (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    '//www.googletagmanager.com/gtm.'+'js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-XXXXXXX');
    </script>
    <!-- End Google Tag Manager -->
    <!-- End Google Tag Manager for WordPress by gtm4wp.com -->
    <?php
}

