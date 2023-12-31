<?php

declare(strict_types=1);

namespace PhpMyAdmin\Tests\Gis;

use PhpMyAdmin\Gis\GisFactory;
use PhpMyAdmin\Gis\GisGeometryCollection;
use PhpMyAdmin\Gis\GisLineString;
use PhpMyAdmin\Gis\GisMultiLineString;
use PhpMyAdmin\Gis\GisMultiPoint;
use PhpMyAdmin\Gis\GisMultiPolygon;
use PhpMyAdmin\Gis\GisPoint;
use PhpMyAdmin\Gis\GisPolygon;
use PhpMyAdmin\Tests\AbstractTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

#[CoversClass(GisFactory::class)]
class GisFactoryTest extends AbstractTestCase
{
    /**
     * Test factory method
     *
     * @param string $type geometry type
     * @param string $geom geometry object
     * @psalm-param class-string $geom
     */
    #[DataProvider('providerForTestFactory')]
    public function testFactory(string $type, string $geom): void
    {
        $this->assertInstanceOf($geom, GisFactory::factory($type));
    }

    /**
     * data provider for testFactory
     *
     * @return array<array{string, class-string}>
     */
    public static function providerForTestFactory(): array
    {
        return [
            ['MULTIPOLYGON', GisMultiPolygon::class],
            ['POLYGON', GisPolygon::class],
            ['MULTILINESTRING', GisMultiLineString::class],
            ['LINESTRING', GisLineString::class],
            ['MULTIPOINT', GisMultiPoint::class],
            ['POINT', GisPoint::class],
            ['GEOMETRYCOLLECTION', GisGeometryCollection::class],
        ];
    }
}
