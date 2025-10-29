<?php

namespace Drupal\astro_sports\Enum;

enum FootballKnockoutEnum: string {
  case LEAGUE = 'League';
  case GROUP = 'Groups';
  case GROUP_COMPETITION = 'Group Competition';
  case ROUND_OF_16 = '1/8 Finals';
  case QUARTER_FINALS = 'Quarter finals';
  case SEMI_FINALS = 'Semifinal';
  case THIRD_PLACE = 'Third place';
  case FINAL = 'Finals';

  public function getLabel(string $langcode = 'en'): string {
    $locale = match ($this) {
      self::SEMI_FINALS => ['en' => 'Semi Finals', 'ms' => 'Separuh Akhir'],
      self::ROUND_OF_16 => ['en' => 'Round of 16', 'ms' => 'Pusingan 16'],
      self::QUARTER_FINALS => ['en' => 'Quarter Finals', 'ms' => 'Suku Akhir'],
      self::FINAL => ['en' => 'Finals', 'ms' => 'Akhir'],
      self::THIRD_PLACE => ['en' => 'Finals', 'ms' => 'Akhir'],
      default => ['en' => $this->value, 'ms' => $this->value],
    };

    return $locale[$langcode] ?? $this->value;
  }

  /**
   * Returns all enum values with localized labels (for form options).
   */
  public static function options(string $langcode = 'en'): array {
    $options = [];
    foreach (self::cases() as $case) {
      $options[$case->value] = $case->getLabel($langcode);
    }
    return $options;
  }
}
