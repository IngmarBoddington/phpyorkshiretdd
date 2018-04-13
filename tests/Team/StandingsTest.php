<?php
declare(strict_types=1);


namespace BallGame\Tests\Team;

use BallGame\Domain\Team\Team;
use BallGame\Domain\Team\Standings;
use BallGame\Domain\Team\Match;
use PHPUnit\Framework\TestCase;

class StandingsTest extends TestCase
{
    /**
     * @var Standings
     */
    private $standings;

    public function setUp()
    {
        $this->standings = Standings::create('Year 2020');
    }

    /**
     * @covers BallGame\Domain\Team\Standings
     * @covers BallGame\Domain\Team\Team
     * @covers BallGame\Domain\Team\Match
     */
    public function testGetStandingsReturnsArray() {

        $this->standings = Standings::create('York 2020');

        $standings = $this->standings->getStandings();

        $this->assertInternalType('array', $standings);

    }

    /**
     * @covers BallGame\Domain\Team\Standings
     * @covers BallGame\Domain\Team\Team
     * @covers BallGame\Domain\Team\Match
     */
    public function testRecordAndGetInitialStandings()
    {
        $yorkTeam = Team::create('York City');
        $manchesterTeam = Team::create('Manchester United');

        $match = Match::create($yorkTeam, $manchesterTeam, 3, 1);

        $this->standings->record($match);

        $standings = $this->standings->getStandings();

        $this->assertEquals(
            [
                ['York City', 3, 1, 3],
                ['Manchester United', 1, 3, 0]
            ],
            $standings
        );
    }

    /**
     * @covers BallGame\Domain\Team\Standings
     * @covers BallGame\Domain\Team\Team
     * @covers BallGame\Domain\Team\Match
     */
    public function testRecordAndGetMultipleStandings()
    {
        $yorkTeam = Team::create('York City');
        $manchesterTeam = Team::create('Manchester United');

        $match = Match::create($yorkTeam, $manchesterTeam, 3, 1);
        $this->standings->record($match);

        $match = Match::create($manchesterTeam, $yorkTeam, 20, 1);
        $this->standings->record($match);

        $standings = $this->standings->getStandings();

        $this->assertEquals(
            [
                ['Manchester United', 21, 4, 3],
                ['York City', 4, 21, 3]
            ],
            $standings
        );
    }
}
