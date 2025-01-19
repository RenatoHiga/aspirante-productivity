<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Http\Request;

use App\Http\Controllers\RatingsDatesController;

class RatingsDatesTest extends TestCase
{

    public function test_create_rating() {
        $rating = new Request([
            'user_id' => '1',
            'rating' => 'average',
            'description' => 'Description test',
            'date' => date('Y-m-d', strtotime('now')),
        ]);

        $ratingsDatesController = new RatingsDatesController();
        $result = $ratingsDatesController->create($rating)->getData();

        $this->assertIsObject($result->date_rating);
    }

    public function test_update_rating() {
        $date_rating = new Request([
            'user_id' => '1',
            'rating' => 'good',
            'description' => 'Description test',
            'date' => date('Y-m-d', strtotime('+ 1 Day'))
        ]);

        $ratingsDatesController = new RatingsDatesController();
        $result = $ratingsDatesController->create($date_rating)->getData();

        $id = $result->rating_date->id;
        $updated_date_rating = new Request([
            'id' => $id,
            'rating' => 'bad',
            'description' => 'Updated description',
            'date' => date('Y-m-d', strtotime('+ 2 Days'))
        ]);

        $result = $ratingsDatesController->update($updated_date_rating)->getData();

        $this->assertEquals('bad', $result->rating_date->rating);
        $this->assertEquals('Updated description', $result->rating_date->description);
    }

    public function test_delete_rating() {
        $rating_date = new Request([
            'user_id' => '1',
            'rating' => 'bad',
            'description' => 'Delete test',
            'date' => date('Y-m-d', strtotime('now')),
        ]);

        $ratingsDatesController = new RatingsDatesController();
        $result = $ratingsDatesController->create($rating_date)->getData();

        $id = $result->rating_date->id;
        $rating_date = new Request([
            'id' => $id
        ]);

        $result = $ratingsDatesController->delete($rating_date)->getData();
        $this->assertEquals('success', $result->status);
    }

    public function test_get_rating(): void
    {
        $filters = new Request([
            'date' => date('Y-m-d', strtotime('now'))
        ]);

        $ratingsDatesController = new RatingsDatesController();
        $result = $ratingsDatesController->get($filters)->getData();
    
        $this->assertIsArray($result->rating_date);
    }
}
