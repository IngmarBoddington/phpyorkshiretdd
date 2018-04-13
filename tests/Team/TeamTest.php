<?php
declare(strict_types=1);


namespace BallGame\Tests\Team;


use BallGame\Domain\Team\Team;
use PHPUnit\Framework\TestCase;

class TeamTest extends TestCase
{
    /**
     * @var Team
     */
    private $team;

    public function setUp()
    {
        $this->team = Team::create('York City');
    }

    /**
     * @covers BallGame\Domain\Team\Team
     */
    public function testGetName()
    {
        $this->assertEquals('York City', $this->team->getName());
    }
}
