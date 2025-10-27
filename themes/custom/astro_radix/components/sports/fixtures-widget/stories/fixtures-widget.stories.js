import "@components/sports/title-wrapper/title-wrapper.css";
import "@components/sports/empty-content/empty-content.css";
import "../fixtures-widget.css";

import fixturesWidgetTemplate from "@components/sports/fixtures-widget/fixtures-widget.twig";

export default {
  title: "Components/Sports/Fixtures Widget",
};

export const Default = {
  render: () => {
    return fixturesWidgetTemplate();
  },
};
