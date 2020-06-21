<?php

namespace App\Helpers;

class ValidationForm
{
    private $field;
    private $value;
    private $label;
    private $error;

    public function __construct()
    {
        $this->error = null;
    }

    public function setField(string $field, string $label)
    {
        $this->field = $field;
        $this->value[$this->field] = $_POST[$field];
        $this->label = $label;
        return $this;
    }

    public function sanitize()
    {
        $this->value[$this->field] = filter_var($this->value[$this->field], FILTER_SANITIZE_STRING);
        return $this;
    }

    public function trim()
    {
        $this->value[$this->field] = trim($this->value[$this->field]);
        return $this;
    }

    public function required()
    {
        if ($this->value[$this->field] == '' || $this->value[$this->field] == null) {
            $this->setError("Por favor, preencha o campo {$this->label}");
        }
        return $this;
    }

    public function isEmail()
    {
        if (!filter_var($this->value[$this->field], FILTER_VALIDATE_EMAIL)) {
            $this->setError("Por favor, preencha com um E-mail válido");
        }
        return $this;
    }

    private function setError($error)
    {
        $this->error[$this->field] = $error;
    }

    public function getError($field)
    {
        if (isset($this->error[$field]))
            return $this->error[$field];
    }

    public function hasError()
    {
        if (!is_null($this->error)) {
            return true;
        }
        return false;
    }

    public function getValue($field)
    {
        if (isset($this->value[$field]))
            return $this->value[$field];
    }
}
