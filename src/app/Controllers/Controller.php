<?php

namespace App\Controllers;

use App\Exceptions\RouteNotFoundException;

class Controller
{
    protected function validate(array $data, array $validationRules): array
    {
        if (empty($data)) {

            throw new \Exception('Empty post array');
        }

        $validated = [];

        foreach ($data as $key => $value) {
            if ($key === 'id') {
                continue;
            }
            
            if (isset($validationRules[$key])) {
                $rules = $validationRules[$key];
                if (empty($rules)) {
                    $validated[$key] = $value;
                }

                $validated[$key] = $this->validateByRules($value, $rules, $data, $key);   
            }

            if (array_column($validated, 'errors')) {
                $validated['has_errors'] = true;
            } else {
                if ($key === 'password') {
                    $validated[$key] = password_hash(trim($value), PASSWORD_BCRYPT);
                    continue;
                } else if (str_contains($key, 'confirmation')) {
                    continue;
                }
                $validated[$key] = trim($value);
            }
        }

        return $validated;
    }

    private function validateByRules(
        string $value,
        array $validationRules,
        array $data,
        string $key
    ) {
        $errors = [];
        
        foreach ($validationRules as $rule) {
             $error = match ($rule) {
                'min:6' => strlen($value) >= (int)explode(':', $rule)[1] ? false : 'Too short',
                'required' => strlen($value) > 0 ? false : 'This field is required',
                'confirmed' => $value === $data[$key . '-confirmation'] ? false : 'This field must be confirmed',
                'email' => filter_var($value, FILTER_VALIDATE_EMAIL) ? false : 'This field must be valid email',
                'string' => is_string($value) ? false : 'This field must be a string',
                'integer' => is_int((int)$value) ? false : 'This field must be a integer',
                'date' => $this->validateDate($value) ? false : 'This field must be valid date (YYYY-mm-dd)'
            };

            if ($error) {
                $errors['errors'][$rule] = $error;
            }
        }
        
        return $errors;
    }

    private function validateDate($date, $format = 'Y-m-d')
    {

        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;

    }

    protected function checkFormInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    protected function getPages(int $currentPage, int $pagesCount)
    {

        if (!$currentPage || !is_int($currentPage)) {
            $currentPage = 1;
        }

        if ($pagesCount < $currentPage || $currentPage < 0) {
            throw new RouteNotFoundException();
        } 

        $startPage = ($currentPage <= 2) ? 1 : $currentPage - 2;
        $endPage = 4 + $startPage;

        $endPage = ($pagesCount < $endPage) ? $pagesCount : $endPage;
        $diff = $startPage - $endPage + 4;

        if ($startPage - $diff > 0) {

            $startPage -= $diff;
        }

        $paginator = [];
        for ($i = $startPage; $i <= $endPage; $i++) {
            $paginator[] = [
                'is_active' => $currentPage == $i,
                'page' => $i
            ];
        };

        return $paginator;
    }
}
