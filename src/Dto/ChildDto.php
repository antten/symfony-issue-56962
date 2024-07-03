<?php

namespace App\Dto;

use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

class ChildDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 5)]
        #[SerializedName('first_name')]
        private string $childFirstName,
    ) {
    }
}
