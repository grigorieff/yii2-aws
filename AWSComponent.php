<?php

/**
 * @author Mike Grigorieff <grigorief@gmail.com>
 * @link http://mikegrigorieff.ru
 */

namespace grigorieff\aws;

use yii\base\Component;
use Aws\Common\Aws;
use yii\base\InvalidConfigException;

class AWSComponent extends Component
{
    /**
     * @var
     */
    public $key;
    public $secret;
    public $region;

    private $_config;
    private $_aws = null;

    /**
     * Init Component
     */
    public function init()
    {
        if (!$this->key) {
            throw new InvalidConfigException("Key can't be empty!");
        }
        if (!$this->secret) {
            throw new InvalidConfigException("Secret can't be empty!");
        }
        if (!$this->region) {
            throw new InvalidConfigException("Region can't be empty!");
        }
        $this->_config = [
            'key' => $this->key,
            'secret' => $this->secret,
            'region' => $this->region
        ];
    }

    public function getAws()
    {
        if ($this->_aws === null) {
            $this->_aws = Aws::factory($this->_config);
        }
        return $this->_aws;
    }

    public function __call($method, $params)
    {
        $client = $this->getAws();
        if (method_exists($client, $method))
            return call_user_func_array(array($client, $method), $params);
        return parent::__call($method, $params);
    }

}