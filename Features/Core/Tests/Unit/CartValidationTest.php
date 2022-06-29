<?php

namespace Features\Core\Tests\Unit;

use Features\Core\Services\ValidateCartNumberService;
use PHPUnit\Framework\TestCase;

class CartValidationTest extends TestCase
{

    public function test_cart_number_validates_correctly()
    {
        $validCart = '6037997557708709';
        $validCart1 = '6104337613803152';
        $validCart2 = '6219861918889394';


        $inValidCart = '6037997557706598';
        $inValidCart2 = '5687921121121';
        $inValidCart3 = '6104337613803050';

        $this->assertTrue(ValidateCartNumberService::run($validCart));
        $this->assertTrue(ValidateCartNumberService::run($validCart1));
        $this->assertTrue(ValidateCartNumberService::run($validCart2));

        $this->assertNotTrue(ValidateCartNumberService::run($inValidCart));
        $this->assertNotTrue(ValidateCartNumberService::run($inValidCart2));
        $this->assertNotTrue(ValidateCartNumberService::run($inValidCart3));
    }
}
