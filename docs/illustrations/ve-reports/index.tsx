import { Stage, Text, Window, Chart, Bar } from '../../kit'
import './reports.css'

// Feature card (pinned, bottom bleed): the reports page. One big number, the
// monthly chart under it, filler for the other report tiles.
const MONTHS = [6, 9, 7, 12, 15, 11, 18, 22, 14, 19, 24, 21]

export default function VeReports() {
  return (
    <Stage width={560} height={300} compact={{ below: 560, width: 358, height: 340 }} className="ve-reports">
      {() => (
        <Window url="volunteasy.example.org/reports" className="vr-window">
          <div className="vr-grid">
            <div className="vr-card vr-main">
              <Text className="vr-label">New volunteers this year</Text>
              <Text className="vr-number">188</Text>
              <Chart kind="bars" data={MONTHS} width={240} height={96} className="vr-chart" />
            </div>
            <div className="vr-side">
              <div className="vr-card vr-small">
                <Text className="vr-label">Hours by action</Text>
                <Bar w={96} h={6} tone={3} />
                <Bar w={72} h={6} tone={2} />
                <Bar w={84} h={6} tone={2} />
              </div>
              <div className="vr-card vr-small">
                <Bar w={70} h={6} tone={3} />
                <Bar w={52} h={6} tone={2} />
              </div>
            </div>
          </div>
        </Window>
      )}
    </Stage>
  )
}
