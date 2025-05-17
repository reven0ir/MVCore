<?php

namespace MVCore;

abstract class Model
{

    public string $table = '';
    public array $fillable = [];
    public array $attributes = [];
    public array $rules = [];
    public array $labels = [];
    protected array $rules_list = ['required', 'min', 'max', 'email'];
    protected array $errors = [];
    protected array $error_messages = [
        'required' => ':field-name: field is required',
        'email' => ':field-name: field must be a valid email address',
        'min' => ':field-name: field must be at least minimum :rule-value: characters',
        'max' => ':field-name: field must be at most maximum :rule-value: characters'
    ];

    public function save(): false|string
    {
        $field_keys = array_keys($this->attributes);
        $fields = array_map(fn($field) => "{$field}", $field_keys);
        $fields = implode(',', $fields);

        $values_placeholders = array_map(fn($value) => ":{$value}", $field_keys);
        $values_placeholders = implode(',', $values_placeholders);

        $query = "INSERT INTO {$this->table} ($fields) VALUES ($values_placeholders)";
        db()->query($query, $this->attributes);

        return db()->getInsertId();
    }

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

        foreach($this->attributes as $field => $value) {
            if (isset($this->rules[$field])) {
                $this->checkRule([
                    'field-name'    =>      $field,
                    'value'         =>      $value,
                    'rules'         =>      $this->rules[$field],
                ]);
            }
        }

        return !$this->hasError();
    }

    protected function checkRule(array $field): void
    {
        foreach($field['rules'] as $rule => $rule_value) {
            if (in_array($rule, $this->rules_list)) {
                if (!call_user_func_array([$this, $rule], [$field['value'], $rule_value])) {
                    $this->addError(
                        $field['field-name'],
                        str_replace(
                            [':field-name:', ':rule-value:'],
                            [$this->labels[$field['field-name']] ?? $field['field-name'], $rule_value],
                            $this->error_messages[$rule],
                        )
                    );
                }
            }
        }
    }

    protected function addError($field_name, $error): void
    {
        $this->errors[$field_name][] = $error;
    }

    public function getError(): array
    {
        return $this->errors;
    }

    protected function hasError(): bool
    {
        return !empty($this->errors);
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