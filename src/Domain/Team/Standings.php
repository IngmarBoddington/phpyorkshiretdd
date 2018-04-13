<?php
declare(strict_types=1);


namespace BallGame\Domain\Team;

use BallGame\Domain\Team\Match;

class Standings
{
    /**
     * @var string
     */
    private $name;
    private $standings = array();

    /**
     * @param string $name
     */
    private function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Team
     */
    public static function create(string $name): Standings
    {
        return new self($name);
    }

    public function record(Match $match): Bool {

        //Home Team Win
        if ($match->getHomeTeamScore() > $match->getAwayTeamScore()) {
            $this->recordHomeWin($match);
        } else if ($match->getHomeTeamScore() < $match->getAwayTeamScore()) {
            $this->recordAwayWin($match);
        } else {
            $this->recordDraw($match);
        }

        return true;
    }

    public function getStandings() {
        return $this->standings;
    }

    private function recordHomeWin(Match $match) {

        $homeDone = 0;
        $awayDone = 0;

        foreach ($this->standings as $position => &$stats) {
            if ($stats[0] == $match->getHomeTeam()->getName()) {
                $stats[1] += $match->getHomeTeamScore();
                $stats[2] += $match->getAwayTeamScore();
                $stats[3] += 3;
                $homeDone = 1;
                break;
            }
        }
        unset($stats);
        if ($homeDone != 1) {
            $this->standings[] = [$match->getHomeTeam()->getName(), $match->getHomeTeamScore(), $match->getAwayTeamScore(), 3];
        }

        foreach ($this->standings as $position => &$stats) {
            if ($stats[0] == $match->getAwayTeam()->getName()) {
                $stats[1] += $match->getAwayTeamScore();
                $stats[2] += $match->getHomeTeamScore();
                $stats[3] += 0;
                $awayDone = 1;
                break;
            }
        }
        unset($stats);
        if ($awayDone != 1) {
            $this->standings[] = [$match->getAwayTeam()->getName(), $match->getAwayTeamScore(), $match->getHomeTeamScore(), 0];
        }

        usort($this->standings, function($a, $b) {
            if ($a[3] != $b[3]) {
                return $b[3] <=> $a[3];
           } else {
              return strcmp((string)$a[1], (string)$b[1]);
           }
        });
    }

    private function recordAwayWin(Match $match) {

        $homeDone = 0;
        $awayDone = 0;

        foreach ($this->standings as $position => &$stats) {
            if ($stats[0] == $match->getHomeTeam()->getName()) {
                $stats[1] += $match->getHomeTeamScore();
                $stats[2] += $match->getAwayTeamScore();
                $stats[3] += 0;
                $homeDone = 1;
                break;
            }
        }
        unset($stats);
        if ($homeDone != 1) {
            $this->standings[] = [$match->getHomeTeam()->getName(), $match->getHomeTeamScore(), $match->getAwayTeamScore(), 0];
        }

        foreach ($this->standings as $position => &$stats) {
            if ($stats[0] == $match->getAwayTeam()->getName()) {
                $stats[1] += $match->getAwayTeamScore();
                $stats[2] += $match->getHomeTeamScore();
                $stats[3] += 3;
                $awayDone = 1;
                break;
            }
        }
        unset($stats);
        if ($awayDone != 1) {
            $this->standings[] = [$match->getAwayTeam()->getName(), $match->getAwayTeamScore(), $match->getHomeTeamScore(), 3];
        }

        usort($this->standings, function($a, $b) {
            if ($a[3] != $b[3]) {
                return $b[3] <=> $a[3];
            } else {
                return strcmp((string)$a[1], (string)$b[1]);
            }
        });
    }

    private function recordDraw(Match $match) {

        $homeDone = 0;
        $awayDone = 0;

        foreach ($this->standings as $position => &$stats) {
            if ($stats[0] == $match->getHomeTeam()->getName()) {
                $stats[1] += $match->getHomeTeamScore();
                $stats[2] += $match->getAwayTeamScore();
                $stats[3] += 1;
                $homeDone = 1;
                break;
            }
        }
        unset($stats);
        if ($homeDone != 1) {
            $this->standings[] = [$match->getHomeTeam()->getName(), $match->getHomeTeamScore(), $match->getAwayTeamScore(), 1];
        }

        foreach ($this->standings as $position => &$stats) {
            if ($stats[0] == $match->getAwayTeam()->getName()) {
                $stats[1] += $match->getAwayTeamScore();
                $stats[2] += $match->getHomeTeamScore();
                $stats[3] += 1;
                $awayDone = 1;
                break;
            }
        }
        unset($stats);
        if ($awayDone != 1) {
            $this->standings[] = [$match->getAwayTeam()->getName(), $match->getAwayTeamScore(), $match->getHomeTeamScore(), 1];
        }

        usort($this->standings, function($a, $b) {
            if ($a[3] != $b[3]) {
                return $b[3] <=> $a[3];
            } else {
                return strcmp((string)$a[1], (string)$b[1]);
            }
        });
    }
}
