# Illustrations

The product illustrations of the website and the README (`docs/assets/img/*.png`)
are drawn with the Stageshow React kit (a Claude Code skill for product
illustrations), with invented demo data. Each folder is one scene (`index.tsx` + CSS).

To change one: copy the folder into the `examples/` folder of a Stageshow
checkout, run its preview server, and film the still:

    node scripts/film.mjs "http://127.0.0.1:5173/?capture=ve-hero" \
      --select "#example .ss-fit" --still --pad 0 --width 1280 --out hero.png

For the phone version use `--width 390 --zoom 0,0,358,340 --scale 2`.

## The hero video

`ve-lifecycle` is an animated scene. To make the videos again (`docs/assets/video/`):

    # with the scene in the Stageshow preview on port 5179, and Playwright installed
    node video/record.mjs "http://127.0.0.1:5179/?capture=ve-lifecycle&lang=en" /tmp/rec-en
    python3 video/encode.py /tmp/rec-en ../assets/video lifecycle        # .mp4, .webm, -poster.jpg
    node video/record.mjs "http://127.0.0.1:5179/?capture=ve-lifecycle&lang=el" /tmp/rec-el
    python3 video/encode.py /tmp/rec-el ../assets/video lifecycle-el

`record.mjs` runs the stage 8 times slower and takes a 2x screenshot every
1/30 s of stage time; `encode.py` cuts exactly one loop and encodes it with
ffmpeg. The README GIF is made from `lifecycle.mp4` (see the commit message).
