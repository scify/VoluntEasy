import { Avatar, Bar, Count, Facepile, Menu, Popover, Roll, Stage, Text, Window, type Act } from '../../kit'
import { Clock, Plus } from 'lucide-react'
import './lifecycle.css'

// Animated hero: a coordinator staffs a shift. On an action's task board the
// cursor opens "+" on a shift, picks an available volunteer, the shift count
// rolls up and, in the volunteer list beside it, the volunteer turns from
// Available to Active (what VoluntEasy does when it assigns a volunteer).
// Two actions take turns, so the loop never rewinds data in view: the hidden
// scene resets while the other one plays.

const LANG = new URLSearchParams(window.location.search).get('lang') === 'el' ? 'el' : 'en'

type SceneText = { action: string; card: string; shift: string; need: number; had: number; team: string[]; pick: string; others: [string, string] }

const T = {
  en: {
    of: 'of',
    list: 'Volunteers',
    available: 'Available',
    pending: 'Pending',
    active: 'Active',
    pickTitle: 'Available volunteers',
    scenes: [
      { action: 'Beach clean-up', card: 'Litter pick-up, Schinias beach', shift: 'Sat 09:00–13:00', need: 8, had: 6,
        team: ['Nikos Karras', 'Eleni Georgiou', 'Kostas Lazarou'], pick: 'Maria Ioannou', others: ['Anna Pappa', 'Eleni Georgiou'] },
      { action: 'Food bank', card: 'Sort donations at the warehouse', shift: 'Wed 17:00–20:00', need: 5, had: 3,
        team: ['Sofia Raptis', 'Yannis Vlachos', 'Dimitra Kosta'], pick: 'Petros Dimou', others: ['Irini Sava', 'Sofia Raptis'] },
    ] as SceneText[],
  },
  el: {
    of: 'από',
    list: 'Εθελοντές',
    available: 'Διαθέσιμος',
    pending: 'Υπό ένταξη',
    active: 'Ενεργός',
    pickTitle: 'Διαθέσιμοι εθελοντές',
    scenes: [
      { action: 'Καθαρισμός παραλίας', card: 'Συλλογή απορριμμάτων, παραλία Σχινιά', shift: 'Σάβ 09:00–13:00', need: 8, had: 6,
        team: ['Νίκος Καρράς', 'Ελένη Γεωργίου', 'Κώστας Λαζάρου'], pick: 'Μάριος Ιωάννου', others: ['Άννα Παππά', 'Ελένη Γεωργίου'] },
      { action: 'Τράπεζα τροφίμων', card: 'Διαλογή δωρεών στην αποθήκη', shift: 'Τετ 17:00–20:00', need: 5, had: 3,
        team: ['Σοφία Ράπτη', 'Γιάννης Βλάχος', 'Δήμητρα Κώστα'], pick: 'Πέτρος Δήμου', others: ['Ειρήνη Σάββα', 'Σοφία Ράπτη'] },
    ] as SceneText[],
  },
}[LANG]

type S = {
  scene: 0 | 1
  menu: boolean
  hover: number | undefined
  joined: [boolean, boolean]
  active: [boolean, boolean]
}

const START: S = { scene: 0, menu: false, hover: undefined, joined: [false, false], active: [false, false] }
// The poster tells the story on its own: the volunteer has joined the shift and is active
const POSTER: S = { ...START, joined: [true, false], active: [true, false] }

/** The menu opens upward from "+": its fixed height (lifecycle.css) */
const MENU_HEIGHT = 108

const pair = <V,>(p: [V, V], i: number, v: V): [V, V] => (i === 0 ? [v, p[1]] : [p[0], v])

async function staff(a: Act<S>, sc: 0 | 1) {
  await a.move(`add-${sc}`)
  await a.wait(150)
  await a.click()
  await a.set({ menu: true, hover: undefined })
  await a.wait(450)
  await a.move(`pick-${sc}`)
  await a.set({ hover: 0 })
  await a.wait(250)
  await a.click()
  // the face joins the shift and the count rolls as the menu closes
  await a.set((s) => ({ joined: pair(s.joined, sc, true) }))
  await a.set({ menu: false })
  // the consequence elsewhere: the volunteer is now active
  await a.wait(550)
  await a.set((s) => ({ active: pair(s.active, sc, true) }))
  // the cursor clears the way to rest on empty board
  a.move('rest')
  await a.wait(2400)
}

async function script(a: Act<S>) {
  await a.wait(900)
  a.mark('first')
  await staff(a, 0)
  // the coordinator moves on to another action
  await a.set({ scene: 1 })
  await a.wait(350)
  // the first action resets while it is out of sight
  await a.snap((s) => ({ joined: pair(s.joined, 0, false), active: pair(s.active, 0, false) }))
  await a.wait(500)
  a.mark('second')
  await staff(a, 1)
  await a.set({ scene: 0 })
  await a.wait(350)
  await a.snap((s) => ({ joined: pair(s.joined, 1, false), active: pair(s.active, 1, false), hover: undefined }))
  await a.wait(300)
}

function Board({ sc, s }: { sc: 0 | 1; s: S }) {
  const t = T.scenes[sc]
  const joined = s.joined[sc]
  return (
    <div className="vl-scene" data-on={s.scene === sc || undefined} aria-hidden={s.scene !== sc || undefined}>
      <div className="vl-head">
        <Text className="vl-title">{t.action}</Text>
        <span className="vl-chip">Task Board</span>
      </div>
      <div className="vl-columns">
        <div className="vl-column">
          <Text className="vl-column-title">To Do</Text>
          {[[84, 52], [66, 40], [78, 46]].map(([w1, w2], i) => (
            <div key={i} className="vl-card"><Bar w={w1} h={6} tone={3} /><Bar w={w2} h={5} tone={2} /></div>
          ))}
        </div>
        <div className="vl-column">
          <Text className="vl-column-title">Doing</Text>
          <div className="vl-card vl-card-focal">
            <Text wrap className="vl-card-title">{t.card}</Text>
            <div className="vl-shift">
              <span className="vl-when"><Clock size={13} strokeWidth={2} /><Text className="vl-when-text">{t.shift}</Text></span>
              <div className="vl-staff">
                <span className="vl-faces">
                  <Facepile names={t.team} size={22} />
                  <span className="vl-new" data-in={joined || undefined}>
                    <Avatar name={t.pick} tone="accent" size={22} />
                  </span>
                </span>
                <span className="vl-count">
                  <Count value={t.had + (joined ? 1 : 0)} duration={600} />
                  <span className="vl-of">{T.of} {t.need}</span>
                </span>
                <button className="vl-add" data-target={`add-${sc}`} data-open={(s.menu && s.scene === sc) || undefined} aria-label="Add volunteer">
                  <Plus size={14} strokeWidth={2.25} />
                </button>
              </div>
            </div>
          </div>
          <div className="vl-card"><Bar w={70} h={6} tone={3} /><Bar w={44} h={5} tone={2} /></div>
        </div>
        <div className="vl-column">
          <Text className="vl-column-title">Done</Text>
          {[[72, 50], [88, 38], [64, 46]].map(([w1, w2], i) => (
            <div key={i} className="vl-card"><Bar w={w1} h={6} tone={3} /><Bar w={w2} h={5} tone={2} /></div>
          ))}
        </div>
      </div>
    </div>
  )
}

function Status({ active, available }: { active: boolean; available?: boolean }) {
  const state = active ? 'active' : available ? 'available' : 'pending'
  return (
    <span className="vl-status" data-status={state}>
      <Roll variant="fade">{state === 'active' ? T.active : state === 'available' ? T.available : T.pending}</Roll>
    </span>
  )
}

function People({ sc, s }: { sc: 0 | 1; s: S }) {
  const t = T.scenes[sc]
  return (
    <div className="vl-people-scene" data-on={s.scene === sc || undefined} aria-hidden={s.scene !== sc || undefined}>
      <div className="vl-person" data-focal>
        <Avatar name={t.pick} tone="accent" size={24} />
        <Text className="vl-person-name">{t.pick}</Text>
        <Status active={s.active[sc]} available />
      </div>
      <div className="vl-person">
        <Avatar name={t.others[0]} size={24} />
        <Text className="vl-person-name">{t.others[0]}</Text>
        <Status active={false} />
      </div>
      <div className="vl-person">
        <Avatar name={t.others[1]} size={24} />
        <Text className="vl-person-name">{t.others[1]}</Text>
        <Status active />
      </div>
      {/* filler row cut by the bottom edge: the list runs on */}
      <div className="vl-person">
        <Bar w={24} h={24} r={12} tone={2} />
        <Bar w={96} h={6} tone={3} />
      </div>
    </div>
  )
}

export default function VeLifecycle() {
  return (
    <Stage<S>
      width={720}
      height={400}
      initial={START}
      poster={POSTER}
      script={script}
      cursor={{ at: 'rest', ripple: true }}
      className="ve-lifecycle"
    >
      {(s, rect) => {
        const add = rect(`add-${s.scene}`)
        const t = T.scenes[s.scene]
        return (
          <>
            <Window url="volunteasy.example.org/actions/12" className="vl-window">
              <div className="vl-scenes">
                <Board sc={0} s={s} />
                <Board sc={1} s={s} />
              </div>
            </Window>

            <div className="vl-people">
              <Text className="vl-people-title">{T.list}</Text>
              <div className="vl-people-scenes">
                <People sc={0} s={s} />
                <People sc={1} s={s} />
              </div>
            </div>

            {/* where the cursor rests between beats: empty board on the right */}
            <span className="vl-rest" data-target="rest" />

            <Popover show={s.menu} origin="bottom right" className="vl-menu" style={add ? { left: add.x + add.width - 220, top: add.y - MENU_HEIGHT - 6 } : undefined}>
              <Text className="vl-menu-title">{T.pickTitle}</Text>
              <Menu
                value={s.hover}
                targets={[`pick-${s.scene}`, undefined]}
                items={[
                  <span key="p" className="vl-menu-item"><Avatar name={t.pick} tone="accent" size={20} /><Text className="vl-menu-name">{t.pick}</Text></span>,
                  <span key="f" className="vl-menu-item"><Bar w={20} h={20} r={10} tone={2} /><Bar w={92} h={6} tone={3} /></span>,
                ]}
              />
            </Popover>
          </>
        )
      }}
    </Stage>
  )
}
