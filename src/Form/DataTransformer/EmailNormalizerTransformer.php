<?php

namespace App\Form\DataTransformer;

// src/Form/DataTransformer/EmailNormalizerTransformer.php
use Symfony\Component\Form\DataTransformerInterface;

class EmailNormalizerTransformer implements DataTransformerInterface
{
    public function transform($emailFromDb)
    {
        return $emailFromDb;
    }

    public function reverseTransform($emailFromInput)
    {
        if (empty($emailFromInput)) {
            return null;
        }

        $email = strtolower(trim($emailFromInput));
        return preg_replace('/\s+/', '', $email); // Supprime tous les espaces
    }
}