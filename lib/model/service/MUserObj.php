<?php

class MUserObj
{
    const SESSION_MUSEROBJ = "session_muserobj";

    protected $values = array();

    function __set($name, $value)
    {
        $this->values[$name] = $value;
    }

    function __get($name)
    {
        return $this->values[$name];
    }

    function saveToSession($action)
    {
        if (!$this->isEmpty()) {
            $action->getUser()->setAttribute(MUserObj::SESSION_MUSEROBJ, serialize($this->values));
        }
    }

    function loadFromSession($action, $clearFromSession = true)
    {
        $val = $action->getUser()->getAttribute(MUserObj::SESSION_MUSEROBJ);

        if ($val !== null) {
            $this->values = unserialize($val);

            if ($clearFromSession) {
                $action->getUser()->setAttribute(MUserObj::SESSION_MUSEROBJ, null);
            }
        }
    }

    function isEmpty()
    {
        return count($this->values) < 1;
    }
}