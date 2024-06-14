<?php

namespace App\Dto;

use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

class UserDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(max: 10)]
        #[SerializedName('first_name')]
        private string $firstName,
    ) {
    }
}
