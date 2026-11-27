import { Bar, Stage, Text, Window, Facepile, Badge } from '../../kit'
import { Clock } from 'lucide-react'
import './board.css'

// Feature card (pinned, bottom bleed): an action's task board with three
// columns. One focal subtask in "Doing" carries the real words: what, when,
// and how many volunteers of the shift are filled. Other cards are filler.

const COLUMNS = [
  { title: 'To do', count: 3, cards: [[88, 54], [70, 40], [80, 48]] },
  { title: 'Doing', count: 2, focal: true, cards: [[76, 44]] },
  { title: 'Done', count: 4, cards: [[64, 50], [84, 36], [72, 46]] },
]
const TEAM = ['Maria Ioannou', 'Nikos Karras', 'Eleni Georgiou']

export default function VeBoard() {
  return (
    <Stage width={560} height={300} compact={{ below: 560, width: 358, height: 340 }} className="ve-board">
      {() => (
        <Window url="volunteasy.example.org/actions/12" className="vb-window">
          <div className="vb-head">
            <Text className="vb-title">Beach clean-up</Text>
            <Badge tone="success">Task board</Badge>
          </div>
          <div className="vb-columns">
            {COLUMNS.map((column) => (
              <div key={column.title} className="vb-column" data-focal={column.focal || undefined}>
                <div className="vb-column-head">
                  <Text className="vb-column-title">{column.title}</Text>
                  <Text className="vb-count">{String(column.count)}</Text>
                </div>
                {column.focal && (
                  <div className="vb-card vb-card-focal">
                    <Text wrap className="vb-card-title">Litter pick-up, Schinias beach</Text>
                    <span className="vb-shift"><Clock size={13} strokeWidth={2} /><Text className="vb-shift-text">Sat 09:00–13:00</Text></span>
                    <div className="vb-card-foot">
                      <Facepile names={TEAM} size={20} />
                      <Text className="vb-filled">6 of 8</Text>
                    </div>
                  </div>
                )}
                {column.cards.map(([a, b], i) => (
                  <div key={i} className="vb-card">
                    <Bar w={a} h={6} tone={3} />
                    <Bar w={b} h={5} tone={2} />
                  </div>
                ))}
              </div>
            ))}
          </div>
        </Window>
      )}
    </Stage>
  )
}
