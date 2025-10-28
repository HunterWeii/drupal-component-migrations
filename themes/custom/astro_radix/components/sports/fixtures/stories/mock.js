export const fixtureBaseConfig = {
  fixtureConfig: {
    showFixtureContentDetails: true,
    showTopFixtureDetails: false,
    scoreboard: false,
    showFixtureContentDetailsAsTag: false,
  },
  fixtureHeader: {
    fixtureHeaderMatchDetail: {
      competitionLogo: {
        src: "https://de-digital-fortress-img-assets.eco.astro.com.my/prod/b74e136d71d7092edc6e106b8e8683eb.png",
        alt: "epl-team-logo",
        width: "56",
        height: "56",
      },
      competitionName: "English Premier League",
      competitionLink: {
        href: "https://example.com/competition",
        isExternal: true,
      },
    },
    fixtureHeaderTitle: "Gameweek 10 of 38",
    fixtureHeaderStyle: "",
  },
  fixtureGroups: [
    {
      groupTitle: "Saturday, 01 Nov",
      groupLabel: "",
      showGroupHeader: true,
      fixtures: [
        {
          matchId: "1",
          matchLive: "FT",
          matchTime: "11:00 PM",
          matchDateTime: "",
          matchFormatDateTime: "Rabu, 17 Sept",
          matchLink: {
            matchDetailsLink: "",
            isExternal: true,
          },
          awayTeam: {
            isMatchEnd: true,
            team: ["Brighton Hove Albion"],
            teamShortName: ["BRI"],
            teamLogo: [
              {
                src: "https://img.thesports.com/football/team/9b43a690d5a09f1e319f036821e8e1d3.png",
                alt: "bri-logo",
                width: 40,
                height: 40,
              },
            ],
            scores: [
              {
                type: "goal",
                score: "2",
                roundIndicator: "lose",
              },
            ],
            scoreboxIndicator: "lose",
            useInternationalFlagSize: false,
          },
          homeTeam: {
            isMatchEnd: true,
            team: ["Manchester United"],
            teamShortName: ["MUN"],
            teamLogo: [
              {
                src: "https://img.thesports.com/football/team/d39ce586fd7278342dde33b3090b3f75.png",
                alt: "mu-logo",
                width: 40,
                height: 40,
              },
            ],
            scores: [
              {
                type: "goal",
                score: "4",
                roundIndicator: "win",
              },
            ],
            scoreboxIndicator: "win",
            useInternationalFlagSize: false,
          },
          channels: [
            {
              href: "https://example.com/channel2",
              isExternal: true,
              channelName: "astro go",
              channelLogo: {
                src: "https://de-digital-fortress-stg-assets.eco.astro.com.my/staging/a1e5c4229289adaa4999d85cb7353f9a.png",
                alt: "channel-logo",
                width: 32,
                height: 32,
              },
            },
            {
              href: "https://example.com/channel3",
              isExternal: true,
              channelName: "astro go",
              channelLogo: {
                src: "https://de-digital-fortress-stg-assets.eco.astro.com.my/staging/047bac73ee945fe3e1d387f29a15c556.png",
                alt: "channel-logo",
                width: 40,
                height: 24,
              },
            },
          ],
          hasScore: true,
          isMatchEnd: true,
          isMatchOngoing: false,
          isMatchNotStarted: false,
        },
      ],
    },
  ],
};
