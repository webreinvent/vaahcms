<script  setup>


// UT-135 - Vue Router hands the route params to every component in the
// matched chain (`props: true` on the route records). A route component
// declares none of them, so Vue's attribute inheritance dropped the param
// on the component's root element - as id="1", id="3", ... - and on the
// screens that render a form or an item in a side panel the same id
// landed on the screen twice. A route component takes nothing from the
// router, so it opts out of the inheritance.
defineOptions({ inheritAttrs: false });
import { onMounted, ref } from 'vue';
import { useRootStore } from "../../stores/root";
import { useDashboardStore } from "../../stores/dashboard";

const root = useRootStore();
const store = useDashboardStore();

onMounted(async () => {
    await store.setTitle();
    await store.getItem();
    root.verifyInstallStatus();
});

const key = ref();

/* UT-103 — the counter icons came from the payload as "pi pi-ban text-red-500":
   the icon *name* is what the view needs, the colour is not — the colour is
   decided below from the count and the semantic type, so a counter that is
   at zero is not painted as a failure. Stripping the colour class here (and
   nowhere else) keeps the payload untouched. */
const counterIcon = (item) => {
    return (item.icon || '')
        .split(' ')
        .filter(c => c && !c.startsWith('text-'))
        .join(' ');
};

</script>

<template>
    <div v-if="store.hasPermission('has-access-of-dashboard')" class="grid dashboard">
        <div class="col-12 md:col-8">
            <Card v-if="store.language_strings">
                <template #content>
                    <h1 class="dash-title" v-html="store.language_strings.greeting"></h1>
                    <!-- UT-28: this paragraph had no class, so it inherited the
                         card's 0.8rem (11.2px) type size — under the 12px
                         readability floor. UT-103: it is now a 13px lead, one
                         step down from the 20px title (design system §6). -->
                    <p class="dash-lead">{{store.language_strings.message}}</p>
                    <div class="grid mt-4">
                        <div class="col-12 md:col-4">
                            <h2 class="dash-heading">{{store.language_strings.get_started}}</h2>
                            <!-- UT-32: the v3 markup wrapped a <Button> in an
                                 <a> (interactive content inside a link) and
                                 carried the inert v3 `is-light` class, so the
                                 card's main action rendered as a solid default
                                 button next to the outlined header buttons.
                                 The v4 Button renders any element through the
                                 `as` prop, so the link IS the button now. -->
                            <Button as="a"
                                    :href="root.base_url + '#/vaah/themes/'"
                                    size="small"
                                    class="vaah-btn-primary"
                                    data-testid="dashboard-goto_theme"
                            >
                                <span v-if="store.dashboard_items
                                            && store.dashboard_items.success
                                            && store.dashboard_items.success.vaahcms
                                            && store.dashboard_items.success.vaahcms.has_activated_theme">
                                     {{store.language_strings.go_to_theme}}
                                </span>
                                    <span v-else>
                                    {{store.language_strings.activate_theme}}
                                </span>
                            </Button>

                            <p class="dash-meta mt-1">
                                {{store.language_strings.or}},
                                <a :href="store.theme_doc_url"
                                   data-testid="dashboard-create_theme"
                                   target="_blank">
                                    {{store.language_strings.create_your_own_theme}}</a>
                            </p>
                        </div>

                        <div class="col-12 md:col-4">
                            <h2 class="dash-heading">{{store.language_strings.next_steps}}</h2>
                            <ul class="links-list">
                                <template v-if="store && store.dashboard_items && store.dashboard_items.success"
                                          v-for="module in store.dashboard_items.success"
                                >
                                    <template v-for="next_step in module.next_steps">
                                        <li>
                                            <a :href="next_step.link"
                                               class="dash-action"
                                               data-testid="dashboard-next_steps_link"
                                               :target="next_step.open_in_new_tab?'_blank':''">
                                                <i class="pi" :class="next_step.icon"></i>
                                                {{ next_step.name }}
                                            </a>
                                        </li>
                                    </template>
                                </template>
                            </ul>
                        </div>

                        <div class="col-12 md:col-4">
                            <h2 class="dash-heading">{{store.language_strings.more_actions}}</h2>
                            <ul class="links-list">
                                <template v-if="store && store.dashboard_items && store.dashboard_items.success"
                                          v-for="module in store.dashboard_items.success"
                                >
                                    <template v-for="action in module.actions">
                                        <li>
                                            <a :href="action.link"
                                               class="dash-action"
                                               :data-testid="'dashboard-'+action.name"
                                               :target="action.open_in_new_tab?'_blank':''">
                                                <i class="pi" :class="action.icon"></i>
                                                {{ action.name }}
                                            </a>
                                        </li>
                                    </template>
                                </template>
                            </ul>
                        </div>

                        <Divider />

                        <template v-if="store && store.dashboard_items && store.dashboard_items.success"
                                  v-for="module in store.dashboard_items.success"
                        >
                            <div class="col-12" v-if="module.card">
                                <h2 class="dash-section">{{ module.card.title }}</h2>

                                <div class="dash-stats">
                                    <template v-for="(item,key) in module.card.list"
                                    >
                                        <div class="dash-stat">
                                            <span class="dash-stat-icon">
                                                <i class="pi" :class="item.icon"></i>
                                            </span>

                                            <p class="dash-stat-label">{{ item.label }}</p>
                                            <div class="dash-stat-count">{{ item.count }}</div>
                                            <a :href="item.link"
                                               :target="item.open_in_new_tab?'_blank':''"
                                               :data-testid="'dashboard-view_'+item.label"
                                               class="dash-stat-link dash-action">
                                                {{ module.card.link_text }}
                                            </a>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>
                </template>
            </Card>
        </div>

        <!-- UT-103 — the status rail was raw markup floating on the canvas:
             two buttons and two accordions with no surface of their own, next
             to a fully surfaced card on the left, and it started 1rem lower
             (the `mt-3`). It is now a card of the same family, aligned to the
             top of the left one, with the two actions in the card's header
             band and the two sections as hairline-separated blocks. -->
        <div class="col-12 md:col-4">
            <Card>
                <template #header>
                    <div class="dash-toolbar">
                        <template v-if="store && store.dashboard_items && store.dashboard_items.success"
                                  v-for="module in store.dashboard_items.success"
                        >
                            <template v-if="module.expanded_header_links"
                                      v-for="h_item in module.expanded_header_links"
                            >
                                <!-- UT-32: same <a><Button></a> nesting, plus three v3
                                     leftovers — the inert `p-button-outlined` class string,
                                     a stray `pi` class and a hard-coded `label="Router"`
                                     that fought the dynamic `:label`. The v4 API is the
                                     `variant` prop and the `as` prop. -->
                                <Button as="a"
                                        :data-testid="'dashboard-'+h_item.name"
                                        :href="h_item.link"
                                        :target="h_item.open_in_new_tab?'_blank':undefined"
                                        :rel="h_item.open_in_new_tab?'noopener':undefined"
                                        size="small"
                                        :label="h_item.name"
                                        :icon="h_item.icon"
                                        variant="outlined"
                                        class="dash-toolbar-btn"
                                />
                            </template>
                        </template>
                    </div>
                </template>
                <template #content>
                    <template v-if="store && store.dashboard_items && store.dashboard_items.success"
                              v-for="(module, index) in store.dashboard_items.success" :key="index"
                    >
                        <template v-if="module.expanded_item"
                                  v-for="(item, index) in module.expanded_item"
                                  :key="index"
                        >
                            <Accordion :multiple="true" :value="store.active_index">
                                <AccordionPanel :value="0"  :key="item.title">
                                    <AccordionHeader>{{ item.title }}
                                    </AccordionHeader>
                                    <AccordionContent>

                                    <template v-if="item.type === 'content'">
                                        <!-- UT-103: the queue is not *broken* — it is
                                             not switched on yet — so the note was
                                             rendered as a hard error (red text on a
                                             salmon field) and dominated the screen.
                                             It is a caution now: `warn` is a valid
                                             OpenVue severity, and the redundant
                                             `icon="null"` (which rendered an empty
                                             span, and with it the indent before the
                                             text) is gone.

                                             UT-112: `severity="warn"` was still the
                                             engine's Message, and the engine fills
                                             that box with its own literal fill — a
                                             solid yellow slab in light, a brown slab
                                             in dark. In this narrow rail it was the
                                             loudest thing on the screen, and it
                                             swallowed the notice's action (the
                                             "View Settings" link sat *inside* the
                                             fill, on its own line, with no
                                             separation from the sentence).
                                             The caution is now the app's own notice
                                             band (`.vc-notice-warn` — the third
                                             member of the info / error family): the
                                             caution token at 8% over the content
                                             background, the same token as the text,
                                             a hairline, and the warning glyph as
                                             the non-colour signal. The action is
                                             the band's own line, under the copy. -->
                                        <div v-if="!item.is_job_enabled"
                                             class="dash-notice vc-notice vc-notice-warn"
                                             data-testid="dashboard-queue-notice"
                                        >
                                            <i class="pi pi-exclamation-triangle vc-notice-icon"
                                               aria-hidden="true"></i>
                                            <div class="dash-notice-body">
                                                <p class="vc-notice-text" v-html="item.run_jobs"></p>
                                                <a :href="root.base_url+'#/vaah/settings/general'"
                                                   class="dash-notice-action"
                                                   data-testid="dashboard-view_setting"
                                                >
                                                    {{ item.view_settings }}
                                                    <i class="pi pi-arrow-right dash-notice-action-icon"
                                                       aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <p class="dash-description">
                                            {{ item.description }}
                                        </p>

                                        <Divider />

                                        <!-- UT-103: the row spread its two items with
                                             `justify-content-evenly` and drew a vertical
                                             divider after *every* item — so the row
                                             ended on a stray separator, and the two
                                             counters floated apart from the text above
                                             them. The counters are now a compact
                                             two-up row of chips, and the separator is
                                             drawn between them only. -->
                                        <div class="dash-counters">
                                            <template v-for="f_item in item.footer">
                                                <a :href="f_item.link"
                                                   class="dash-counter"
                                                   :class="{'dash-counter-alert': f_item.type === 'danger' && f_item.count > 0}"
                                                   :data-testid="'dashboard-view_'+f_item.name"
                                                >
                                                    <span class="dash-counter-icon">
                                                        <i :class="counterIcon(f_item)"></i>
                                                    </span>
                                                    <span class="dash-counter-count">{{ f_item.count }}</span>
                                                    <span class="dash-counter-name">{{ f_item.name }}</span>
                                                </a>
                                            </template>
                                        </div>
                                    </template>

                                    <template v-if=" item.type === 'list' ">
                                        <template v-for="(log, index) in item.list"
                                                  v-if="item.list.length && index < item.list_limit"
                                        >
                                            <!-- UT-103: the log file names were painted
                                                 red, which read as "these files are
                                                 broken" — they are file names. They
                                                 are in the text colour now, with a
                                                 file glyph, and "View" stays the
                                                 accent action. -->
                                            <div class="dash-log-row">
                                                <a :href="item.link+'view/'+log.name"
                                                   class="dash-log-name"
                                                   :data-testid="'dashboard-view_'+log.name"
                                                >
                                                    <i class="pi pi-file dash-log-icon"></i>
                                                    {{ log.name }}
                                                </a>

                                                <a :href="item.link+'view/'+log.name"
                                                   class="dash-log-view"
                                                   :data-testid="'dashboard-'+log.name+'_view'"
                                                >
                                                    {{item.view_log}}
                                                </a>

                                            </div>
                                        </template>

                                        <template v-if="item.list.length === 0">
                                            <p class="dash-description">
                                                {{ item.empty_response_note }}
                                            </p>
                                        </template>

                                        <template v-if="item.list.length > item.list_limit">
                                            <a :href="item.link"
                                               class="dash-log-all"
                                               :data-testid="'dashboard-'+item.link_text"
                                            >
                                                {{ item.link_text }}
                                            </a>
                                        </template>
                                    </template>

                                    </AccordionContent>
                                </AccordionPanel>
                            </Accordion>
                        </template>
                    </template>
                </template>
            </Card>
        </div>
    </div>
</template>

<style scoped>
ul {
    list-style-type: none;
}

/* UT-98 (M6-T4a Batch 21) — the dashboard's action links were plain text
   links, so their click target was the text box: 15px tall for the list
   links and the card links, 20px for the log rows and the counters. All of
   them are *standalone* links (each one sits on its own line, or in a row
   of its own), so the WCAG 2.2 SC 2.5.8 target-size floor of 24 × 24px
   applies — the inline-link exception does not cover them.

   The links keep their type size and colour; only the target grows. The
   link becomes an inline flex box so the icon and the text stay centred on
   the new line box, which also keeps the "next steps" / "more actions"
   columns aligned with each other. */
.dash-action {
    display: inline-flex;
    align-items: center;
    min-height: 24px;
}

/* ── UT-103 — the dashboard's own type scale (DESIGN-SYSTEM.md §6).
   The page used the generic `text-sm` (12.25px — the caption size) for its
   sub-headings and body copy, and `text-xl` (17.5px — off-scale) for the
   page title. These classes pin the scale: 20 / 16 / 14 / 13. */
.dash-title {
    font-size: 20px;
    line-height: 1.35;
    font-weight: 600;
}

.dash-lead {
    font-size: 13px;
    line-height: 1.5;
    color: var(--p-text-muted-color);
}

.dash-heading {
    font-size: 14px;
    line-height: 1.4;
    font-weight: 600;
    margin-bottom: 8px;
}

.dash-section {
    font-size: 16px;
    line-height: 1.4;
    font-weight: 600;
    margin-bottom: 16px;
}

.dash-meta {
    font-size: 13px;
    line-height: 1.5;
    color: var(--p-text-muted-color);
}

/* UT-126 (UAT sweep) — the "create your own theme" link is an inline <a>
   inside the dash-meta sentence: its hit area was exactly its text box
   (56.5 × 15.5px), below the contract's 24px minimum interactive size —
   the same defect class UT-107 closed on the footer. Symmetric padding on
   the inline element (no display change, so the line box and the
   paragraph's rhythm do not move) grow the target to 25.5px. */
.dash-meta a {
    padding: 5px 2px;
}

/* ── The stat row: a 32px icon disc, a muted label and the count as the
   dominant number (design system §6 — 20px for the display size).

   The four stats used to be a PrimeFlex grid with a `Divider` *between*
   each pair — but the divider was a grid item of its own, so it took a
   share of the row and sat 36px away from both columns, belonging to
   neither. The row is a flex line now and the rule is the cell's own
   left border, so it lands exactly on the column boundary. */
.dash-stats {
    display: flex;
    flex-wrap: wrap;
    margin: 0;
}

.dash-stat {
    flex: 1 1 0;
    min-width: 150px;
    padding: 0 16px;
}

.dash-stat:first-child {
    padding-left: 0;
}

.dash-stat:last-child {
    padding-right: 0;
}

.dash-stat + .dash-stat {
    border-left: 1px solid var(--p-content-border-color);
}

.dash-stat-link {
    font-size: 13px;
}

/* Below the desktop width the four stats no longer fit on one line, so they
   pair up and the column rules are dropped — a rule at the start of a
   wrapped row reads as a mistake. */
@media (max-width: 900px) {
    .dash-stat {
        flex: 1 1 50%;
        padding: 0 0 12px 0;
    }
    .dash-stat + .dash-stat {
        border-left: none;
    }
    .dash-stat:nth-child(2n) {
        padding-left: 16px;
    }
}

.dash-stat-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 9999px;
    background: var(--p-blue-50);
    color: var(--vaah-link);
}

/* Dark scheme (§9): the light-blue disc is a *light* value, so under
   `app-dark` it would read as a bright hole in the card. The disc takes a
   dark surface and the glyph a light blue instead — same pairing, both
   schemes. */
.app-dark .dash-stat-icon {
    background: var(--p-surface-800);
    color: var(--p-blue-300);
}

.app-dark .dash-counter-icon {
    background: var(--p-surface-800);
}

.dash-stat-label {
    font-size: 13px;
    line-height: 1.4;
    color: var(--p-text-muted-color);
    margin-top: 12px;
}

.dash-stat-count {
    font-size: 20px;
    line-height: 1.3;
    font-weight: 600;
    margin: 2px 0 4px;
}

/* ── The status rail (the right-hand card). */
.dash-toolbar {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.dash-toolbar-btn {
    margin-right: 0;
    margin-bottom: 0;
}

/* The accordion headers are the card's section headers: 14px/600, and the
   toggle glyph in the muted tone. The rule that separates the two sections
   is drawn *above* the second header, not under every header — a rule under
   the title reads as an underline of the title itself. */
:deep(.p-accordion) {
    margin: 0;
}

:deep(.p-accordion + .p-accordion) {
    border-top: 1px solid var(--p-content-border-color);
    margin-top: 4px;
    padding-top: 4px;
}

:deep(.p-accordionheader) {
    font-size: 14px;
    font-weight: 600;
    color: var(--p-text-color);
    padding: 8px 0;
    background: transparent;
    transition: background-color 150ms ease-out;
}

:deep(.p-accordionheader:hover) {
    background: var(--p-content-hover-background);
}

:deep(.p-accordionheader .p-accordionheader-toggle-icon) {
    width: 12px;
    height: 12px;
    color: var(--p-text-muted-color);
}

:deep(.p-accordioncontent-content) {
    padding-bottom: 4px;
}

/* ── UT-112 — the queue caution. The band itself is the app's notice band
   (`.vc-notice-warn`, in the token layer): the caution token at 8% over the
   content background, the same token as the text, a hairline. These rules
   only give the band its *shape* — the glyph, the copy and the action.

   The glyph is the non-colour signal (reference-ui-conformance.md §3): it
   says "caution" in greyscale too. It is aligned to the first line of the
   copy, not to the top of the band. */
.dash-notice {
    margin-bottom: 12px;
}

.dash-notice-body {
    min-width: 0;
}

/* The action is the band's own line, under the copy — the sentence and the
   link are two things, and the link is the only way out of the note. It
   keeps the link token (the global anchor colour) and the 24px target the
   rest of the dashboard's standalone links use. */
.dash-notice-action {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    min-height: 24px;
    margin-top: 4px;
    font-size: 13px;
    color: var(--vaah-link);
}

.dash-notice-action:hover {
    text-decoration: underline;
}

.dash-notice-action-icon {
    font-size: 11px;
}

/* The explanation is muted body copy on a measured line — the rail is a
   narrow column, so the copy is set at 13px with a 62ch measure rather
   than running the full width of the column. */
.dash-description {
    font-size: 13px;
    line-height: 1.6;
    color: var(--p-text-muted-color);
    max-width: 62ch;
}

/* ── The two counters: a compact two-up row of chips. The icon sits in a
   muted disc so the row reads as a set; the number is the dominant part.
   A counter that is *failing* (a non-zero danger count) takes the danger
   tone, and only then. */
.dash-counters {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.dash-counter {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    min-height: 32px;
    padding: 4px 12px 4px 6px;
    border: 1px solid var(--p-content-border-color);
    border-radius: 6px;
    font-size: 13px;
    text-decoration: none;
    transition: background-color 150ms ease-out;
}

.dash-counter:hover {
    background: var(--p-content-hover-background);
}

.dash-counter-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 22px;
    height: 22px;
    border-radius: 9999px;
    background: var(--p-surface-100);
    color: var(--p-text-muted-color);
    font-size: 11px;
}

.dash-counter-count {
    font-weight: 600;
    color: var(--p-text-color);
}

.dash-counter-name {
    color: var(--p-text-muted-color);
}

.dash-counter-alert .dash-counter-icon {
    background: var(--p-red-100);
    color: var(--vaah-danger-text);
}

.dash-counter-alert .dash-counter-count {
    color: var(--vaah-danger-text);
}

/* ── The log rows: the file name is the row's subject (in the text colour,
   with a file glyph), "View" is the action on the right. */
.dash-log-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    min-height: 32px;
    border-bottom: 1px solid var(--p-content-border-color);
}

.dash-log-row:last-of-type {
    border-bottom: none;
}

.dash-log-name {
    display: inline-flex;
    align-items: center;
    min-height: 24px;
    font-size: 13px;
    color: var(--p-text-color);
    text-decoration: none;
}

.dash-log-name:hover {
    color: var(--p-primary-color);
    text-decoration: underline;
}

.dash-log-icon {
    margin-right: 8px;
    font-size: 12px;
    color: var(--p-text-muted-color);
}

.dash-log-view {
    display: inline-flex;
    align-items: center;
    min-height: 24px;
    font-size: 13px;
}

.dash-log-all {
    display: flex;
    justify-content: center;
    min-height: 24px;
    margin-top: 8px;
    font-size: 13px;
}
</style>
