<?php

// Console应用配置
return [

    // 应用名称
    'appName'          => 'mix-daemon',

    // 应用版本
    'appVersion'       => '0.0.0',

    // 初始化回调
    'initialize'       => [],

    // 基础路径
    'basePath'         => dirname(__DIR__),

    // 命令命名空间
    'commandNamespace' => 'Daemon\Commands',

    // 命令
    'commands'         => [

        'cop' => ['CoroutinePool', 'description' => 'Coroutine pool daemon demo.'],

    ],

    // 组件配置
    'components'       => [

        // 错误
        'error'     => [
            // 依赖引用
            'ref' => beanname(Mix\Console\Error::class),
        ],

        // 日志
        'log'       => [
            // 依赖引用
            'ref' => beanname(Mix\Log\Logger::class),
        ],

        // 连接池
        'pdoPool'   => [
            // 依赖引用
            'ref' => beanname(Mix\Database\Pool\ConnectionPool::class),
        ],

        // 连接池
        'redisPool' => [
            // 依赖引用
            'ref' => beanname(Mix\Redis\Pool\ConnectionPool::class),
        ],

    ],

    // 依赖配置
    'beans'            => [

        // 错误
        [
            // 类路径
            'class'      => Mix\Console\Error::class,
            // 属性
            'properties' => [
                // 错误级别
                'level' => E_ALL,
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

        // 连接池
        [
            // 类路径
            'class'      => Mix\Database\Pool\ConnectionPool::class,
            // 属性
            'properties' => [
                // 最多可空闲连接数
                'maxIdle'   => 5,
                // 最大连接数
                'maxActive' => 50,
                // 拨号
                'dial'      => [
                    // 依赖引用
                    'ref' => beanname(Mix\Database\Pool\Dial::class),
                ],
            ],
        ],

        // 连接池拨号
        [
            // 类路径
            'class' => Mix\Database\Pool\Dial::class,
        ],

        // 连接池
        [
            // 类路径
            'class'      => Mix\Redis\Pool\ConnectionPool::class,
            // 属性
            'properties' => [
                // 最多可空闲连接数
                'maxIdle'   => 5,
                // 最大连接数
                'maxActive' => 50,
                // 拨号
                'dial'      => [
                    // 依赖引用
                    'ref' => beanname(Mix\Redis\Pool\Dial::class),
                ],
            ],
        ],

        // 连接池拨号
        [
            // 类路径
            'class' => Mix\Redis\Pool\Dial::class,
        ],

        // 数据库
        [
            // 类路径
            'class'      => Mix\Database\Coroutine\PDOConnection::class,
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
            'class'      => Mix\Redis\Coroutine\RedisConnection::class,
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
            'class'      => Mix\Database\Persistent\PDOConnection::class,
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
            'class'      => Mix\Redis\Persistent\RedisConnection::class,
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
