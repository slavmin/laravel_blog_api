<?php

namespace App\Console\Traits;

trait AskWithValidation
{
    public function askWithValidation(string $message, array $rules = [], string $name = 'value', $secret = false)
    {
        $answer = $secret ? $this->secret($message) : $this->ask($message);

        $validator = \Validator::make([
            $name => $answer,
        ], [
            $name => $rules,
        ]);

        if ($validator->passes()) {
            return $answer;
        }

        foreach ($validator->errors()->all() as $error) {
            $this->error($error);
        }

        return $this->askWithValidation($message, $rules, $name);
    }
}
