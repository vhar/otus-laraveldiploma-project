<?php

namespace App\Services\UseCases\Commands\Marketplaces\Ozon;

use Exception;

class OzonPictureUploadException extends Exception
{
    /**
     * @var UploadErrorDetail[]
     */
    private array $details;

    /**
     * @param UploadErrorDetail[] $details
     * @return void
     */
    public function setDetails(array $details): void
    {
        $this->details = $details;
    }

    /**
     * @return UploadErrorDetail[]
     */
    public function getDetails(): array
    {
        return $this->details;
    }
}
