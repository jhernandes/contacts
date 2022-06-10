<?php

declare(strict_types=1);

namespace Jhernandes\Contacts\Domain;

class Phone
{
    private const VALID_AREA_CODE = '/^(\d{2})?$/';
    private const VALID_NUMBER = '/^(\d{8}|\d{9})?$/';

    private string $phone;
    private string $areaCode;
    private string $number;

    public function __construct(string $areaCode, string $number)
    {
        $this->ensureIsValidAreaCode($areaCode);
        $this->ensureIsValidPhoneNumber($number);

        $this->areaCode = $areaCode;
        $this->number = $number;

        $this->phone = $areaCode . $number;
    }

    public static function fromString(string $phoneNumber): self
    {
        $phoneNumber = preg_replace('/\D/', '', $phoneNumber);

        return new self(
            substr($phoneNumber, 0, 2),
            substr($phoneNumber, 2)
        );
    }

    public function __toString(): string
    {
        return $this->phone;
    }

    public function formatted(): string
    {
        if (strlen($this->number) <= 8) {
            return sprintf(
                '(%s) %s-%s',
                $this->areaCode,
                substr($this->number, 0, 4),
                substr($this->number, 4)
            );
        }

        return sprintf(
            '(%s) %s-%s',
            $this->areaCode,
            substr($this->number, 0, 5),
            substr($this->number, 5)
        );
    }

    protected function ensureIsValidAreaCode(string $areaCode): void
    {
        if (!preg_match(self::VALID_AREA_CODE, $areaCode)) {
            throw new \InvalidArgumentException(
                sprintf(
                    '"%s" is not a valid area code',
                    $areaCode
                )
            );
        }
    }

    protected function ensureIsValidPhoneNumber(string $number): void
    {
        if (!preg_match(self::VALID_NUMBER, $number)) {
            throw new \InvalidArgumentException(
                sprintf(
                    '"%s" is not a valid number',
                    $number
                )
            );
        }
    }
}
