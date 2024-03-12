<?php

namespace Otomaties\CookieConsent;

use Otomaties\CookieConsent\Database\RecordsOfConsent;

class RestApi
{
    public function registerRoutes() {
        register_rest_route('otomaties-cookie-consent/v1', 'track/', [
            'methods'  => 'POST',
            'callback' => [$this, 'track'],
            'args' => [],
            'permission_callback' => '__return_true',
        ]);
    }

    public function track(\WP_REST_Request $request) {
        $params = $request->get_json_params();
        $userAgent = $request->get_header('User-Agent');
        $remoteAddress = preg_replace(
            ['/\.\d*$/', '/[\da-f]*:[\da-f]*$/'],
            ['.XXX', 'XXXX:XXXX'],
            $_SERVER['REMOTE_ADDR'] ?? ''
        );
        $forwardedFor = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? '';
        $requiredParams = ['initial', 'version', 'consent'];
        foreach ($requiredParams as $param) {
            if (!isset($params[$param])) {
                wp_send_json(['success' => false, 'message' => 'Missing required parameter: ' . $param], 400);
                wp_die();
            }
        }

        $consentParams = ['acceptType', 'acceptedCategories', 'rejectedCategories', 'acceptedServices', 'rejectedServices'];
        foreach ($consentParams as $param) {
            if (!isset($params['consent'][$param])) {
                wp_send_json(['success' => false, 'message' => 'Missing required parameter: consent' . $param], 400);
                wp_die();
            }
        }

        (new RecordsOfConsent)->insert([
            'initial' => (int)$params['initial'],
            'ccVersion' => (int)$params['version'],
            'userAgent' => sanitize_text_field($userAgent),
            'remoteAddress' => sanitize_text_field($remoteAddress),
            'forwardedFor' => sanitize_text_field($forwardedFor),
            'acceptType' => sanitize_text_field($params['consent']['acceptType']),
            'acceptedCategories' => sanitize_text_field($this->toDotNotation($params['consent']['acceptedCategories']) ?? ''),
            'rejectedCategories' => sanitize_text_field($this->toDotNotation($params['consent']['rejectedCategories']) ?? ''),
            'acceptedServices' => sanitize_text_field($this->toDotNotation($params['consent']['acceptedServices']) ?? ''),
            'rejectedServices' => sanitize_text_field($this->toDotNotation($params['consent']['rejectedServices']) ?? ''),
        ]);
        wp_send_json(['success' => true]);
        wp_die();
    }

    public function toDotNotation(array $array, string $key = null) : string
    {
        $return = '';
        foreach ($array as $k => $v) {
            if ($key && is_numeric($k)) {
                $k = $key . '.' . $k;
            } elseif (is_numeric($k)) {
                $k = '';
            }

            if (is_array($v)) {
                $return .= $this->toDotNotation($v, $k);
            } else {
                $return .= ($k ? $k . '.' : '') . $v . ',';
            }
        }
        return rtrim($return, ',');
    }
}


