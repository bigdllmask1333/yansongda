<?php

namespace yansongda\pay\Gateways\Wechat;

use yansongda\pay\Gateways\Wechat;
use yansongda\supports\Collection;

class MiniappGateway extends MpGateway
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
     *
     * @return Collection
     */
    public function pay($endpoint, array $payload): Collection
    {
        $payload['appid'] = Support::getInstance()->miniapp_id;

        if ($this->mode !== Wechat::MODE_SERVICE) {
            $payload['sub_appid'] = Support::getInstance()->sub_miniapp_id;
        }

        return parent::pay($endpoint, $payload);
    }
}
