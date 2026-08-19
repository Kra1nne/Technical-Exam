<?php

namespace Tests\Feature;

use App\Models\Family;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FamilyCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_family_can_be_created_updated_and_deleted(): void
    {
        $response = $this->get('/families');
        $response->assertStatus(200);

        $response = $this->post('/families', [
            'name' => 'Jane Doe',
            'relation' => 'Mother',
            'gender' => 'Female',
            'dob' => '1990-05-12',
        ]);

        $response->assertRedirect('/families');
        $this->assertDatabaseHas('family', [
            'name' => 'Jane Doe',
            'relation' => 'Mother',
        ]);

        $family = Family::first();

        $this->get('/families/' . $family->id . '/edit')->assertStatus(200);

        $this->put('/families/' . $family->id, [
            'name' => 'Jane Smith',
            'relation' => 'Mother',
            'gender' => 'Female',
            'dob' => '1990-05-12',
        ])->assertRedirect('/families');

        $this->assertDatabaseHas('family', [
            'name' => 'Jane Smith',
        ]);

        $this->delete('/families/' . $family->id)->assertRedirect('/families');

        $this->assertDatabaseMissing('family', [
            'id' => $family->id,
        ]);
    }
}
