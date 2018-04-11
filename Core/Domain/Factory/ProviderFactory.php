<?php
/**
 * Created by PhpStorm.
 * User: il_kow
 * Date: 4/11/18
 * Time: 2:13 PM
 */

namespace Core\Domain\Factory;


use Core\Domain\Models\ProviderType\SmskaProvider;
use Core\Domain\Models\ProviderType\SmsRuProvider;
use Illuminate\Support\Collection;

class ProviderFactory
{
    public $providersCollection = array();
    private $channelType;

    /**
     * ChannelTypeFactory constructor.
     */
    public function __construct(Collection $providersCollection,
                                SmsRuProvider $smsRuProvider,
                                SmskaProvider $smskaProvider
                                )
    {
        $providersCollection = collect([$smsRuProvider, $smskaProvider]);

        $this->providersCollection = $providersCollection;
    }

    /**
     * @param $type
     * @return static
     * Выбрать провайдеров для определенного канала
     */
    public function getProvidersForThisChannel($type)
    {
        $this->channelType = $type;

        return $this->providersCollection->reject(function ($value, $key) {
            return $value->channelType != $this->channelType;
        });

    }
}