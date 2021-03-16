<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TestPartnerController extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetPartners()
    {
        $response = $this->get('/partner');

        $response->assertStatus(200);

        $data = json_decode($response->getContent(), true);

        if ($data['error'] === true) {
            dump('Error');

            return;
        }

        $collection = collect($data['data']['availability']);

        $dates = $collection->keyBy('date')->keys();

        dump('Unique Dates:', $dates);

        $countries = $collection->keyBy('partner.country')->keys();

        dump('Unique Countries:', $countries);

        $result = [];

        foreach ($data['data']['availability'] as $partner) {
            $result[$partner['partner']['country']][] = $partner['date'];
        }

        $popular = collect($result)->sortByDesc(function ($result) {
            return count($result);
        });

        dump($popular->toArray());

        $response = $this->post('/popular', $popular->take(2)->toArray());
        $response->assertStatus(200);

        dump('Sample Output:', $response->getContent());
    }
}
