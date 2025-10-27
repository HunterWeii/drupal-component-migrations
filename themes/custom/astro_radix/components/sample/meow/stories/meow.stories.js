import "../meow.css";
import "../../meow-lorem/meow-lorem.css";

import meowTemplate from "@components/sample/meow/meow.twig";
import meowData from "../meow.component.yml";

export default {
  title: "Components/Sports/Meow",
};

export const Default = {
  render: () => meowTemplate(meowData),
};
