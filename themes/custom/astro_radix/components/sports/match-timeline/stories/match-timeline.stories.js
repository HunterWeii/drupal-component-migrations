import "../match-timeline.css";

import timelineTemplate from "@components/sports/match-timeline/match-timeline.twig";

export default {
  title: "Components/Sports/Match Timeline",
};

export const Default = {
  render: () => timelineTemplate(),
};
