<?php

namespace Drupal\astro_sports\Utils;
use Drupal\astro_sports\Enum\FootballKnockoutEnum;
use Drupal\astro_sports\Enum\FootballMatchStatusEnum;

class BadmintonFixturesBuilder {
  private function getMatchLocaleDate(string $fixtureMatchDate, string $locale = 'en', bool $useShortDay = false) {
    if (empty($fixtureMatchDate)) {
      return '';
    }

    $daykey = $useShortDay ? 'shortDay' : 'day';
    
    $dateLocale = [
      'ms' => [
        'day' => ['Ahad', 'Isnin', 'Selasa', 'Rabu', 'Khamis', 'Jumaat', 'Sabtu'],
        'shortDay' => ['Ahad', 'Isnin', 'Selasa', 'Rabu', 'Khamis', 'Jumaat', 'Sabtu'],
        'month' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Julai', 'Ogos', 'Sept', 'Okt', 'Nov', 'Dis'],
      ],
      'en' => [
        'day' => ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
        'shortDay' => ['Sun', 'Mon', 'Tue', 'Wed', 'Thur', 'Fri', 'Sat'],
        'month' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'],
      ],
    ];

    $date = new \DateTime($fixtureMatchDate);

    $matchdayformat = $date -> format('w');
    $matchdateformat = $date -> format('d');
    $matchmonthformat = $date -> format('n'); 

    return $dateLocale[$locale][$daykey][$matchdayformat] . ' ,' . $matchdateformat . ' ' . $dateLocale[$locale]['month'][$matchmonthformat];
  }

  private function getFixtureGroupTitle(array $params): string {
    $stageName = $params['stageName'] ?? '';
    $matchTime = $params['matchTime'] ?? '';
    $groupNum = $params['groupNum'] ?? '';
    $useBracketTitle = $params['useBracketTitle'] ?? false;
    $langcode = $params['langcode'] ?? 'en';

    // Define locale text for "Group"
    $groupLocale = ($langcode === 'ms') ? 'Kumpulan' : 'Group';
    $groupTitle = '';

    // Case 1: useBracketTitle = true → return formatted date title
    if ($useBracketTitle) {
      return $this -> getMatchLocaleDate($matchTime, $langcode, false);
    }

    // Normalize stage name to enum, if valid
    $stageEnum = null;
    foreach (FootballKnockoutEnum::cases() as $case) {
      if ($case->value === $stageName) {
        $stageEnum = $case;
        break;
      }
    }

    // Case 2: Group stages
    if ($stageEnum === FootballKnockoutEnum::GROUP || $stageEnum === FootballKnockoutEnum::GROUP_COMPETITION) {
      $groupTitle = sprintf('%s %s', $groupLocale, $groupNum);
    }
    // Case 3: League → use date title
    elseif ($stageEnum === FootballKnockoutEnum::LEAGUE) {
      $groupTitle = $this -> getMatchLocaleDate($matchTime, $langcode, false);
    }
    // Case 4: Knockout stages → get localized label
    elseif ($stageEnum instanceof FootballKnockoutEnum) {
      $groupTitle = $stageEnum->getLabel($langcode);
    }
    // Fallback
    else {
      $groupTitle = $stageName;
    }

    return $groupTitle;
  }

  private function getFixtureGroupLabel(string $stageName, string $langcode = 'en') {
    $groupLabel = '';

    // Try to match to KnockoutEnum
    $stageEnum = null;
    foreach (FootballKnockoutEnum::cases() as $case) {
      if ($case->value === $stageName) {
        $stageEnum = $case;
        break;
      }
    }

    if ($stageEnum === FootballKnockoutEnum::THIRD_PLACE) {
      $groupLabel = ($langcode === 'ms')
        ? 'Perlawanan tempat ketiga'
        : 'Third place play-off';
    }

    return $groupLabel;
  }

  private function checkGameHasPenalty(array $fixture): bool {
    $awayScoresDetails = $fixture['awayScoresDetails'] ?? [];
    $homeScoresDetails = $fixture['homeScoresDetails'] ?? [];
    $statusCode = $fixture['statusCode'] ?? null;

    return $this -> checkHasPenalty($awayScoresDetails, $homeScoresDetails, $statusCode);
  }

  private function checkHasPenalty(array $awayScoresDetails = [], array $homeScoresDetails = [], string $matchStatusCode = ''): bool {
    $awayPenalty = $awayScoresDetails['PenaltyShootout'] ?? 0;
    $homePenalty = $homeScoresDetails['PenaltyShootout'] ?? 0;

    return !($awayPenalty === 0 && $homePenalty === 0) || $this -> checkIsPenaltyState($matchStatusCode);
  }

  private function checkIsPenaltyState(string $matchStatusCode): bool {
    return $matchStatusCode === FootballMatchStatusEnum::PENALTY;
  }

  private function getScore(array $scoreDetails) {
    return $scoreDetails['OverTimeScore'] ?? $scoreDetails['Score'];
  }

  private function getScores(array $scoreDetails, bool $hasPenalty): array {
    $PenaltyShootout = $scoreDetails['PenaltyShootout'] ?? 0;

    // Assuming you have a helper function getScore($scoreDetails)
    $score = $this -> getScore($scoreDetails);

    $scores = [[
        'type' => 'goal',
        'score' => (string) $score,
    ]];

    if ($hasPenalty) {
        $scores[] = [
            'type' => 'penalty',
            'score' => "({$PenaltyShootout})",
        ];
    }

    return $scores;
  }

  private function getScoreResult(int $awayScore, int $homeScore): string {
    if ($awayScore > $homeScore) {
      return 'win';
    } elseif ($homeScore > $awayScore) {
      return 'lose';
    } else {
      return 'draw';
    }
  }

  private function getScoreboxIndicator($awayScoresDetails, $homeScoresDetails, $matchStatusCode) {
    // Determine if the match includes a penalty shootout
    $hasPenalty = $this -> checkHasPenalty($awayScoresDetails, $homeScoresDetails, $matchStatusCode);

    // Choose which score to use
    $awayScore = $hasPenalty
      ? ($awayScoresDetails['PenaltyShootout'] ?? null)
      : $this -> getScore($awayScoresDetails);

    $homeScore = $hasPenalty
      ? ($homeScoresDetails['PenaltyShootout'] ?? null)
      : $this -> getScore($homeScoresDetails);

    // Return both team indicators
    return [
      'home' => $this -> getScoreResult($homeScore, $awayScore),
      'away' => $this -> getScoreResult($awayScore, $homeScore),
    ];
  }

  private function getGameTeams(array $fixture, bool $useInternationalFlagSize = false): array {
    // home team
    $homeTeamName = $fixture['homeTeamName'] ?? 'TBD';
    $homeTeamCountryLogo = $fixture['homeTeamCountryLogo'] ?? '';
    $homeTeamLogo = $fixture['homeTeamLogo'] ?? '';
    $homeScoresDetails = $fixture['homeScoresDetails'] ?? [];
    $homeTeamAbbrShortName = $fixture['homeTeamAbbrShortName'] ?? '';

    // away team
    $awayTeamName = $fixture['awayTeamName'] ?? 'TBD';
    $awayTeamCountryLogo = $fixture['awayTeamCountryLogo'] ?? '';
    $awayTeamLogo = $fixture['awayTeamLogo'] ?? '';
    $awayScoresDetails = $fixture['awayScoresDetails'] ?? [];
    $awayTeamAbbrShortName = $fixture['awayTeamAbbrShortName'] ?? '';

    $statusCode = $fixture['statusCode'] ?? '';

    // Helper logic reused from earlier converted PHP functions
    $hasPenalty = $this -> checkGameHasPenalty($fixture);
    $hasScore = $this -> getGameHasScore(['matchStatusCode' => $statusCode]);

    $awayScores = $hasScore ? $this -> getScores($awayScoresDetails, $hasPenalty) : [];
    $homeScores = $hasScore ? $this -> getScores($homeScoresDetails, $hasPenalty) : [];

    $scoreboxIndicator = $this -> getScoreboxIndicator($awayScoresDetails, $homeScoresDetails, $statusCode);
    $isMatchEnd = $this -> checkGameHasEnded(['matchStatusCode' => $statusCode]);

    // Build final structure
    return [
        'home' => [
            'isMatchEnd' => $isMatchEnd,
            'team' => [$homeTeamName],
            'teamShortName' => [$homeTeamAbbrShortName],
            'teamLogo' => [[
                'src' => $useInternationalFlagSize ? $homeTeamCountryLogo : $homeTeamLogo,
                'alt' => "{$homeTeamName}-team-logo",
                'width' => 40,
                'height' => $useInternationalFlagSize ? 24 : 40,
            ]],
            'scores' => $homeScores,
            'scoreboxIndicator' => $isMatchEnd ? ($scoreboxIndicator['home'] ?? '') : '',
            'useInternationalFlagSize' => $useInternationalFlagSize,
        ],
        'away' => [
            'isMatchEnd' => $isMatchEnd,
            'team' => [$awayTeamName],
            'teamShortName' => [$awayTeamAbbrShortName],
            'teamLogo' => [[
                'src' => $useInternationalFlagSize ? $awayTeamCountryLogo : $awayTeamLogo,
                'alt' => "{$awayTeamName}-team-logo",
                'width' => 40,
                'height' => $useInternationalFlagSize ? 24 : 40,
            ]],
            'scores' => $awayScores,
            'scoreboxIndicator' => $isMatchEnd ? ($scoreboxIndicator['away'] ?? '') : '',
            'useInternationalFlagSize' => $useInternationalFlagSize,
        ],
    ];
  }

  private function getAMSEventPlatform(array $amsEvent): array {
    $platforms = $amsEvent['platforms'] ?? [];
    $name = $amsEvent['name'] ?? '';

    $channels = [];

    foreach ($platforms as $platform) {
        $eventUrl = $platform['eventUrl'] ?? '';
        $platformLogo = $platform['platformLogo'] ?? '';
        $platformName = $platform['platformName'] ?? '';

        $alt = "{$name}-{$platformName}";

        $channels[] = [
          'href' => $eventUrl,
          'isExternal' => true,
          'channelName' => $platformName,
          'channelLogo' => [
              'src' => $platformLogo,
              'alt' => $alt,
              'width' => 40,
              'height' => 24,
          ],
        ];
    }

    return $channels;
  }

  private function getGameMatchLive(array $params): string {
    $matchStatusCode = $params['matchStatusCode'] ?? '';
    $liveMatchTime = $params['liveMatchTime'] ?? '';
    $shortForm = $params['shortForm'] ?? true;
    $hasPenalty = $params['hasPenalty'] ?? false;

    switch ($matchStatusCode) {
        case FootballMatchStatusEnum::FIRST_HALF->value:
        case FootballMatchStatusEnum::SECOND_HALF->value:
            return $liveMatchTime;

        case FootballMatchStatusEnum::OVERTIME->value:
            $overtimeText = $shortForm ? 'OT' : 'Overtime';
            return $liveMatchTime ? $liveMatchTime : $overtimeText;

        case FootballMatchStatusEnum::PENALTY->value:
            return 'LIVE';

        case FootballMatchStatusEnum::HALF_TIME->value:
            return $shortForm ? 'HT' : 'Half Time';

        case FootballMatchStatusEnum::END->value:
            $fulltimeText = $shortForm ? 'FT' : 'Full Time';
            if ($hasPenalty) {
                $fulltimeText .= '(P)';
            }
            return $fulltimeText;

        case FootballMatchStatusEnum::CUT_IN_HALF->value:
        case FootballMatchStatusEnum::CANCEL->value:
            return '';

        case FootballMatchStatusEnum::TO_BE_DETERMINED->value:
            return 'TBD';

        case FootballMatchStatusEnum::DELAY->value:
            return 'PPD';

        default:
            return '';
    }
  }

  private function getMatchTime(string $fixtureMatchDateTime) {
    if (empty($fixtureMatchDateTime)) {
      return '';
    }

    $date = new \DateTime($fixtureMatchDateTime);

    return $date -> format('h:i A');
  }

  private function getGameHasScore(array $params): bool {
    $matchStatusCode = $params['matchStatusCode'] ?? '';

    $hasScoreStatusCode = [
        FootballMatchStatusEnum::FIRST_HALF->value,
        FootballMatchStatusEnum::HALF_TIME->value,
        FootballMatchStatusEnum::SECOND_HALF->value,
        FootballMatchStatusEnum::OVERTIME->value,
        FootballMatchStatusEnum::END->value,
        FootballMatchStatusEnum::PENALTY->value,
    ];

    return in_array($matchStatusCode, $hasScoreStatusCode, true);
  }

  private function checkGameHasEnded(array $params): bool {
    $matchStatusCode = $params['matchStatusCode'] ?? '';

    return $matchStatusCode === FootballMatchStatusEnum::END->value;
  }

  private function getGameMatchLink(string $matchId, string $matchTeams = ''): array {
    $matchTeamsURL = strtolower(str_replace(' ', '-', $matchTeams));

    return [
        'matchDetailsLink' => "/match/{$matchTeamsURL}/{$matchId}",
        'isExternal' => true,
    ];
  }

  // === main ===
  private function buildFixtureContentData(array $fixture, array $config): array {
    $id = $fixture['id'] ?? null;
    $matchTime = $fixture['matchTime_time'] ?? null;
    $homeTeamName = $fixture['homeTeamName'] ?? '';
    $awayTeamName = $fixture['awayTeamName'] ?? '';
    $statusCode = $fixture['statusCode'] ?? '';
    $liveMatchTime = $fixture['matchTime'] ?? '';
    $amsEvent = $fixture['amsEvent'] ?? null;

    // Whether match includes a penalty shootout
    $hasPenalty = $this -> checkGameHasPenalty($fixture);

    // Build team info
    $team = $this->getGameTeams($fixture, $config['useInternationalFlagSize'] ?? false);

    // Determine channels (AMS event or fallback)
    $channels = [];
    if (!empty($amsEvent)) {
      $channels = $this -> getAMSEventPlatform($amsEvent);
    }

    // Return structured fixture match info
    return [
      'matchId' => $id,
      'matchLive' => $this -> getGameMatchLive([
        'matchStatusCode' => $statusCode,
        'liveMatchTime' => $liveMatchTime,
        'shortForm' => true,
        'hasPenalty' => $hasPenalty,
      ]),
      'matchTime' => $this -> getMatchTime($matchTime),
      'matchDateTime' => $matchTime,
      'matchFormatDateTime' => $this -> getMatchLocaleDate($matchTime, 'en', true),
      'awayTeam' => $team['away'] ?? [],
      'homeTeam' => $team['home'] ?? [],
      'channels' => $channels,
      'hasScore' => $this -> getGameHasScore([
        'matchStatusCode' => $statusCode,
        'liveMatchTime' => $liveMatchTime,
      ]),
      'isMatchEnd' => $this -> checkGameHasEnded([
        'matchStatusCode' => $statusCode,
      ]),
      'matchLink' => $this -> getGameMatchLink(
        $id,
        trim("$homeTeamName $awayTeamName"),
      ),
    ];
  }

  private function buildFixtureGroupData($match, $config) {
    $group = [];
    $showGroupHeader = $config['showGroupHeader'] ?? true;

    foreach ($match['fixtures'] as $fixtureIndex => $fixture) {
        $stageName = $fixture['stageName'] ?? 'Groups';
        $round = $fixture['round'] ?? [];
        $matchTime = $fixture['matchTime_time'] ?? null;
        $id = $fixture['id'] ?? '';

        $groupNum = $round['groupNum'] ?? null;

        $groupTitle = $this->getFixtureGroupTitle([
            'stageName' => $stageName,
            'groupNum' => $groupNum,
            'matchTime' => $matchTime,
            'useBracketTitle' => $config['useBracketTitle'] ?? null,
        ]);

        $groupLabel = $this->getFixtureGroupLabel($stageName);

        if (!isset($group[$groupTitle])) {
            $group[$groupTitle] = [
                'fixtureGroupId' => "{$id}_{$groupTitle}_{$fixtureIndex}",
                'groupTitle' => $groupTitle,
                'groupLabel' => $groupLabel,
                'showGroupHeader' => $showGroupHeader,
                'fixtures' => [],
            ];
        }

        $fixtureData = $this -> buildFixtureContentData($fixture, $config);
        $group[$groupTitle]['fixtures'][] = $fixtureData;
    }

    // Return as a numerically indexed array
    return array_values($group);
  }

  private function buildFixtureHeaderMatchDetail($fixtureData) {
    $competitionName = $fixtureData['competitionName'];

    return [
      "competitionLogo" => [
        "src" => $fixtureData['competitionLogo'] ?? '',
        "alt" => "competition-logo",
        "width" => 40,
        "height" => 40
      ],
      "competitionName" => $competitionName,
      "competitionLink" => null, // @todo
    ];
  }

  private function buildFixtureHeaderTitle($fixtureMatch, $locale) {
    $headerTitle = '';

    if (array_key_exists('roundCount', $fixtureMatch)) {
      $roundNum = $fixtureMatch['roundNum'];
      $roundCount = $fixtureMatch['roundCount'];

      $headerTitle = 'Gameweek ' . $roundNum . ' of ' . $roundCount;
    } else {
      $matchdate = $fixtureMatch['date'];
      $headerTitle = $this -> getMatchLocaleDate($matchdate, $locale);
    }

    return $headerTitle;
  }

  // main
  public function buildFixtureData($fixtureData, $fixtureConfig) {
    // config
    $buildHeaderFromAPI = $fixtureConfig['buildHeaderFromAPI'] ?? false;

    // data
    $fixtures = [];
    $fixtureMatches = $fixtureData['allMatches'];

    foreach($fixtureMatches as $fixtureMatch) {
      $match = [
        "fixtureHeader" => [
          "fixtureHeaderTitle" => $this -> buildFixtureHeaderTitle($fixtureMatch, $fixtureConfig['locale']),
          "fixtureHeaderMatchDetail" => $buildHeaderFromAPI ? $this -> buildFixtureHeaderMatchDetail($fixtureData) : null,
          "fixtureHeaderStyle" => ''
        ],
        "fixtureGroups" => $this -> buildFixtureGroupData($fixtureMatch, $fixtureConfig),
      ];

      $fixtures[] = $match;
    }

    return $fixtures;  
  }
}

?>