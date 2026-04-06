<?php

namespace App\Models\Concerns;

use App\Services\SeoTemplateRenderer;

/**
 * Shared logic for resolving SEO/content fields with fallback to Service templates.
 *
 * Requires the model to implement:
 *  - service() relation returning Service
 *  - getTemplateVariables(): array — returns ['category' => '...', 'brand' => '...', ...]
 */
trait HasSeoFallback
{
    public function getRenderer(): SeoTemplateRenderer
    {
        return SeoTemplateRenderer::make($this->getTemplateVariables());
    }

    public function resolvedSeoTitle(): ?string
    {
        return $this->seo_title
            ?? $this->getRenderer()->render($this->service?->seo_title);
    }

    public function resolvedSeoDescription(): ?string
    {
        return $this->seo_description
            ?? $this->getRenderer()->render($this->service?->seo_description);
    }

    public function resolvedSeoH1(): ?string
    {
        return $this->seo_h1
            ?? $this->getRenderer()->render($this->service?->seo_h1);
    }

    public function resolvedIntro(): ?string
    {
        $override = $this->custom_intro ?? null;

        return $override
            ?? $this->getRenderer()->render($this->service?->default_intro);
    }

    public function resolvedBody(): ?string
    {
        $override = $this->custom_body ?? null;

        return $override
            ?? $this->getRenderer()->render($this->service?->default_body);
    }

    public function resolvedFaq(): ?array
    {
        $override = $this->custom_faq_json ?? null;

        if ($override !== null) {
            return $override;
        }

        return $this->getRenderer()->renderFaq($this->service?->default_faq_json);
    }

    public function resolvedPriceFrom(): ?string
    {
        $overriden = null;
        if (array_key_exists('price_from', $this->getAttributes())) {
            $overriden = $this->price_from;
        }

        return (string) ($overriden ?? $this->service?->price_from ?? '');
    }

    public function resolvedDurationText(): ?string
    {
        $overriden = null;
        if (array_key_exists('duration_text', $this->getAttributes())) {
            $overriden = $this->duration_text;
        }

        return (string) ($overriden ?? $this->service?->duration_text ?? '');
    }

    public function resolvedCanonicalUrl(): ?string
    {
        return $this->canonical_url ?? null;
    }

    public function resolvedNoindex(): bool
    {
        return (bool) ($this->noindex ?? false);
    }

    /**
     * Get all resolved SEO data as an array for passing to views.
     */
    public function getSeoData(): array
    {
        return [
            'title' => $this->resolvedSeoTitle(),
            'description' => $this->resolvedSeoDescription(),
            'h1' => $this->resolvedSeoH1(),
            'intro' => $this->resolvedIntro(),
            'body' => $this->resolvedBody(),
            'faq' => $this->resolvedFaq(),
            'canonical_url' => $this->resolvedCanonicalUrl(),
            'noindex' => $this->resolvedNoindex(),
        ];
    }
}
