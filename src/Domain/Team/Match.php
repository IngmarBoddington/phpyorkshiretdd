<?php
declare(strict_types=1);

namespace BallGame\Domain\Team;

use BallGame\Domain\Team\Team;

class Match
{

    private $homeTeam;
    private $awayTeam;
    private $homeTeamScore;
    private $awayTeamScore;

    /**
     * @return \BallGame\Domain\Team\Team
     */
    public function getHomeTeam(): Team
    {
        return $this->homeTeam;
    }

    /**
     * @return \BallGame\Domain\Team\Team
     */
    public function getAwayTeam(): Team
    {
        return $this->awayTeam;
    }

    /**
     * @return int
     */
    public function getHomeTeamScore(): int
    {
        return $this->homeTeamScore;
    }

    /**
     * @return int
     */
    public function getAwayTeamScore(): int
    {
        return $this->awayTeamScore;
    }


    private function __construct(Team $homeTeam, Team $awayTeam, int $homeTeamScore, int $awayTeamScore)
    {
        $this->homeTeam = $homeTeam;
        $this->awayTeam = $awayTeam;
        $this->homeTeamScore = $homeTeamScore;
        $this->awayTeamScore = $awayTeamScore;
    }

    public static function create(Team $homeTeam, Team $awayTeam, int $homeTeamScore, int $awayTeamScore): Match
    {
        return new self($homeTeam, $awayTeam, $homeTeamScore, $awayTeamScore);
    }
}
