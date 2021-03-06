<?php

namespace Elao\TinyMceBundle;

use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Configuration class for tinymce mediamanager
 */
class Configuration
{
    protected $context;

    protected $isLogin = false;

    protected $userKey;

    protected $configs;

    protected $role;

    protected $secretKey;

    /**
     * __construct
     *
     * @param SecurityContextInterface $context  context
     * @param boolean                  $isLogin  is login ?
     * @param string                   $role     role
     * @param array                    $configs  configs
     *
     * @return void
     */
    public function __construct(SecurityContextInterface $context, $isLogin, $role, $secretKey, array $configs = array())
    {
        $this->context = $context;

        $this->isLogin = $isLogin;
        $this->configs = $configs;
        $this->role = $role;
        $this->secretKey = $secretKey;

        if ($isLogin == false && $role != '') {
            $this->isLogin = $this->context->isGranted($role);
        }
    }

    /**
     * init
     *
     * @return void
     */
    public function init()
    {
        $this->userKey = (string) $this->context->getToken()->getUser()->getUsername();
    }

    /**
     * Get isLogin
     *
     * @return boolean
     */
    public function getIsLogin()
    {
        return $this->isLogin;
    }

    /**
     * Get UserKey
     *
     * @return string
     */
    public function getUserKey()
    {
        return $this->userKey;
    }

    public function getSecretKey()
    {
        return $this->secretKey;
    }

    /**
     * Get configs
     *
     * @return array
     */
    public function getConfigs()
    {
        return $this->configs;
    }

    /**
     * Set config
     *
     * @param string $key   key
     * @param string $value value
     *
     * @return void
     */
    public function setConfig($key, $value)
    {
        $this->configs[$key] = $value;
    }

    /**
     * Get config
     *
     * @param string      $key     key
     * @param string|null $default default value
     *
     * @return string|null
     */
    public function getConfig($key, $default = null)
    {
        if (isset($this->configs[$key])) {
            return $this->configs[$key];
        } else {
            return $default;
        }
    }
}