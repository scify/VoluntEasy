# Illustrations

The product illustrations of the website and the README (`docs/assets/img/*.png`)
are drawn with the Stageshow React kit (a Claude Code skill for product
illustrations), with invented demo data. Each folder is one scene (`index.tsx` + CSS).

To change one: copy the folder into the `examples/` folder of a Stageshow
checkout, run its preview server, and film the still:

    node scripts/film.mjs "http://127.0.0.1:5173/?capture=ve-hero" \
      --select "#example .ss-fit" --still --pad 0 --width 1280 --out hero.png

For the phone version use `--width 390 --zoom 0,0,358,340 --scale 2`.
