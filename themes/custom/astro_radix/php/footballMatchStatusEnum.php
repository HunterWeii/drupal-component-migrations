<?php

namespace Drupal\astro_sports\Enum;

enum FootballMatchStatusEnum: string {
  case ABNORMAL = 'Abnormal';
  case NOT_STARTED = 'Not started';
  case FIRST_HALF = 'First half';
  case HALF_TIME = 'Half-time';
  case SECOND_HALF = 'Second half';
  case OVERTIME = 'Overtime';
  case PENALTY = 'Penalty Shoot-out';
  case END = 'End';
  case CUT_IN_HALF = 'Cut in half';
  case CANCEL = 'Cancel';
  case TO_BE_DETERMINED = 'To be determined';
  case DELAY = 'Delay';
}
