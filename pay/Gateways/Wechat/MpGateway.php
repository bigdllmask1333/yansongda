<?php

namespace yansongda\pay\Gateways\Wechat;

use yansongda\pay\Log;
use yansongda\supports\Collection;
use yansongda\supports\Str;

class MpGateway extends Gateway
{
    /**
     * Pay an order.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string $endpoint
     * @param array  $payload
     *
     * @throws \yansongda\pay\Exceptions\GatewayException
     * @throws \yansongda\pay\Exceptions\InvalidArgumentException
     * @throws \yansongda\pay\Exceptions\InvalidSignException
     * @throws \Exception
     *
     * @return Collection
     */
    public function pay($endpoint, array $payload): Collection
    {
        $payload['trade_type'] = $this->getTradeType();

        $pay_request = [
            'appId'     => $payload['appid'],
            'timeStamp' => strval(time()),
            'nonceStr'  => Str::random(),
            'package'   => 'prepay_id='.$this->preOrder($payload)->prepay_id,
            'signType'  => 'MD5',
        ];
        $pay_request['paySign'] = Support::generateSign($pay_request);

        Log::info('Starting To Pay A Wechat JSAPI Order', [$endpoint, $pay_request]);

        return new Collection($pay_request);
    }

    /**
     * Get trade type config.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @return string
     */
    protected function getTradeType(): string
    {
        return 'JSAPI';
    }
}
