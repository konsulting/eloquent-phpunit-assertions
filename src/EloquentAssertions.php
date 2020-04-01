<?php

namespace Konsulting\EloquentAssertions;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Trait EloquentAssertions
 *
 * @mixin \PHPUnit\Framework\TestCase
 */
trait EloquentAssertions
{
    /**
     * Assert that two object represent the same Eloquent model.
     *
     * @param Model $expected
     * @param Model $actual
     */
    protected function assertSameModel(Model $expected, Model $actual)
    {
        $this->assertNotNull($actual->getKey(), 'The key must not be null.');
        $this->assertSame($expected->getKey(), $actual->getKey(), 'The models have different keys.');
        $this->assertInstanceOf(get_class($expected), $actual, 'The models are not of the same type.');
    }

    /**
     * Assert that two arrays or collections represent the same Eloquent models.
     *
     * @param \Illuminate\Support\Collection|array $expected
     * @param \Illuminate\Support\Collection|array $actual
     */
    protected function assertSameModels($expected, $actual)
    {
        $expected = Collection::make($expected);
        $actual = Collection::make($actual);

        $this->assertNotEmpty($actual->modelKeys(), 'The collection contains no models.');
        $this->assertSame(
            $expected->pluck('id')->sort()->values()->toArray(),
            $actual->pluck('id')->sort()->values()->toArray(),
            'The collections contain different models.'
        );

        $getClass = function (Model $model) {
            return get_class($model);
        };
        $this->assertSame(
            $expected->map($getClass)->toArray(),
            $actual->map($getClass)->toArray(),
            'The collections contain objects of different classes.'
        );
    }
}
