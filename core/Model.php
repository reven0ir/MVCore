<?php

namespace MVCore;

abstract class Model
{

    protected string $table = '';
    protected array $fillable = [];
    public array $attributes = [];
    protected array $rules = [];
    protected array $labels = [];
    protected array $data_items = [];
    protected array $rules_list = ['required', 'min', 'max', 'email', 'unique', 'file', 'extension', 'size', 'match'];
    protected array $errors = [];
    protected array $error_messages = [
        'required' => ':field-name: field is required',
        'email' => ':field-name: field must be a valid email address',
        'min' => ':field-name: field must be at least minimum :rule-value: characters',
        'max' => ':field-name: field must be at most maximum :rule-value: characters',
        'unique' => ':field-name: field must be unique',
        'file' => ':field-name: field is required.',
        'extension' => ':field-name: field must be a valid file. Allowed extensions: :rule-value:',
        'size' => ':field-name: field must be a valid file. Allowed size: :rule-value: bytes',
        'match' => ':field-name: field must match :rule-value: field',
    ];

    public function save(): false|string
    {
        // fields
        $field_keys = array_keys($this->attributes);
        $fields = array_map(fn($field) => "{$field}", $field_keys);
        $fields = implode(',', $fields);

        // values
        $values_placeholders = array_map(fn($value) => ":{$value}", $field_keys);
        $values_placeholders = implode(',', $values_placeholders);
        $query = "INSERT INTO {$this->table} ($fields) VALUES ($values_placeholders)";
        db()->query($query, $this->attributes);

        return db()->getInsertId();
    }

    public function update()
    {
        if (!isset($this->attributes['id'])) {
            return false;
        }

        $fields = '';
        foreach ($this->attributes as $key => $value) {
            if ($key == 'id') {
                continue;
            }
            $fields .= "{$key} = :{$key},";
        }

        $fields = rtrim($fields, ',');

        $query = "UPDATE {$this->table} SET {$fields} WHERE id = :id";
        db()->query($query, $this->attributes);

        return db()->getRowCount();
    }

    public function delete(int $id): int
    {
        db()->query("DELETE FROM {$this->table} WHERE id = :id", [$id]);
        return db()->getRowCount();
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

    public function validate($data = [], $rules = []): bool
    {
        if (!$data) {
            $data = $this->attributes;
        }
        if (!$rules) {
            $rules = $this->rules;
        }

        $this->data_items = $data;

        foreach($data as $field => $value) {
            if (isset($rules[$field])) {
                $this->checkRule([
                    'field-name'    =>      $field,
                    'value'         =>      $value,
                    'rules'         =>      $rules[$field],
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

    public function listError(): string
    {
        $output = '<ul class="list-unstyled">';
        foreach ($this->errors as $field_name => $errors) {
            foreach ($errors as $error) {
                $output .= "<li>{$error}</li>";
            }
        }
        $output .= '</ul>';

        return $output;
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

    protected function match($value, $rule_value): bool
    {
        return $value === $this->data_items[$rule_value];
    }

    protected function unique($value, $rule_value): bool
    {
        $data = explode(',', $rule_value);
        return !(db()->query("SELECT {$data[0]} FROM {$data[0]} WHERE {$data[1]} = :value", [':value' => $value])->getColumn());
    }

    protected function file($value, $rule_value): bool
    {
        if (isset($value['error']) && is_array($value['error'])) {
            foreach ($value['error'] as $error) {
                if ($error != 0) {
                    return false;
                }
            }
        } elseif (isset($value['error']) && $value['error'] != 0) {
            return false;
        }

        return true;
    }

    protected function extension($value, $rule_value): bool
    {
        // file array
        if (is_array($value['name'])) {
            if (empty($value['name'][0])) {
                return true;
            }

            for ($i = 0; $i < count($value['name']); $i++) {
                $file_extension = get_file_extension($value['name'][$i]);
                $allowed_extensions = explode(',', $rule_value);

                if (!in_array($file_extension, $allowed_extensions)) {
                    return false;
                }
            }

            return true;
        }

        // single file
        if (empty($value['name'])) {
            return true;
        }
        $file_extension = get_file_extension($value['name']);
        $allowed_extensions = explode(',', $rule_value);
        return in_array($file_extension, $allowed_extensions);
    }

    protected function size($value, $rule_value): bool
    {
        // file array
        if (is_array($value['size'])) {
            if (empty($value['size'][0])) {
                return true;
            }

            for ($i = 0; $i < count($value['size']); $i++) {
                if ($value['size'][$i] > $rule_value) {
                    return false;
                }
            }

            return true;
        }

        // single file
        if (empty($value['size'])) {
            return true;
        }
        return $value['size'] <= $rule_value;
    }

}