<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Controllers\StatisticController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery;

class StatisticControllerUnitTest extends TestCase
{
    protected $statisticController;

    protected function setUp(): void
    {
        parent::setUp();
        $this->statisticController = new StatisticController();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * Test statisticSaleDay method với cấu trúc AAA
     * 
     * @test
     */
    public function it_returns_daily_sales_statistics_in_correct_format()
    {
        // Arrange - Mock DB facade
        $expectedData = collect([
            (object) ['date' => '2025-10-01', 'total_sales' => 100000],
            (object) ['date' => '2025-10-02', 'total_sales' => 150000]
        ]);

        DB::shouldReceive('table')
            ->once()
            ->with('orders')
            ->andReturnSelf();
        
        DB::shouldReceive('select')
            ->once()
            ->with(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_amount) as total_sales'))
            ->andReturnSelf();
            
        DB::shouldReceive('where')
            ->once()
            ->with('status', 4)
            ->andReturnSelf();
            
        DB::shouldReceive('groupBy')
            ->once()
            ->with('date')
            ->andReturnSelf();
            
        DB::shouldReceive('orderBy')
            ->once()
            ->with('date', 'asc')
            ->andReturnSelf();
            
        DB::shouldReceive('get')
            ->once()
            ->andReturn($expectedData);

        // Act - Gọi method
        $result = $this->statisticController->statisticSaleDay();

        // Assert - Kiểm tra kết quả
        $this->assertInstanceOf(\Illuminate\Http\JsonResponse::class, $result);
        $this->assertEquals(200, $result->getStatusCode());
        $this->assertEquals($expectedData, $result->getData());
    }

    /**
     * Test statisticSaleMonth method
     * 
     * @test
     */
    public function it_returns_monthly_sales_statistics_in_correct_format()
    {
        // Arrange
        $expectedData = collect([
            (object) ['month' => '2025-09', 'total_sales' => 500000],
            (object) ['month' => '2025-10', 'total_sales' => 750000]
        ]);

        DB::shouldReceive('table')
            ->once()
            ->with('orders')
            ->andReturnSelf();
        
        DB::shouldReceive('select')
            ->once()
            ->with(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('SUM(total_amount) as total_sales'))
            ->andReturnSelf();
            
        DB::shouldReceive('where')
            ->once()
            ->with('status', 4)
            ->andReturnSelf();
            
        DB::shouldReceive('groupBy')
            ->once()
            ->with('month')
            ->andReturnSelf();
            
        DB::shouldReceive('orderBy')
            ->once()
            ->with('month', 'asc')
            ->andReturnSelf();
            
        DB::shouldReceive('get')
            ->once()
            ->andReturn($expectedData);

        // Act
        $result = $this->statisticController->statisticSaleMonth();

        // Assert
        $this->assertInstanceOf(\Illuminate\Http\JsonResponse::class, $result);
        $this->assertEquals(200, $result->getStatusCode());
        $this->assertEquals($expectedData, $result->getData());
    }

    /**
     * Test statisticSaleYear method
     * 
     * @test
     */
    public function it_returns_yearly_sales_statistics_in_correct_format()
    {
        // Arrange
        $expectedData = collect([
            (object) ['year' => 2024, 'total_sales' => 1000000],
            (object) ['year' => 2025, 'total_sales' => 1500000]
        ]);

        DB::shouldReceive('table')
            ->once()
            ->with('orders')
            ->andReturnSelf();
        
        DB::shouldReceive('select')
            ->once()
            ->with(DB::raw('YEAR(created_at) as year'), DB::raw('SUM(total_amount) as total_sales'))
            ->andReturnSelf();
            
        DB::shouldReceive('where')
            ->once()
            ->with('status', 4)
            ->andReturnSelf();
            
        DB::shouldReceive('groupBy')
            ->once()
            ->with('year')
            ->andReturnSelf();
            
        DB::shouldReceive('orderBy')
            ->once()
            ->with('year', 'asc')
            ->andReturnSelf();
            
        DB::shouldReceive('get')
            ->once()
            ->andReturn($expectedData);

        // Act
        $result = $this->statisticController->statisticSaleYear();

        // Assert
        $this->assertInstanceOf(\Illuminate\Http\JsonResponse::class, $result);
        $this->assertEquals(200, $result->getStatusCode());
        $this->assertEquals($expectedData, $result->getData());
    }

    /**
     * Test statisticSaleDayChart method với data phức tạp
     * 
     * @test
     */
    public function it_returns_product_chart_statistics_with_calculated_ratios()
    {
        // Arrange
        $mockData = collect([
            (object) ['id' => 1, 'description' => 'Áo thun', 'items' => 3],
            (object) ['id' => 2, 'description' => 'Quần jean', 'items' => 2],
            (object) ['id' => 3, 'description' => 'Giày dép', 'items' => 1]
        ]);

        $expectedResult = collect([
            [
                'type_id' => 1,
                'type_name' => 'Áo thun',
                'items' => 3,
                'ratio' => 0.5,  // 3/6 = 0.5
                'percent' => 50   // 3*100/6 = 50
            ],
            [
                'type_id' => 2,
                'type_name' => 'Quần jean',
                'items' => 2,
                'ratio' => 0.3333,  // 2/6 = 0.3333
                'percent' => 33      // 2*100/6 = 33
            ],
            [
                'type_id' => 3,
                'type_name' => 'Giày dép',
                'items' => 1,
                'ratio' => 0.1667,  // 1/6 = 0.1667
                'percent' => 17      // 1*100/6 = 17
            ]
        ]);

        // Mock database calls
        DB::shouldReceive('table')
            ->once()
            ->with('product_types as pt')
            ->andReturnSelf();
            
        DB::shouldReceive('leftJoin')
            ->once()
            ->with('order_details as od', 'od.product_type_id', '=', 'pt.id')
            ->andReturnSelf();
            
        DB::shouldReceive('leftJoin')
            ->once()
            ->with('orders as o', 'o.id', '=', 'od.order_id')
            ->andReturnSelf();
            
        DB::shouldReceive('where')
            ->once()
            ->with('o.status', 4)
            ->andReturnSelf();
            
        DB::shouldReceive('groupBy')
            ->once()
            ->with('pt.id', 'pt.description')
            ->andReturnSelf();
            
        DB::shouldReceive('select')
            ->once()
            ->with(
                'pt.id',
                'pt.description',
                DB::raw('COUNT(od.id) as items')
            )
            ->andReturnSelf();
            
        DB::shouldReceive('get')
            ->once()
            ->andReturn($mockData);

        // Mock collection sum method
        $mockData->shouldReceive('sum')
            ->once()
            ->with('items')
            ->andReturn(6);

        // Act
        $result = $this->statisticController->statisticSaleDayChart();

        // Assert
        $this->assertInstanceOf(\Illuminate\Http\JsonResponse::class, $result);
        $this->assertEquals(200, $result->getStatusCode());
        
        $resultData = $result->getData();
        
        // Kiểm tra structure của response
        $this->assertCount(3, $resultData);
        
        // Kiểm tra data của item đầu tiên
        $firstItem = $resultData[0];
        $this->assertEquals(1, $firstItem->type_id);
        $this->assertEquals('Áo thun', $firstItem->type_name);
        $this->assertEquals(3, $firstItem->items);
        $this->assertEquals(0.5, $firstItem->ratio);
        $this->assertEquals(50, $firstItem->percent);
    }

    /**
     * Test statisticSaleDayChart khi không có data
     * 
     * @test
     */
    public function it_handles_empty_data_in_chart_statistics()
    {
        // Arrange
        $emptyData = collect([]);

        DB::shouldReceive('table')
            ->once()
            ->with('product_types as pt')
            ->andReturnSelf();
            
        DB::shouldReceive('leftJoin')
            ->twice()
            ->andReturnSelf();
            
        DB::shouldReceive('where')
            ->once()
            ->with('o.status', 4)
            ->andReturnSelf();
            
        DB::shouldReceive('groupBy')
            ->once()
            ->andReturnSelf();
            
        DB::shouldReceive('select')
            ->once()
            ->andReturnSelf();
            
        DB::shouldReceive('get')
            ->once()
            ->andReturn($emptyData);

        $emptyData->shouldReceive('sum')
            ->once()
            ->with('items')
            ->andReturn(0);

        // Act
        $result = $this->statisticController->statisticSaleDayChart();

        // Assert
        $this->assertInstanceOf(\Illuminate\Http\JsonResponse::class, $result);
        $this->assertEquals(200, $result->getStatusCode());
        
        $resultData = $result->getData();
        $this->assertEmpty($resultData);
    }

    /**
     * Test view methods trả về đúng view name
     * 
     * @test
     */
    public function it_returns_correct_view_names_for_view_methods()
    {
        // Arrange & Act & Assert
        $viewTests = [
            ['method' => 'customer', 'expectedView' => 'statistic.customer'],
            ['method' => 'sales', 'expectedView' => 'statistic.sales.days'],
            ['method' => 'showDaySales', 'expectedView' => 'statistic.sales.days'],
            ['method' => 'showMonthSales', 'expectedView' => 'statistic.sales.months'],
            ['method' => 'showYearSales', 'expectedView' => 'statistic.sales.years'],
            ['method' => 'showMonthInventory', 'expectedView' => 'statistic.inventory.months'],
            ['method' => 'showYearInventory', 'expectedView' => 'statistic.inventory.years']
        ];

        foreach ($viewTests as $test) {
            $method = $test['method'];
            $expectedView = $test['expectedView'];
            
            // Mock view function
            $mockView = Mockery::mock();
            
            // Override the view function temporarily
            app()->bind('view', function() use ($mockView, $expectedView) {
                $mockView->shouldReceive('make')
                    ->once()
                    ->with($expectedView)
                    ->andReturn($mockView);
                return $mockView;
            });
            
            $result = $this->statisticController->$method();
            
            // Assert that method returns the view
            $this->assertNotNull($result);
        }
    }

    /**
     * Test xử lý edge case khi total = 0 trong chart statistics
     * 
     * @test 
     */
    public function it_handles_zero_total_in_chart_calculations()
    {
        // Arrange
        $mockData = collect([
            (object) ['id' => 1, 'description' => 'Product A', 'items' => 0],
        ]);

        DB::shouldReceive('table')->once()->andReturnSelf();
        DB::shouldReceive('leftJoin')->twice()->andReturnSelf();
        DB::shouldReceive('where')->once()->andReturnSelf();
        DB::shouldReceive('groupBy')->once()->andReturnSelf();
        DB::shouldReceive('select')->once()->andReturnSelf();
        DB::shouldReceive('get')->once()->andReturn($mockData);

        $mockData->shouldReceive('sum')->once()->with('items')->andReturn(0);

        // Act
        $result = $this->statisticController->statisticSaleDayChart();

        // Assert - Kiểm tra không bị chia cho 0
        $this->assertInstanceOf(\Illuminate\Http\JsonResponse::class, $result);
        
        $resultData = $result->getData();
        $firstItem = $resultData[0];
        
        // Với total = 0, max(1, 0) = 1 để tránh chia cho 0
        $this->assertEquals(0, $firstItem->ratio);
        $this->assertEquals(0, $firstItem->percent);
    }
}