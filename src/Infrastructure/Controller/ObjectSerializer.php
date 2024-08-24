<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\Extractor\SerializerExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AttributeLoader;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

final class ObjectSerializer extends Serializer
{
    public function __construct(
        private readonly bool $camelCaseToSnakeCase = true,
    ) {
        $classMetadataFactory = new ClassMetadataFactory(new AttributeLoader());

        $camelCaseToSnakeCaseNameConverter = new CamelCaseToSnakeCaseNameConverter();

        if ($this->camelCaseToSnakeCase !== true) {
            $camelCaseToSnakeCaseNameConverter = null;
        }

        $metadataAwareNameConverter = new MetadataAwareNameConverter($classMetadataFactory, $camelCaseToSnakeCaseNameConverter);

        $encoders = [new JsonEncoder()];
        $extractors = new PropertyInfoExtractor(
            listExtractors: [new SerializerExtractor($classMetadataFactory), new ReflectionExtractor()],
            typeExtractors: [new PhpDocExtractor(), new ReflectionExtractor()]
        );
        $normalizers = [
            new ArrayDenormalizer(),
            new PropertyNormalizer(
                $classMetadataFactory,
                $metadataAwareNameConverter,
                propertyTypeExtractor: $extractors
            ),
        ];
        parent::__construct($normalizers, $encoders);
    }
}
