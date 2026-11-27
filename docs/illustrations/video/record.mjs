// node record2.mjs <url> <outDir> : run the stage SLOW times slower and take 2x
// screenshots of it every 1/30 s of stage time; times are written in stage seconds.
import { chromium } from 'playwright';
import fs from 'node:fs';
const [url, out] = process.argv.slice(2);
const SLOW = 8, FPS = 30;
fs.rmSync(out, { recursive: true, force: true }); fs.mkdirSync(out, { recursive: true });
const b = await chromium.launch();
const ctx = await b.newContext({ viewport: { width: 760, height: 440 }, deviceScaleFactor: 2 });
const page = await ctx.newPage();
await page.addInitScript((slow) => { window.__stageshow = { slow }; }, SLOW);
const cdp = await ctx.newCDPSession(page);
await cdp.send('Animation.enable');
await cdp.send('Animation.setPlaybackRate', { playbackRate: 1 / SLOW });
await page.goto(url, { waitUntil: 'networkidle' });
const stage = page.locator('.ss-stage').first();
const box = await stage.boundingBox();
await page.evaluate(() => {
  window.__marks = [];
  new MutationObserver(() => { const m = document.querySelector('[data-mark]'); if (m) window.__marks.push([m.getAttribute('data-mark'), Date.now()]); })
    .observe(document.body, { subtree: true, attributes: true, attributeFilter: ['data-mark'] });
});
const t0 = Date.now();
const frames = [];
let i = 0;
for (;;) {
  const due = t0 + (i * 1000 * SLOW) / FPS;
  const wait = due - Date.now();
  if (wait > 0) await page.waitForTimeout(wait);
  const now = Date.now();
  const file = `${out}/f${String(i).padStart(5, '0')}.jpg`;
  await page.screenshot({ path: file, clip: box, type: 'jpeg', quality: 95 });
  frames.push({ file, t: (now - t0) / 1000 / SLOW });
  i++;
  const firsts = (await page.evaluate(() => window.__marks)).filter((m) => m[0] === 'first');
  if (firsts.length >= 3 && now > firsts[2][1] + 1500) break;
}
const marks = (await page.evaluate(() => window.__marks)).map(([n, t]) => [n, (t - t0) / 1000 / SLOW]);
fs.writeFileSync(`${out}/meta.json`, JSON.stringify({ box: { x: 0, y: 0, w: box.width, h: box.height }, frames, marks }, null, 1));
console.log('frames', frames.length, 'stage seconds', frames.at(-1).t.toFixed(2), 'marks', JSON.stringify(marks.map((m) => [m[0], m[1].toFixed(2)])));
await b.close();
