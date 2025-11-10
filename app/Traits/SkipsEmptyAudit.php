<?php

namespace App\Traits;

trait SkipsEmptyAudit
{
    private const array EXCLUDED_FIELDS = [
        'updated_at', 'created_at', 'deleted_at', 'timestamp',
    ];

    private const array EMPTY_VALUES = [
        '', null, '0', 0, '0000-00-00', '0000-00-00 00:00:00',
    ];

    public function transformAudit(array $data): array
    {
        if (!$this->getKey()) {
            return [];
        }

        $oldValues = $this->processAuditData($data['old_values'] ?? []);
        $newValues = $this->processAuditData($data['new_values'] ?? []);

        if ($this->isDataEquivalent($oldValues, $newValues)) {
            return [];
        }

        if (empty($oldValues) && empty($newValues)) {
            return [];
        }

        return [
            ...$data,
            'old_values' => $oldValues,
            'new_values' => $newValues,
        ];
    }

    private function processAuditData(array $values): array
    {
        if (empty($values)) {
            return [];
        }

        $processed = [];

        foreach ($values as $key => $value) {
            if ($this->shouldSkipField($key)) {
                continue;
            }

            $cleanValue = $this->cleanValue($value);

            if ($cleanValue !== null) {
                $processed[$key] = $cleanValue;
            }
        }

        return $processed;
    }

    private function shouldSkipField(string $field): bool
    {
        $fieldLower = strtolower($field);

        foreach (self::EXCLUDED_FIELDS as $excluded) {
            if (str_contains($fieldLower, $excluded)) {
                return true;
            }
        }

        return false;
    }

    private function cleanValue($value)
    {
        if (is_array($value)) {
            $cleaned = $this->processAuditData($value);

            return !empty($cleaned) ? $cleaned : null;
        }

        if (is_object($value)) {
            if (method_exists($value, 'toArray')) {
                return $this->cleanValue($value->toArray());
            }

            return method_exists($value, '__toString') ? $this->cleanValue((string)$value) : null;
        }

        if (is_bool($value)) {
            return $value;
        }

        if (is_scalar($value)) {
            return $this->processScalarValue($value);
        }

        return null;
    }

    private function processScalarValue($value)
    {
        if ($this->isEmptyValue($value)) {
            return null;
        }

        if (is_string($value)) {
            $trimmed = trim($value);

            if ($trimmed === '' || $this->isEmptyValue($trimmed)) {
                return null;
            }

            if (is_numeric($trimmed)) {
                return $this->normalizeNumber($trimmed);
            }

            return $trimmed;
        }

        if (is_numeric($value)) {
            return $this->normalizeNumber($value);
        }

        return $value;
    }

    private function isEmptyValue($value): bool
    {
        if (in_array($value, self::EMPTY_VALUES, true)) {
            return true;
        }

        if (is_string($value)) {
            $lower = strtolower(trim($value));

            return in_array($lower, ['null', 'undefined', ''], true);
        }

        return false;
    }

    private function normalizeNumber($value)
    {
        $num = is_string($value) ? (float)$value : $value;

        if ($num == 0) {
            return 0;
        }

        return is_float($num) && floor($num) == $num ? (int)$num : $num;
    }

    private function isDataEquivalent(array $old, array $new): bool
    {
        if (empty($old) && empty($new)) {
            return true;
        }

        if (count($old) !== count($new)) {
            return false;
        }

        foreach ($old as $key => $oldValue) {
            if (!array_key_exists($key, $new)) {
                return false;
            }

            if (!$this->compareValues($oldValue, $new[$key])) {
                return false;
            }
        }

        return true;
    }

    private function compareValues($value1, $value2): bool
    {
        if (is_array($value1) && is_array($value2)) {
            return $this->isDataEquivalent($value1, $value2);
        }

        if (is_array($value1) || is_array($value2)) {
            return false;
        }

        if (is_bool($value1) && is_bool($value2)) {
            return $value1 === $value2;
        }

        if (is_numeric($value1) && is_numeric($value2)) {
            return $this->normalizeNumber($value1) === $this->normalizeNumber($value2);
        }

        if (is_string($value1) && is_string($value2)) {
            $trimmed1 = trim($value1);
            $trimmed2 = trim($value2);

            if ($trimmed1 === $trimmed2) {
                return true;
            }

            if (is_numeric($trimmed1) && is_numeric($trimmed2)) {
                return $this->normalizeNumber($trimmed1) === $this->normalizeNumber($trimmed2);
            }
        }

        return $value1 === $value2;
    }
}
