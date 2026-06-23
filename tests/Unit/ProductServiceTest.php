<?php
namespace Tests\Unit;
use Tests\TestCase;
use App\Services\ProductService;
use App\Repositories\ProductRepository;
use App\Models\Product;
use Mockery;
class ProductServiceTest extends TestCase
{
    protected ProductService $productService;
    protected $productRepositoryMock;
    protected function setUp(): void
    {
        parent::setUp();
        $this->productRepositoryMock = Mockery::mock(ProductRepository::class);
        $this->productService = new ProductService($this->productRepositoryMock);
    }
    public function test_get_all_products_paginated()
    {
        $this->productRepositoryMock->shouldReceive('paginate')
            ->once()
            ->with(15, ['*'], ['category'])
            ->andReturn(new \Illuminate\Pagination\LengthAwarePaginator([], 0, 15));
        $result = $this->productService->getAllPaginated();
        $this->assertInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class, $result);
    }
    public function test_create_product()
    {
        $data = ['product_name' => 'Test', 'product_code' => 'TST-001'];
        $this->productRepositoryMock->shouldReceive('create')
            ->once()
            ->with($data)
            ->andReturn(new Product());
        $result = $this->productService->create($data);
        $this->assertInstanceOf(Product::class, $result);
    }
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
