import "../fixtures.css";
import "../fixtures-header.css";
import "../fixtures-group.css";
import "../fixtures-content.css";

import { fixtureBaseConfig } from "./mock";

import fixturesTemplate from "@components/sports/fixtures/fixtures.twig";

export default {
  title: "Components/Sports/Fixtures",
};

export const Default = {
  render: () => {
    return fixturesTemplate(fixtureBaseConfig);
  },
};
