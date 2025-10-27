import "../match-scorer.css";

import scorerTemplate from "@components/sports/match-scorer/match-scorer.twig";

export default {
  title: "Components/Sports/Match Scorer",
};

export const Default = {
  render: () => {
    return scorerTemplate({
      homeScoreList: [
        {
          playerId: "1",
          playerName: "Marcus Rashford",
          goals: [
            {
              type: "Goal",
              time: "12",
            },
            {
              type: "Goal",
              time: "13",
            },
          ],
        },
        {
          playerId: "2",
          playerName: "Burno Fernandes",
          goals: [
            {
              type: "Penalty",
              time: "45",
            },
          ],
        },
        {
          playerId: "78",
          playerName: "Harry Maguire",
          goals: [
            {
              type: "Own goal",
              time: "12",
            },
          ],
        },
      ],
      awayScoreList: [
        {
          playerId: "3",
          playerName: "Cole Palmer",
          goals: [
            {
              type: "Goal",
              time: "34",
            },
          ],
        },
        {
          playerId: "4",
          playerName: "Joao Pedro",
          goals: [
            {
              type: "Penalty",
              time: "80",
            },
          ],
        },
      ],
    });
  },
};
