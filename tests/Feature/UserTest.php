<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Role;
// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     *
     * @return void
     */

    public function test_update_user()
    {
        $user = User::factory()->create();

        $request = \Request::create('/admin/users/' . $user->id, 'PATCH', [
            'status' => config('constants.user_status.active.value'),
        ]);

        $this->actingAs($user) // Simulate user authentication (if needed)
            ->patchJson('/admin/users/' . $user->id, $request->all());

        $user = User::find($user->id);

        $this->assertEquals(config('constants.user_status.active.value'), $user->status);
    }
}