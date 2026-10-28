<?php

namespace Otomaties\CookieConsent;

use Otomaties\CookieConsent\Database\RecordsOfConsent;

class RestApi
{
    public function registerRoutes()
    {
        register_rest_route('otomaties-cookie-consent/v1', 'track/', [
            'methods' => 'POST',
            'callback' => [$this, 'track'],
            'args' => [],
            'permission_callback' => '__return_true',
        ]);

        register_rest_route('otomaties-cookie-consent/v1', 'cookies', [
            [
                'methods' => \WP_REST_Server::READABLE,
                'callback' => [$this, 'listCookies'],
                'permission_callback' => [$this, 'canManageCookies'],
                'args' => [
                    'category' => [
                        'type' => 'string',
                        'enum' => array_keys(Settings::categories()),
                    ],
                ],
            ],
            [
                'methods' => \WP_REST_Server::CREATABLE,
                'callback' => [$this, 'createCookie'],
                'permission_callback' => [$this, 'canManageCookies'],
                'args' => $this->cookieArgs(true),
            ],
        ]);

        register_rest_route('otomaties-cookie-consent/v1', 'cookies/(?P<name>[^/]+)', [
            [
                'methods' => \WP_REST_Server::READABLE,
                'callback' => [$this, 'getCookie'],
                'permission_callback' => [$this, 'canManageCookies'],
            ],
            [
                'methods' => \WP_REST_Server::EDITABLE,
                'callback' => [$this, 'updateCookie'],
                'permission_callback' => [$this, 'canManageCookies'],
                'args' => $this->cookieArgs(false),
            ],
            [
                'methods' => \WP_REST_Server::DELETABLE,
                'callback' => [$this, 'deleteCookie'],
                'permission_callback' => [$this, 'canManageCookies'],
            ],
        ]);
    }

    public function canManageCookies(): bool
    {
        return current_user_can(apply_filters('otomaties_cookie_consent_settings_capability', 'manage_options'));
    }

    private function cookieArgs(bool $creating): array
    {
        $textArg = [
            'type' => 'string',
            'validate_callback' => 'rest_validate_request_arg',
            'sanitize_callback' => 'sanitize_text_field',
        ];

        return [
            'category' => [
                'type' => 'string',
                'enum' => array_keys(Settings::categories()),
                'required' => $creating,
            ],
            'name' => $textArg + ['minLength' => 1, 'required' => $creating],
            'domain' => $textArg,
            'expiration' => $textArg,
            'description' => $textArg,
            'regex' => [
                'type' => 'boolean',
            ],
        ];
    }

    public function listCookies(\WP_REST_Request $request): \WP_REST_Response
    {
        return new \WP_REST_Response((new CookieTable)->all($request->get_param('category')));
    }

    public function getCookie(\WP_REST_Request $request): \WP_REST_Response|\WP_Error
    {
        $cookie = (new CookieTable)->find($request->get_url_params()['name']);
        if (! $cookie) {
            return new \WP_Error(
                'occ_cookie_not_found',
                __('Cookie not found.', 'otomaties-cookie-consent'),
                ['status' => 404]
            );
        }

        return new \WP_REST_Response($cookie);
    }

    public function createCookie(\WP_REST_Request $request): \WP_REST_Response|\WP_Error
    {
        $cookie = (new CookieTable)->create($this->cookieParams($request));
        if (is_wp_error($cookie)) {
            return $cookie;
        }

        return new \WP_REST_Response($cookie, 201);
    }

    public function updateCookie(\WP_REST_Request $request): \WP_REST_Response|\WP_Error
    {
        // A "name" in the body renames the cookie, the route's name identifies it
        $cookie = (new CookieTable)->update($request->get_url_params()['name'], $this->cookieParams($request));
        if (is_wp_error($cookie)) {
            return $cookie;
        }

        return new \WP_REST_Response($cookie);
    }

    public function deleteCookie(\WP_REST_Request $request): \WP_REST_Response|\WP_Error
    {
        $cookie = (new CookieTable)->delete($request->get_url_params()['name']);
        if (is_wp_error($cookie)) {
            return $cookie;
        }

        return new \WP_REST_Response(['deleted' => true, 'previous' => $cookie]);
    }

    private function cookieParams(\WP_REST_Request $request): array
    {
        $params = [];
        foreach ([...CookieTable::FIELDS, 'category'] as $field) {
            if ($request->has_param($field)) {
                $params[$field] = $request->get_param($field);
            }
        }

        return $params;
    }

    public function track(\WP_REST_Request $request)
    {
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
            if (! isset($params[$param])) {
                wp_send_json(['success' => false, 'message' => 'Missing required parameter: '.$param], 400);
                wp_die();
            }
        }

        $consentParams = ['acceptType', 'acceptedCategories', 'rejectedCategories', 'acceptedServices', 'rejectedServices'];
        foreach ($consentParams as $param) {
            if (! isset($params['consent'][$param])) {
                wp_send_json(['success' => false, 'message' => 'Missing required parameter: consent'.$param], 400);
                wp_die();
            }
        }

        (new RecordsOfConsent)->insert([
            'initial' => (int) $params['initial'],
            'ccVersion' => (int) $params['version'],
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

    public function toDotNotation(array $array, ?string $key = null): string
    {
        $return = '';
        foreach ($array as $k => $v) {
            if ($key && is_numeric($k)) {
                $k = $key.'.'.$k;
            } elseif (is_numeric($k)) {
                $k = '';
            }

            if (is_array($v)) {
                $return .= $this->toDotNotation($v, $k);
            } else {
                $return .= ($k ? $k.'.' : '').$v.',';
            }
        }

        return rtrim($return, ',');
    }
}
