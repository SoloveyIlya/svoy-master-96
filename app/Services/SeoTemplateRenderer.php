<?php

namespace App\Services;

class SeoTemplateRenderer
{
    protected array $variables = [];

    public function __construct(array $variables = [])
    {
        $this->variables = $variables;
    }

    public static function make(array $variables = []): static
    {
        return new static($variables);
    }

    public function setVariable(string $key, string $value): static
    {
        $this->variables[$key] = $value;

        return $this;
    }

    public function setVariables(array $variables): static
    {
        $this->variables = array_merge($this->variables, $variables);

        return $this;
    }

    /**
     * Replace {category}, {brand}, {model}, {service}, {city} placeholders in a template string.
     */
    public function render(?string $template): ?string
    {
        if ($template === null) {
            return null;
        }

        $replacements = [];
        foreach ($this->variables as $key => $value) {
            $replacements['{' . $key . '}'] = $value;
        }

        return strtr($template, $replacements);
    }

    /**
     * Render FAQ JSON — replace placeholders inside both questions and answers.
     */
    public function renderFaq(?array $faq): ?array
    {
        if ($faq === null) {
            return null;
        }

        return array_map(function (array $item) {
            return [
                'question' => $this->render($item['question'] ?? ''),
                'answer' => $this->render($item['answer'] ?? ''),
            ];
        }, $faq);
    }
}
