import "@components/sports/avatar/avatar.css";
import "../match-timeline.css";

import timelineTemplate from "@components/sports/match-timeline/match-timeline.twig";

export default {
  title: "Components/Sports/Match Timeline",
};

export const Default = {
  render: () => timelineTemplate(),
};

export const TimelineRedCard = {
  render: () =>
    timelineTemplate({
      eventProps: {
        eventType: "redcard",
        eventDescription: "Red Card",
        eventMatchTime: `90+2'`,
      },
      cardEventProps: {
        header: "",
        playerClubName: "BRI",
        playerName: "Ferdi Kadıoğlu",
        playerPosition: "Midfileder",
        playerJerseyNo: "24",
        playerAssist: "",
        clubAvatarProps: {
          src: "https://img.thesports.com/football/team/9b43a690d5a09f1e319f036821e8e1d3.png",
          alt: "brigton-logo",
          outline: "none",
        },
        avatarProps: {
          src: "https://img.thesports.com/football/player/ec44a1ef8831e91cfa1ea76150605d3f.png",
          alt: "Ferdi Kadıoğlu-logo",
          outline: "primary",
        },
      },
    }),
};

export const TimelineYellowCard = {
  render: () =>
    timelineTemplate({
      eventProps: {
        eventType: "yellowcard",
        eventDescription: "Yellow Card",
        eventMatchTime: `43'`,
      },
      cardEventProps: {
        header: "",
        playerClubName: "BRI",
        playerName: "Ferdi Kadıoğlu",
        playerPosition: "Midfileder",
        playerJerseyNo: "24",
        playerAssist: "",
        clubAvatarProps: {
          src: "https://img.thesports.com/football/team/9b43a690d5a09f1e319f036821e8e1d3.png",
          alt: "brigton-logo",
          outline: "none",
        },
        avatarProps: {
          src: "https://img.thesports.com/football/player/ec44a1ef8831e91cfa1ea76150605d3f.png",
          alt: "Ferdi Kadıoğlu-logo",
          outline: "primary",
        },
      },
    }),
};

export const TimelineMatchStart = {
  render: () =>
    timelineTemplate({
      eventProps: {
        eventType: "kickoff",
        eventDescription: "Kick-Off",
        eventMatchTime: "",
      },
      matchStartEventProps: {
        kickoffDescription: "Manchester United started the game",
        clubAvatarProps: {
          src: "https://img.thesports.com/football/team/d39ce586fd7278342dde33b3090b3f75.png",
          alt: "mu-logo",
          outline: "none",
        },
      },
    }),
};

export const TimelineMatchEnd = {
  render: () =>
    timelineTemplate({
      eventProps: {
        eventType: "kickoff",
        eventDescription: "End Of Match",
        eventMatchTime: "",
      },
      matchEndEventProps: {
        kickoffDescription: "Final Whistle by referee",
      },
    }),
};

export const TimelineSubstitution = {
  render: () =>
    timelineTemplate({
      eventProps: {
        eventType: "substitution",
        eventDescription: "Substitution",
        eventMatchTime: "65'",
      },
      substitutionEventProps: {
        players: [
          {
            header: "In",
            playerClubName: "MUN",
            playerName: "Joshua Zirkzee",
            playerPosition: "Forward",
            playerJerseyNo: "24",
            playerAssist: "",
            clubAvatarProps: {
              src: "https://img.thesports.com/football/team/d39ce586fd7278342dde33b3090b3f75.png",
              alt: "mun-logo",
              outline: "none",
            },
            avatarProps: {
              src: "https://img.thesports.com/football/player/464eefdf217334fba8afb0af7ebc711c.png",
              alt: "mun-logo",
              outline: "primary",
            },
          },
          {
            header: "Out",
            playerClubName: "MUN",
            playerName: "Benjamin Sesko",
            playerPosition: "Forward",
            playerJerseyNo: "30",
            playerAssist: "",
            clubAvatarProps: {
              src: "https://img.thesports.com/football/team/d39ce586fd7278342dde33b3090b3f75.png",
              alt: "mun-logo",
              outline: "none",
            },
            avatarProps: {
              src: "https://img.thesports.com/football/player/1b0f2847a4a71f24b2a79cc2bec7347c.png",
              alt: "mun-logo",
              outline: "primary",
            },
          },
        ],
      },
    }),
};

export const TimelineHomeGoal = {
  render: () =>
    timelineTemplate({
      classname: "goal goal__home",
      eventProps: {
        eventType: "goal",
        eventDescription: "GOAL!!",
        eventMatchTime: "90+6'",
      },
      scoreStatsProps: {
        homeTeamName: "MUN",
        homeTeamScore: "4",
        awayTeamName: "BRI",
        awayTeamScore: "2",
      },
      goalEventProps: {
        playerProps: {
          header: "",
          playerClubName: "MUN",
          playerName: "Bryan Mbeumo",
          playerPosition: "Midfielder",
          playerJerseyNo: "19",
          playerAssist: "Ayden Heaven",
          clubAvatarProps: {
            src: "https://img.thesports.com/football/team/d39ce586fd7278342dde33b3090b3f75.png",
            alt: "mun-logo",
            outline: "none",
          },
          avatarProps: {
            src: "https://img.thesports.com/football/player/6a0866c16b75a79fea393eccd5512317.png",
            alt: "mun-logo",
            outline: "primary",
          },
        },
      },
    }),
};

export const TimelineAwayGoal = {
  render: () =>
    timelineTemplate({
      classname: "goal goal__away",
      eventProps: {
        eventType: "goal",
        eventDescription: "GOAL!!",
        eventMatchTime: "90+2'",
      },
      scoreStatsProps: {
        homeTeamName: "MUN",
        homeTeamScore: "3",
        awayTeamName: "BRI",
        awayTeamScore: "2",
      },
      goalEventProps: {
        playerProps: {
          header: "",
          playerClubName: "BRI",
          playerName: "Charalampos Kostoulas",
          playerPosition: "Midfielder",
          playerJerseyNo: "19",
          playerAssist: "James Milner",
          clubAvatarProps: {
            src: "https://img.thesports.com/football/team/9b43a690d5a09f1e319f036821e8e1d3.png",
            alt: "mun-logo",
            outline: "none",
          },
          avatarProps: {
            src: "https://img.thesports.com/football/player/7888b34fc8787cb59dc48873a108a4c4.png",
            alt: "bri-logo",
            outline: "secondary",
          },
        },
      },
    }),
};
