<?php

namespace Config;

use App\Filters\AuthFilter;
use CodeIgniter\Config\Filters as BaseFilters;
use CodeIgniter\Filters\Cors;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\ForceHTTPS;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\PageCache;
use CodeIgniter\Filters\PerformanceMetrics;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseFilters
{
    /**
     * Aliases used when assigning filters to routes.
     *
     * @var array<string, class-string|list<class-string>>
     */
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'cors'          => Cors::class,
        'forcehttps'    => ForceHTTPS::class,
        'pagecache'     => PageCache::class,
        'performance'   => PerformanceMetrics::class,

        // TFA4 authentication filter
        'auth'          => AuthFilter::class,
    ];

    /**
     * Required framework filters.
     *
     * @var array{before: list<string>, after: list<string>}
     */
    public array $required = [
        'before' => [
            'forcehttps',
            'pagecache',
        ],
        'after' => [
            'pagecache',
            'performance',
            'toolbar',
        ],
    ];

    /**
     * Filters applied globally.
     *
     * @var array{
     *     before: array<string, array{
     *         except: list<string>|string
     *     }>|list<string>,
     *     after: array<string, array{
     *         except: list<string>|string
     *     }>|list<string>
     * }
     */
    public array $globals = [
        'before' => [
            // Protect all POST forms against cross-site
            // request forgery.
            'csrf',
        ],
        'after' => [
            // 'honeypot',
            // 'secureheaders',
        ],
    ];

    /**
     * Filters assigned according to HTTP method.
     *
     * @var array<string, list<string>>
     */
    public array $methods = [];

    /**
     * Filters assigned to URI patterns.
     *
     * The auth filter is assigned through Routes.php,
     * so no entries are needed here.
     *
     * @var array<string, array<string, list<string>>>
     */
    public array $filters = [];
}