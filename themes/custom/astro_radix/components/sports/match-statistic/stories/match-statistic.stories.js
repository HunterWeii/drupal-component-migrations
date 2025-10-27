import "../match-statistic.css";

import statsTemplate from "@components/sports/match-statistic/match-statistic.twig";

export default {
  title: "Components/Sports/Match Statistic",
};

export const Default = {
  render: () => {
    return statsTemplate({
      homeTeam: {
        cornerKicks: 5,
        fouls: 3,
        freekicks: 10,
        offsides: 1,
        passes: 100,
        passesAccuracy: 80,
        possession: 100,
        redCards: 0,
        shots: 10,
        shotsOnTarget: 10,
        tackles: 4,
        yellowCards: 1,
      },
      awayTeam: {
        cornerKicks: 5,
        fouls: 3,
        freekicks: 10,
        offsides: 1,
        passes: 100,
        passesAccuracy: 80,
        possession: 100,
        redCards: 0,
        shots: 10,
        shotsOnTarget: 10,
        tackles: 9,
        yellowCards: 3,
      },
    });
  },
};
