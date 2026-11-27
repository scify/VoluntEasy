import json, subprocess, sys, os
rec, out, name = sys.argv[1], sys.argv[2], sys.argv[3]
m = json.load(open(f"{rec}/meta.json"))
firsts = [t for n, t in m['marks'] if n == 'first']
start, end = firsts[1] - 0.6, firsts[2] - 0.6
loop = end - start
frames = m['frames']
# the frame on screen at each moment: concat list with each frame's duration
sel = []
for i, f in enumerate(frames):
    nxt = frames[i + 1]['t'] if i + 1 < len(frames) else f['t'] + 0.05
    if nxt <= start or f['t'] >= end: continue
    a, b = max(f['t'], start), min(nxt, end)
    sel.append((f['file'], b - a))
lst = f"{rec}/list.txt"
with open(lst, 'w') as fh:
    for file, d in sel: fh.write(f"file '{file}'\nduration {d:.4f}\n")
    fh.write(f"file '{sel[-1][0]}'\n")
b = m['box']; crop = f"crop={int(b['w']*2)}:{int(b['h']*2)}:{int(b['x']*2)}:{int(b['y']*2)}"
base = f"{out}/{name}"
run = lambda args: subprocess.run(['ffmpeg', '-y', '-loglevel', 'error'] + args, check=True)
inp = ['-f', 'concat', '-safe', '0', '-i', lst]
run(inp + ['-vf', f"{crop},fps=30,format=yuv420p", '-c:v', 'libx264', '-crf', '20', '-preset', 'slow', '-movflags', '+faststart', '-an', f"{base}.mp4"])
run(inp + ['-vf', f"{crop},fps=30", '-c:v', 'libvpx-vp9', '-crf', '32', '-b:v', '0', '-row-mt', '1', '-an', f"{base}.webm"])
# poster: the payoff frame of the first scene (count rolled, chip active), about 4.5 s into the loop
run(['-ss', '4.6', '-i', f"{base}.mp4", '-frames:v', '1', '-q:v', '2', f"{base}-poster.jpg"])
print(f"{name}: loop {loop:.2f}s, {len(sel)} frames")
