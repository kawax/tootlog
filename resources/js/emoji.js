import twemoji from "twemoji";

export default {
  toImage(input) {
    return twemoji.parse(input);
  }
};
