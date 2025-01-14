<?php
namespace Yiisoft\I18n;

/**
 * Locale stores locale information created from BCP 47 formatted string
 * https://tools.ietf.org/html/bcp47
 */
final class Locale
{
    /**
     * @var string|null Two-letter ISO-639-2 language code
     * @see http://www.loc.gov/standards/iso639-2/
     */
    private $language;

    /**
     * @var string|null extended language subtags
     */
    private $extendedLanguage;

    /**
     * @var string|null
     */
    private $extension;

    /**
     * @var string|null Four-letter ISO 15924 script code
     * @see http://www.unicode.org/iso15924/iso15924-codes.html
     */
    private $script;

    /**
     * @var string|null Two-letter ISO 3166-1 country code
     * @see https://www.iso.org/iso-3166-country-codes.html
     */
    private $region;

    /**
     * @var string|null variant of language conventions to use
     */
    private $variant;

    /**
     * @var string|null ICU currency
     */
    private $currency;

    /**
     * @var string|null ICU calendar
     */
    private $calendar;

    /**
     * @var string ICU collation
     */
    private $collation;

    /**
     * @var string|null ICU numbers
     */
    private $numbers;

    /**
     * @var string|null
     */
    private $grandfathered;

    /**
     * @var string|null
     */
    private $private;

    /**
     * Locale constructor.
     * @param string $localeString BCP 47 formatted locale string
     * @see https://tools.ietf.org/html/bcp47
     * @throws \InvalidArgumentException
     */
    public function __construct(string $localeString)
    {
        if (!preg_match(static::getBCP47Regex(), $localeString, $matches)) {
            throw new \InvalidArgumentException($localeString . ' is not valid BCP 47 formatted locale string');
        }

        if (!empty($matches['language'])) {
            $this->language = strtolower($matches['language']);
        }

        if (!empty($matches['region'])) {
            $this->region = strtoupper($matches['region']);
        }

        if (!empty($matches['variant'])) {
            $this->variant = $matches['variant'];
        }

        if (!empty($matches['extendedLanguage'])) {
            $this->extendedLanguage = $matches['extendedLanguage'];
        }

        if (!empty($matches['extension'])) {
            $this->extension = $matches['extension'];
        }

        if (!empty($matches['script'])) {
            $this->script = ucfirst(strtolower($matches['script']));
        }

        if (!empty($matches['grandfathered'])) {
            $this->grandfathered = $matches['grandfathered'];
        }

        if (!empty($matches['private'])) {
            $this->private = preg_replace('~^x-~', '', $matches['private']);
        }

        if (!empty($matches['keywords'])) {
            foreach (explode(';', $matches['keywords']) as $pair) {
                [$key, $value] = explode('=', $pair);

                if ($key === 'calendar') {
                    $this->calendar = $value;
                }

                if ($key === 'collation') {
                    $this->collation = $value;
                }

                if ($key === 'currency') {
                    $this->currency = $value;
                }

                if ($key === 'numbers') {
                    $this->numbers = $value;
                }
            }
        }
    }

    /**
     * @return string Four-letter ISO 15924 script code
     * @see http://www.unicode.org/iso15924/iso15924-codes.html
     */
    public function script(): ?string
    {
        return $this->script;
    }

    /**
     * @param null|string $script Four-letter ISO 15924 script code
     * @see http://www.unicode.org/iso15924/iso15924-codes.html
     * @return self
     */
    public function withScript(?string $script): self
    {
        $new = clone $this;
        $new->script = $script;
        return $new;
    }


    /**
     * @return string variant of language conventions to use
     */
    public function variant(): ?string
    {
        return $this->variant;
    }

    /**
     * @param null|string $variant variant of language conventions to use
     * @return self
     */
    public function withVariant(?string $variant): self
    {
        $new = clone $this;
        $new->variant = $variant;
        return $new;
    }

    /**
     * @return string|null Two-letter ISO-639-2 language code
     * @see http://www.loc.gov/standards/iso639-2/
     */
    public function language(): string
    {
        return $this->language;
    }

    /**
     * @param null|string $language Two-letter ISO-639-2 language code
     * @see http://www.loc.gov/standards/iso639-2/
     * @return self
     */
    public function withLanguage(?string $language): self
    {
        $new = clone $this;
        $new->language = $language;
        return $new;
    }

    /**
     * @return null|string ICU calendar
     */
    public function calendar(): ?string
    {
        return $this->calendar;
    }

    /**
     * @param null|string $calendar ICU calendar
     * @return self
     */
    public function withCalendar(?string $calendar): self
    {
        $new = clone $this;
        $new->calendar = $calendar;
        return $new;
    }


    /**
     * @return null|string ICU collation
     */
    public function collation(): ?string
    {
        return $this->collation;
    }

    /**
     * @param null|string $collation ICU collation
     * @return self
     */
    public function withCollation(?string $collation): self
    {
        $new = clone $this;
        $new->collation = $collation;
        return $new;
    }

    /**
     * @return null|string ICU numbers
     */
    public function numbers(): ?string
    {
        return $this->numbers;
    }

    /**
     * @param null|string $numbers ICU numbers
     * @return self
     */
    public function withNumbers(?string $numbers): self
    {
        $new = clone $this;
        $new->numbers = $numbers;
        return $new;
    }

    /**
     * @return string Two-letter ISO 3166-1 country code
     * @see https://www.iso.org/iso-3166-country-codes.html
     */
    public function region(): ?string
    {
        return $this->region;
    }

    /**
     * @param null|string $region Two-letter ISO 3166-1 country code
     * @see https://www.iso.org/iso-3166-country-codes.html
     * @return self
     */
    public function withRegion(?string $region): self
    {
        $new = clone $this;
        $new->region = $region;
        return $new;
    }

    /**
     * @return string ICU currency
     */
    public function currency(): ?string
    {
        return $this->currency;
    }

    /**
     * @param null|string $currency ICU currency
     * @return self
     */
    public function withCurrency(?string $currency): self
    {
        $new = clone $this;
        $new->currency = $currency;

        return $new;
    }

    /**
     * @return null|string extended language subtags
     */
    public function extendedLanguage(): ?string
    {
        return $this->extendedLanguage;
    }

    /**
     * @param null|string $extendedLanguage extended language subtags
     * @return self
     */
    public function withExtendedLanguage(?string $extendedLanguage): self
    {
        $new = clone $this;
        $new->extendedLanguage = $extendedLanguage;

        return $new;
    }


    /**
     * @return null|string
     */
    public function private(): ?string
    {
        return $this->private;
    }

    /**
     * @param null|string $private
     * @return self
     */
    public function withPrivate(?string $private): self
    {
        $new = clone $this;
        $new->private = $private;

        return $new;
    }

    /**
     * @return string regular expression for parsing BCP 47
     * @see https://tools.ietf.org/html/bcp47
     */
    private static function getBCP47Regex(): string
    {
        $regular = '(?:art-lojban|cel-gaulish|no-bok|no-nyn|zh-guoyu|zh-hakka|zh-min|zh-min-nan|zh-xiang)';
        $irregular = '(?:en-GB-oed|i-ami|i-bnn|i-default|i-enochian|i-hak|i-klingon|i-lux|i-mingo|i-navajo|i-pwn|i-tao|i-tay|i-tsu|sgn-BE-FR|sgn-BE-NL|sgn-CH-DE)';
        $grandfathered = '(?<grandfathered>' . $irregular . '|' . $regular . ')';
        $private = '(?<private>x(?:-[A-Za-z0-9]{1,8})+)';
        $singleton = '[0-9A-WY-Za-wy-z]';
        $extension = '(?<extension>' . $singleton . '(?:-[A-Za-z0-9]{2,8})+)';
        $variant = '(?<variant>[A-Za-z0-9]{5,8}|[0-9][A-Za-z0-9]{3})';
        $region = '(?<region>[A-Za-z]{2}|[0-9]{3})';
        $script = '(?<script>[A-Za-z]{4})';
        $extendedLanguage = '(?<extendedLanguage>[A-Za-z]{3}(?:-[A-Za-z]{3}){0,2})';
        $language = '(?<language>[A-Za-z]{4,8})|(?<language>[A-Za-z]{2,3})(?:-' . $extendedLanguage . ')?';
        $icuKeywords = '(?:@(?<keywords>.*?))?';
        $languageTag = '(?:' . $language . '(?:-' . $script . ')?' . '(?:-' . $region . ')?' . '(?:-' . $variant . ')*' . '(?:-' . $extension . ')*' . '(?:-' . $private . ')?' . ')';
        return '/^(?J:' . $grandfathered . '|' . $languageTag . '|' . $private . ')' . $icuKeywords . '$/';
    }

    public function __toString(): string
    {
        return $this->asString();
    }

    /**
     * @return string
     */
    public function asString(): string
    {
        if ($this->grandfathered !== null) {
            return $this->grandfathered;
        }

        $result = [];
        if ($this->language !== null) {
            $result[] = $this->language;

            if ($this->extendedLanguage !== null) {
                $result[] = $this->extendedLanguage;
            }

            if ($this->script !== null) {
                $result[] = $this->script;
            }

            if ($this->region !== null) {
                $result[] = $this->region;
            }

            if ($this->variant !== null) {
                $result[] = $this->variant;
            }

            if ($this->extension !== null) {
                $result[] = $this->extension;
            }
        }

        if ($this->private !== null) {
            $result[] = 'x-' . $this->private;
        }

        $keywords = [];
        if ($this->currency !== null) {
            $keywords[] = 'currency=' . $this->currency;
        }
        if ($this->collation !== null) {
            $keywords[] = 'collation=' . $this->collation;
        }
        if ($this->calendar !== null) {
            $keywords[] = 'calendar=' . $this->calendar;
        }
        if ($this->numbers !== null) {
            $keywords[] = 'numbers=' . $this->numbers;
        }

        $string = implode('-', $result);

        if ($keywords !== []) {
            $string .= '@' . implode(';', $keywords);
        }

        return $string;
    }

    /**
     * Returns fallback locale
     *
     * @return self fallback locale
     */
    public function fallbackLocale(): self
    {
        $fallback = $this
            ->withCalendar(null)
            ->withCollation(null)
            ->withCurrency(null)
            ->withExtendedLanguage(null)
            ->withNumbers(null)
            ->withPrivate(null);

        if ($fallback->variant() !== null) {
            return $fallback->withVariant(null);
        }

        if ($fallback->region() !== null) {
            return $fallback->withRegion(null);
        }

        if ($fallback->script() !== null) {
            return $fallback->withScript(null);
        }

        return $fallback;
    }
}
