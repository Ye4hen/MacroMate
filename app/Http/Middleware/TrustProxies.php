<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     * Use '*' if you trust the platform (Render/Heroku) that terminates TLS.
     *
     * @var array<int, string>|string|null
     */
    protected $proxies = '*';

    /**
      * The headers to use to detect proxies.
      *
      * We'll initialise this in the constructor to be robust across versions.
      *
       * @var int
      */
    protected $headers;

    public function __construct()
    {
        $rc = Request::class . '::';

        if (defined($rc . 'HEADER_X_FORWARDED_ALL')) {
            $this->headers = constant($rc . 'HEADER_X_FORWARDED_ALL');
        } else {
            $mask = 0;

            foreach ([
                'HEADER_X_FORWARDED_FOR',
                'HEADER_X_FORWARDED_HOST',
                'HEADER_X_FORWARDED_PORT',
                'HEADER_X_FORWARDED_PROTO',
            ] as $const) {
                $fq = $rc . $const;

                if (defined($fq)) {
                    $mask |= constant($fq);
                }
            }

            if ($mask === 0 && defined($rc . 'HEADER_X_FORWARDED_FOR')) {
                $mask = constant($rc . 'HEADER_X_FORWARDED_FOR');
            }

            $this->headers = $mask;
        }

        if (method_exists(parent::class, '__construct')) {
            parent::__construct();
        }
    }
}
