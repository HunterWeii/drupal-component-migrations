/** @type { import('@storybook/html-vite').Main } */

import { mergeConfig } from "vite";
import twig from "vite-plugin-twig-drupal";
import path from "path";
import ViteYAML from "@modyfi/vite-plugin-yaml";

// Convert Windows paths to POSIX
const posixPath = (p) => p.split(path.sep).join(path.posix.sep);

const config = {
  stories: ["../components/**/*.stories.@(js|jsx|ts|tsx)"],
  addons: ["@storybook/addon-docs"],
  framework: {
    name: "@storybook/html-vite",
    options: {},
  },
  core: {
    builder: "@storybook/builder-vite",
  },
  async viteFinal(config) {
    return mergeConfig(config, {
      plugins: [
        twig({
          // Match your theme’s Twig structure
          namespaces: {
            astro_radix: posixPath(path.resolve(__dirname, "../components")),
          },
        }),
        ViteYAML(),
      ],
      resolve: {
        alias: {
          "@components": posixPath(path.resolve(__dirname, "../components")),
        },
      },
    });
  },
};
export default config;
