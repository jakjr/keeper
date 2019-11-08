<?php
namespace Jakjr\Keeper;

use Illuminate\Session\SessionInterface;

class Keeper {

    private $context = null;
    private $session;
    
    function __construct($context, SessionInterface $session)
    {
        $this->session = $session;

        if (is_object($context)) {
            $this->context = get_class($context);
        }

        if (is_string($context)) {
            $this->context = $context;
        }

        if (is_null($this->context)) {
            throw new \InvalidArgumentException('Invalid context');
        }
    }

    private function getContext($passedContext=null)
    {
        if (! is_null($passedContext)) {
            return $passedContext;
        }

        if (! is_null($this->context)) {
            return $this->context;
        }

        throw new \InvalidArgumentException('No context defined');
    }

    public function keep(Array $inputs, $context=null)
    {
        $contextToUse = $this->getContext($context);

        foreach($inputs as $key => $value) {
            if (!empty($value) || is_numeric($value)) {
                $this->session->put("keeper.$contextToUse.$key", $value);
            } else {
                $this->forget($key, $context);
            }
        }
    }

    public function get($key, $context=null)
    {
        $contextToUse = $this->getContext($context);

        return $this->session->get("keeper.$contextToUse.$key");
    }

    public function has($key, $context=null)
    {
        $contextToUse = $this->getContext($context);

        return $this->session->has("keeper.$contextToUse.$key");
    }

    public function forget($key, $context=null)
    {
        $contextToUse = $this->getContext($context);

        return $this->session->forget("keeper.$contextToUse.$key");
    }

    public function all($context=null)
    {
        $contextToUse = $this->getContext($context);

        return $this->session->get("keeper.$contextToUse");
    }

}