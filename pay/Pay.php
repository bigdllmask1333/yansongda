<?php

namespace yansongda\pay;

use yansongda\pay\Contracts\GatewayApplicationInterface;
use yansongda\pay\Exceptions\InvalidGatewayException;
use yansongda\pay\Gateways\Alipay;
use yansongda\pay\Gateways\Wechat;
use yansongda\supports\Config;
use yansongda\supports\Log;
use yansongda\supports\Str;

/**
 * @method static Alipay alipay(array $config) 支付宝
 * @method static Wechat wechat(array $config) 微信
 */
class Pay
{
    /**
     * Config.
     *
     * @var Config
     */
    protected $config;


    public function test(){
        return 123;
    }

    /**
     * Bootstrap.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = new Config($config);
    }

    /**
     * Magic static call.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string $method
     * @param array  $params
     *
     * @throws InvalidGatewayException
     *
     * @return GatewayApplicationInterface
     */
    public static function __callStatic($method, $params):GatewayApplicationInterface
    {
        $app = new self(...$params);

        return $app->create($method);
    }

    /**
     * Create a instance.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string $method
     *
     * @throws InvalidGatewayException
     * @throws \Exception
     *
     * @return GatewayApplicationInterface
     */
    protected function create($method): GatewayApplicationInterface
    {
        !$this->config->has('log.file') ?: $this->registerLog();

        $gateway = __NAMESPACE__.'\\Gateways\\'.Str::studly($method);

        if (class_exists($gateway)) {
            return self::make($gateway);
        }

        throw new InvalidGatewayException("Gateway [{$method}] Not Exists");
    }

    /**
     * Make a gateway.
     *
     * @author yansongda <me@yansonga.cn>
     *
     * @param string $gateway
     *
     * @throws InvalidGatewayException
     *
     * @return GatewayApplicationInterface
     */
    protected function make($gateway): GatewayApplicationInterface
    {
        $app = new $gateway($this->config);

        if ($app instanceof GatewayApplicationInterface) {
            return $app;
        }

        throw new InvalidGatewayException("Gateway [{$gateway}] Must Be An Instance Of GatewayApplicationInterface");
    }

    /**
     * Register log service.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @throws \Exception
     */
    protected function registerLog()
    {
        $logger = Log::createLogger(
            $this->config->get('log.file'),
            'yansongda.pay',
            $this->config->get('log.level', 'warning'),
            $this->config->get('log.type', 'daily'),
            $this->config->get('log.max_file', 30)
        );

        Log::setLogger($logger);
    }
}
