<?php

namespace MVCore;

abstract class Model
{

    public array $fillable = [];
    public array $attributes = [];
    public array $rules = [];
    protected array $rules_list = ['required', 'min', 'max', 'email'];
    protected array $errors = [];
    protected array $error_messages = [
        'required' => 'This :fieldname: field is required',
        'min' => 'This :fieldname: field must be at least minimum :rulevalue: characters',
        'max' => 'This :fieldname: field must be at most maximum :rulevalue: characters'
    ];

    public function loadData(): void
    {
        $data = request()->getData();

        foreach ($this->fillable as $field) {
            if(isset($data[$field])){
                $this->attributes[$field] = $data[$field];
            } else {
                $this->attributes[$field] = '';
            }
        }
    }

    public function validate(): bool
    {
        dump($this->attributes);
        dump($this->rules);

        foreach($this->attributes as $field => $value) {
            if (isset($this->rules[$field])) {
                $this->checkRule([
                    'field-name'    =>      $field,
                    'value'         =>      $value,
                    'rules'         =>      $this->rules[$field],
                ]);
            }
        }

        return true;
    }

    protected function checkRule(array $field): void
    {
        dump($field);

        foreach($field['rules'] as $rule => $rule_value) {
            if (in_array($rule, $this->rules_list)) {
//                var_dump($field['field-name'], $rule, $rule_value);
                if (!call_user_func_array([$this, $rule], [$field['value'], $rule_value])) {
                    dump("Ошибка: " . $field['field-name'], "Правило:" . $rule);
                }
            }
        }
    }

    protected function required($value, $rule_value): bool
    {
        return !empty(trim($value));
    }

    protected function min($value, $rule_value): bool
    {
        return mb_strlen($value, 'UTF-8') >= $rule_value;
    }

    protected function max($value, $rule_value): bool
    {
        return mb_strlen($value, 'UTF-8') <= $rule_value;
    }

    protected function email($value, $rule_value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

}