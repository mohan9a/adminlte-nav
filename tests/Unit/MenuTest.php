<?php

namespace Mohan9a\AdminlteNav\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Mohan9a\AdminlteNav\Tests\TestCase;
use Mohan9a\AdminlteNav\Models\Menu;

class MenuTest extends TestCase
{
  use RefreshDatabase;

  /** @test */
  function a_post_has_a_title()
  {
    $post = Menu::factory()->create(['name' => 'Main Menu']);
    $this->assertEquals('Fake Title', $post->title);
  }
}