<?php

namespace Tymon\JWTAuth\Exceptions {
    /**
     * Minimal JWT exception stub for static analysis.
     */
    class JWTException extends \RuntimeException
    {
    }
}

namespace Tymon\JWTAuth {
    /**
     * Minimal token stub.
     */
    class Token
    {
        // token marker
    }

    /**
     * Minimal factory stub (so ->getTTL() is known).
     */
    class JWTFactory
    {
        /**
         * Return token TTL in minutes.
         *
         * @return int
         */
        public function getTTL(): int
        {
            return 0;
        }
    }

    /**
     * Minimal manager stub (invalidate, authenticate etc).
     */
    class JWTManager
    {
        /**
         * @throws \Tymon\JWTAuth\Exceptions\JWTException
         */
        public function invalidate(): void
        {
            // stubbed
        }

        /**
         * Authenticate token / user (used in your controllers).
         *
         * @throws \Tymon\JWTAuth\Exceptions\JWTException
         */
        public function authenticate(): mixed
        {
            return null;
        }

        /**
         * @throws \Tymon\JWTAuth\Exceptions\JWTException
         */
        public function getTTL(): int
        {
            return 0;
        }
    }
}

namespace Tymon\JWTAuth\Facades {
    use Tymon\JWTAuth\Exceptions\JWTException;
    use Tymon\JWTAuth\JWTFactory;
    use Tymon\JWTAuth\JWTManager;
    use Tymon\JWTAuth\Token;

    /**
     * Facade stub. Provide concrete static methods with @throws so PHPStan
     * understands that these calls may throw and what they return.
     */
    class JWTAuth
    {
        /**
         * Create token for a user.
         *
         * @param  object       $user
         * @throws JWTException
         * @return string
         */
        public static function fromUser(object $user): string
        {
            return '';
        }

        /**
         * Attempt login and return token (or false).
         *
         * @param  array<string,mixed> $credentials
         * @throws JWTException
         * @return false|string
         */
        public static function attempt(array $credentials)
        {
            return false;
        }

        /**
         * Get factory wrapper (->getTTL()).
         *
         * @return JWTFactory
         */
        public static function factory(): JWTFactory
        {
            return new JWTFactory();
        }

        /**
         * Get current token if any.
         *
         * @return Token|null
         */
        public static function getToken(): ?Token
        {
            return null;
        }

        /**
         * Set a token and return a manager for fluent operations.
         *
         * @param  mixed      $token
         * @return JWTManager
         */
        public static function setToken(mixed $token): JWTManager
        {
            return new JWTManager();
        }

        /**
         * Parse token and return a manager.
         *
         * @return JWTManager
         */
        public static function parseToken(): JWTManager
        {
            return new JWTManager();
        }

        /**
         * Magic fallback (keeps PHPStan quiet if other calls are used).
         *
         * @param  string $name
         * @param  array<mixed>  $args
         * @return mixed
         */
        public static function __callStatic(string $name, array $args)
        {
            return null;
        }
    }
}
