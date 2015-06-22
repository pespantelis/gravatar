<?php

use Peslis\Gravatar\Factory as Gravatar;

class GravatarTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Gravatar
     */
    private $gravatar;

    /**
     * Sets up the fixture.
     * This method is called before a test is executed.
     *
     * @return void
     */
    protected function setUp()
    {
        $this->gravatar = new Gravatar();
        $this->gravatar->url('pespantelis@gmail.com');
    }

    /** @test **/
    public function test_gravatar()
    {
        $this->assertEquals('http://gravatar.com/avatar/ccb58d73db581de14f41eaaf0b644315', $this->gravatar);

        $this->assertEquals('http://gravatar.com/avatar/ccb58d73db581de14f41eaaf0b644315?s=256', $this->gravatar->url('pespantelis@gmail.com', 256));
    }

    /** @test **/
    public function test_https()
    {
        $this->assertEquals('https://secure.gravatar.com/avatar/ccb58d73db581de14f41eaaf0b644315', $this->gravatar->secure());
    }

    /** @test **/
    public function test_size()
    {
        $this->assertEquals('http://gravatar.com/avatar/ccb58d73db581de14f41eaaf0b644315?s=128', $this->gravatar->size(128));
    }

    /** @test **/
    public function test_size_type()
    {
        $this->setExpectedException('Peslis\Gravatar\InvalidSizeException', 'Size must be an integer');

        $this->gravatar->size('128');
    }

    /** @test **/
    public function test_size_value()
    {
        $this->setExpectedException('Peslis\Gravatar\InvalidSizeException', 'Size must be within 1px and 2048px');

        $this->gravatar->size(4096);
    }

    /** @test **/
    public function test_default_image()
    {
        $url = $this->gravatar->defaultImage('404');
        $this->assertEquals('http://gravatar.com/avatar/ccb58d73db581de14f41eaaf0b644315?d=404', $url);

        $url = $this->gravatar->defaultImage('MM');
        $this->assertEquals('http://gravatar.com/avatar/ccb58d73db581de14f41eaaf0b644315?d=mm', $url);

        $url = $this->gravatar->defaultImage('http://example.com/images/avatar.jpg');
        $this->assertEquals('http://gravatar.com/avatar/ccb58d73db581de14f41eaaf0b644315?d=http%253A%252F%252Fexample.com%252Fimages%252Favatar.jpg', $url);
    }

    /** @test **/
    public function test_force_default()
    {
        $this->assertEquals('http://gravatar.com/avatar/ccb58d73db581de14f41eaaf0b644315?f=y', $this->gravatar->forceDefault());

        $this->assertEquals('http://gravatar.com/avatar/ccb58d73db581de14f41eaaf0b644315', $this->gravatar->forceDefault(false));
    }

    /** @test **/
    public function test_rating()
    {
        $this->assertEquals('http://gravatar.com/avatar/ccb58d73db581de14f41eaaf0b644315?r=pg', $this->gravatar->rating('pg'));
    }

    /** @test **/
    public function test_chaining()
    {
        $url = $this->gravatar->secure()->size(256)->defaultImage('identicon')->rating('pg');
        $this->assertEquals('https://secure.gravatar.com/avatar/ccb58d73db581de14f41eaaf0b644315?s=256&d=identicon&r=pg', $url);
    }

    /** @test **/
    public function test_exists()
    {
        $this->assertTrue($this->gravatar->exists());

        $this->gravatar->url('foo@bar.baz');
        $this->assertFalse($this->gravatar->exists());
    }

    /** @test **/
    public function test_default_options()
    {
        $gravatar = new Gravatar(['secure' => true, 'size' => null, 'rating' => 'pg']);

        $this->assertEquals('https://secure.gravatar.com/avatar/ccb58d73db581de14f41eaaf0b644315?r=pg', $gravatar->url('pespantelis@gmail.com'));
    }
}
