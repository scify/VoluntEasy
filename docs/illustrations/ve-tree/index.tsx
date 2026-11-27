import { Bar, Stage, Text, Window } from '../../kit'
import { Users } from 'lucide-react'
import './tree.css'

const LANG = new URLSearchParams(window.location.search).get('lang') === 'el' ? 'el' : 'en'
const T = {
  en: { root: 'Athens volunteers', units: ['Food bank', 'Beach clean-up', 'Hospital visits'], count: '12 volunteers' },
  el: { root: 'Εθελοντές Αθήνας', units: ['Τράπεζα τροφίμων', 'Καθαρισμός παραλίας', 'Νοσοκομεία'], count: '12 εθελοντές' },
}[LANG]

// Feature card (pinned, bottom bleed): the organisation as a tree of units.
// Real words: the root, three units, and the volunteer count of the focal one.
const BRANCHES = [
  { name: T.units[0], leaves: [40, 34] },
  { name: T.units[1], focal: true, leaves: [36, 44] },
  { name: T.units[2], leaves: [42] },
]

export default function VeTree() {
  return (
    <Stage width={560} height={300} compact={{ below: 560, width: 358, height: 340 }} className="ve-tree">
      {() => (
        <Window url="volunteasy.example.org/units" className="vt-window">
          <div className="vt-chart">
            <div className="vt-node vt-root"><Text className="vt-name">{T.root}</Text></div>
            <div className="vt-down" />
            <div className="vt-branches">
              {BRANCHES.map((branch) => (
                <div key={branch.name} className="vt-branch">
                  <div className="vt-up" />
                  <div className="vt-node" data-focal={branch.focal || undefined}>
                    <Text className="vt-name">{branch.name}</Text>
                    {branch.focal && (
                      <span className="vt-meta"><Users size={13} strokeWidth={2} /><Text className="vt-meta-text">{T.count}</Text></span>
                    )}
                  </div>
                  <div className="vt-down" />
                  <div className="vt-leaves">
                    {branch.leaves.map((w, i) => (
                      <div key={i} className="vt-leaf"><Bar w={w} h={6} tone={3} /></div>
                    ))}
                  </div>
                </div>
              ))}
            </div>
          </div>
        </Window>
      )}
    </Stage>
  )
}
