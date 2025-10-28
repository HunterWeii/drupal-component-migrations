import "@components/sports/title-wrapper/title-wrapper.css";
import "@components/sports/empty-content/empty-content.css";
import "../fixtures-widget.css";

import { fixtureBaseConfig } from "@components/sports/fixtures/stories/mock";

import fixturesWidgetTemplate from "@components/sports/fixtures-widget/fixtures-widget.twig";

export default {
  title: "Components/Sports/Fixtures Widget",
};

export const Default = {
  render: () => {
    return fixturesWidgetTemplate({
      titleWrapperProps: {
        title: "Upcoming Matches",
        showBottomLink: true,
        bottomLinkProps: {
          href: "",
          target: "_blank",
          text: "See More",
        },
      },
      fixture: fixtureBaseConfig,
    });
  },
};
