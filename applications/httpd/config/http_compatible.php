<?php

// Apache/PHP-FPM 传统环境下运行的 HTTP 服务配置（传统模式）
return [

    // 基础路径
    'basePath'            => dirname(__DIR__),

    // 控制器命名空间
    'controllerNamespace' => 'Httpd\Controllers',

    // 中间件命名空间
    'middlewareNamespace' => 'Httpd\Middleware',

    // 全局中间件
    'middleware'          => [],

    // 组件配置
    'components'          => [

        // 路由
        'route'    => [
            // 依赖引用
            'ref' => beanname(Mix\Http\Route::class),
        ],

        // 请求
        'request'  => [
            // 依赖引用
            'ref' => beanname(Mix\Http\Compatible\Request::class),
        ],

        // 响应
        'response' => [
            // 依赖引用
            'ref' => beanname(Mix\Http\Compatible\Response::class),
        ],

        // 错误
        'error'    => [
            // 依赖引用
            'ref' => beanname(Mix\Http\Error::class),
        ],

        // 日志
        'log'      => [
            // 依赖引用
            'ref' => beanname(Mix\Log\Logger::class),
        ],

        // Token
        'token'    => [
            // 依赖引用
            'ref' => beanname(Mix\Http\Token::class),
        ],

        // Session
        'session'  => [
            // 依赖引用
            'ref' => beanname(Mix\Http\Session::class),
        ],

        // 数据库
        'pdo'      => [
            // 依赖引用
            'ref' => beanname(Mix\Database\PDOConnection::class),
        ],

        // redis
        'redis'    => [
            // 依赖引用
            'ref' => beanname(Mix\Redis\RedisConnection::class),
        ],

    ],

    // 依赖配置
    'beans'               => [

        // 路由
        [
            // 类路径
            'class'      => Mix\Http\Route::class,
            // 属性
            'properties' => [
                // 默认变量规则
                'defaultPattern' => '[\w-]+',
                // 路由变量规则
                'patterns'       => [
                    'id' => '\d+',
                ],
                // 路由规则
                'rules'          => [
                    // 一级路由
                    '{controller}/{action}' => ['{controller}', '{action}', 'middleware' => ['Before']],
                ],
            ],
        ],

        // 请求
        [
            // 类路径
            'class' => Mix\Http\Compatible\Request::class,
        ],

        // 响应
        [
            // 类路径
            'class'      => Mix\Http\Compatible\Response::class,
            // 属性
            'properties' => [
                // 默认输出格式
                'defaultFormat' => Mix\Http\Response::FORMAT_HTML,
                // json
                'json'          => [
                    // 依赖引用
                    'ref' => beanname(Mix\Http\Json::class),
                ],
                // jsonp
                'jsonp'         => [
                    // 依赖引用
                    'ref' => beanname(Mix\Http\Jsonp::class),
                ],
                // xml
                'xml'           => [
                    // 依赖引用
                    'ref' => beanname(Mix\Http\Xml::class),
                ],
            ],
        ],

        // json
        [
            // 类路径
            'class' => Mix\Http\Json::class,
        ],

        // jsonp
        [
            // 类路径
            'class'      => Mix\Http\Jsonp::class,
            // 属性
            'properties' => [
                // callback键名
                'name' => 'callback',
            ],
        ],

        // xml
        [
            // 类路径
            'class' => Mix\Http\Xml::class,
        ],

        // 错误
        [
            // 类路径
            'class'      => Mix\Http\Error::class,
            // 属性
            'properties' => [
                // 输出格式
                'format' => Mix\Http\Error::FORMAT_HTML,
                // 错误级别
                'level'  => E_ALL,
            ],
        ],

        // 日志
        [
            // 类路径
            'class'      => Mix\Log\Logger::class,
            // 属性
            'properties' => [
                // 日志记录级别
                'levels'  => ['emergency', 'alert', 'critical', 'error', 'warning', 'notice', 'info', 'debug'],
                // 处理者
                'handler' => [
                    // 依赖引用
                    'ref' => beanname(Mix\Log\FileHandler::class),
                ],
            ],
        ],

        // 日志处理者
        [
            // 类路径
            'class'      => Mix\Log\FileHandler::class,
            // 属性
            'properties' => [
                // 日志目录
                'dir'         => 'logs',
                // 日志轮转类型
                'rotate'      => Mix\Log\FileHandler::ROTATE_DAY,
                // 最大文件尺寸
                'maxFileSize' => 0,
            ],
        ],

        // Token
        [
            // 类路径
            'class'      => Mix\Http\Token::class,
            // 属性
            'properties' => [
                // 处理者
                'handler'   => [
                    // 依赖引用
                    'ref' => 'tokenOrSessionHandler',
                ],
                // Key前缀
                'keyPrefix' => 'TOKEN:',
                // 有效期
                'expiresIn' => 604800,
                // token键名
                'name'      => 'access_token',
            ],
        ],

        // Session
        'session' => [
            // 类路径
            'class'      => Mix\Http\Session::class,
            // 属性
            'properties' => [
                // 处理者
                'handler'        => [
                    // 依赖引用
                    'ref' => 'tokenOrSessionHandler',
                ],
                // Key前缀
                'keyPrefix'      => 'SESSION:',
                // 生存时间
                'maxLifetime'    => 7200,
                // session键名
                'name'           => 'session_id',
                // 过期时间
                'cookieExpires'  => 0,
                // 有效的服务器路径
                'cookiePath'     => '/',
                // 有效域名/子域名
                'cookieDomain'   => '',
                // 仅通过安全的 HTTPS 连接传给客户端
                'cookieSecure'   => false,
                // 仅可通过 HTTP 协议访问
                'cookieHttpOnly' => false,
            ],
        ],

        // Token|session处理者
        [
            // 依赖名称
            'name'       => 'tokenOrSessionHandler',
            // 类路径
            'class'      => Mix\Redis\RedisConnection::class,
            // 属性
            'properties' => [
                // 主机
                'host'     => env('REDIS.HOST'),
                // 端口
                'port'     => env('REDIS.PORT'),
                // 数据库
                'database' => env('REDIS.DATABASE'),
                // 密码
                'password' => env('REDIS.PASSWORD'),
            ],
        ],

        // 数据库
        [
            // 类路径
            'class'      => Mix\Database\PDOConnection::class,
            // 属性
            'properties' => [
                // 数据源格式
                'dsn'           => env('DATABASE.DSN'),
                // 数据库用户名
                'username'      => env('DATABASE.USERNAME'),
                // 数据库密码
                'password'      => env('DATABASE.PASSWORD'),
                // 驱动连接选项: http://php.net/manual/zh/pdo.setattribute.php
                'driverOptions' => [
                    // 设置默认的提取模式: \PDO::FETCH_OBJ | \PDO::FETCH_ASSOC
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                ],
            ],
        ],

        // redis
        [
            // 类路径
            'class'      => Mix\Redis\RedisConnection::class,
            // 属性
            'properties' => [
                // 主机
                'host'     => env('REDIS.HOST'),
                // 端口
                'port'     => env('REDIS.PORT'),
                // 数据库
                'database' => env('REDIS.DATABASE'),
                // 密码
                'password' => env('REDIS.PASSWORD'),
            ],
        ],

    ],

];
