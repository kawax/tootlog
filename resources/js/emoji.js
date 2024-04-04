import twemoji from "@twemoji/api";

export default {
  toImage(input) {
    return twemoji.parse(input);
  }
};
