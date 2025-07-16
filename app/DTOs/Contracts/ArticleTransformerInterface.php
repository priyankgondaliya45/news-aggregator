<?php

namespace App\DTOs\Contracts;

use App\DTOs\ArticleResponseDTO;

interface ArticleTransformerInterface
{
    /**
     * Transform raw article array into standardized DTO.
    */
    public function transform(array $raw): ArticleResponseDTO;
}




?>