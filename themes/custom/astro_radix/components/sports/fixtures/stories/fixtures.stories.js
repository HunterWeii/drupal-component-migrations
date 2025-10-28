import "../fixtures.css";
import "../fixtures-header.css";
import "../fixtures-group.css";
import "../fixtures-content.css";

import { fixtureBaseConfig, fixtureBadmintonConfig } from "./mock";

import fixturesTemplate from "@components/sports/fixtures/fixtures.twig";

export default {
  title: "Components/Sports/Fixtures",
};

export const Default = {
  render: () => {
    return fixturesTemplate(fixtureBaseConfig);
  },
};

export const BadmintonFixture = {
  render: () => fixturesTemplate(fixtureBadmintonConfig),
};
