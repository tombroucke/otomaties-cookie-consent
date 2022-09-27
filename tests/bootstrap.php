<?php

$scripts = [];
$styles = [];
$filters = [];
$actions = [];
$consentMode = false;
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
                'expiration' => 'Session',
                'description' => 'WordPress test cookie',
                'regex' => false,
            ],
            [
                'name' => 'wordpress_logged_in',
                'domain' => 'example.com',
                'expiration' => 'Session',
                'description' => 'WordPress logged in cookie',
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
    return 'http://example.com/privacy-policy';
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

