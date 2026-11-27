import { Bar, Stage, Text, Window, Row, Avatar, Badge, Button } from '../../kit'
import { Users, Network, Target, ChartColumn, Handshake, House } from 'lucide-react'
import './hero.css'

// Hero beside copy (corner bleed): the VoluntEasy volunteers list runs off the
// right and bottom; a volunteer card straddles the window's left edge over the
// dark sidebar. Real words: the title, three volunteers with their unit status,
// and the card's one number.

const ROWS = [
  { name: 'Maria Ioannou', unit: 'Athens branch', status: 'Available', tone: 'success' as const, selected: true },
  { name: 'Nikos Karras', unit: 'Food bank', status: 'Pending', tone: 'warning' as const },
  { name: 'Eleni Georgiou', unit: 'Beach clean-up', status: 'Active', tone: 'accent' as const },
  { bar: 92 },
  { bar: 70 },
  { bar: 84 },
]
const NAV = [House, Network, Target, Handshake, Users, ChartColumn]

export default function VeHero() {
  return (
    <Stage width={720} height={400} compact={{ below: 560, width: 358, height: 340 }} className="ve-hero" fidelity="standard">
      {() => (
        <>
          <Window url="volunteasy.example.org/volunteers" className="ve-window">
            <aside className="ve-sidebar">
              {NAV.map((Glyph, i) => (
                <span key={i} className="ve-nav" data-on={i === 4 || undefined}>
                  <Glyph size={16} strokeWidth={1.75} />
                </span>
              ))}
            </aside>
            <div className="ve-main">
              <div className="ve-header">
                <Text className="ve-title">Volunteers</Text>
                <Button variant="primary" size="small" className="ve-new">New volunteer</Button>
              </div>
              <div className="ve-filters">
                <Bar w={96} h={24} r={6} tone={1} />
                <Bar w={72} h={24} r={6} tone={1} />
                <Bar w={84} h={24} r={6} tone={1} />
              </div>
              <div className="ve-list">
                {ROWS.map((row, i) =>
                  'name' in row ? (
                    <Row key={i} pad={0} selected={row.selected} className="ve-row"
                      lead={<Avatar name={row.name} size={22} tone={row.selected ? 'accent' : 'person'} />}
                      title={<Text className="ve-name">{row.name}</Text>}>
                      <Badge tone={row.tone} className="ve-badge">{row.status}</Badge>
                    </Row>
                  ) : (
                    <Row key={i} pad={0} className="ve-row" lead={<Bar w={22} h={22} r={11} tone={2} />} title={<Bar w={row.bar} tone={3} />}>
                      <Bar w={58} h={18} r={9} tone={1} />
                    </Row>
                  ),
                )}
              </div>
            </div>
          </Window>

          <div className="ve-card">
            <div className="ve-card-head">
              <Avatar name="Maria Ioannou" tone="accent" size={32} />
              <div className="ve-card-who">
                <Text className="ve-card-name">Maria Ioannou</Text>
                <Badge tone="success">Available</Badge>
              </div>
            </div>
            <div className="ve-card-stat">
              <Text className="ve-card-number">46 h</Text>
              <Text className="ve-card-label">in 7 actions</Text>
            </div>
            <div className="ve-card-rows">
              <Bar w={120} h={5} tone={3} />
              <Bar w={92} h={5} tone={2} />
            </div>
          </div>
        </>
      )}
    </Stage>
  )
}
