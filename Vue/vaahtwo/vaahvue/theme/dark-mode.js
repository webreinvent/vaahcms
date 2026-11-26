// M3-T1 (F09) — dark mode (R4.5/R4.6).
//
// The scheme is driven by the `app-dark` class on <html>
// (document.documentElement) ONLY — theme.options.darkModeSelector is
// '.app-dark', so OpenVue's dark variables are generated under
// `:root.app-dark` / `:root .app-dark`. <body> is never touched: its class
// list belongs to the application (has-sidebar-small from
// config('settings.global.is_sidebar_collapsed') + $data->body_class).
// usePreset is NOT the scheme switch — it replaces the whole preset and
// stays reserved for that.
//
// Preference semantics: 'light' and 'dark' always win over the OS;
// 'system' defers to prefers-color-scheme (seeded and re-applied on change).
// The SOURCE OF TRUTH is the per-user row in vh_settings
// (category='user_setting', key='dark_mode', vh_user_id) written through
// POST /backend/json/dark-mode and read from the GET /backend/json/assets
// bootstrap payload. The localStorage entry below is a PRE-PAINT CACHE
// only — the last resolved scheme — never the source of truth, and this
// file is the only localStorage usage in the SPA (feature verification:
// `grep -rn "localStorage" packages/vaahcms/Vue/vaahtwo`).

export const DARK_MODE_CLASS = 'app-dark'

// localStorage key holding the last RESOLVED scheme ('dark'|'light') — a
// cache for the pre-paint script in the Blade head, not the preference itself.
export const DARK_MODE_CACHE_KEY = 'vaah.dark-mode'

const PREFERENCES = ['light', 'dark', 'system']

export function normalizePreference(value) {
    return PREFERENCES.includes(value) ? value : null
}

function systemPrefersDark() {
    try {
        return window.matchMedia('(prefers-color-scheme: dark)').matches
    } catch (e) {
        return false
    }
}

function readCache() {
    try {
        return window.localStorage.getItem(DARK_MODE_CACHE_KEY)
    } catch (e) {
        return null
    }
}

function writeCache(resolved) {
    try {
        window.localStorage.setItem(DARK_MODE_CACHE_KEY, resolved)
    } catch (e) {
        // storage unavailable (private mode etc.) — the cache is optional
    }
}

/**
 * Resolve a stored preference ('light'|'dark'|'system') to a boolean.
 * 'system' prefers the cached resolved scheme (pre-paint continuity), then
 * the OS preference.
 */
export function resolveDark(preference) {
    if (preference === 'dark') return true
    if (preference === 'light') return false
    const cached = readCache()
    if (cached === 'dark' || cached === 'light') return cached === 'dark'
    return systemPrefersDark()
}

/**
 * Apply (or remove) the dark class on the document root only.
 */
export function applyDark(dark) {
    document.documentElement.classList.toggle(DARK_MODE_CLASS, Boolean(dark))
}

/**
 * Apply a stored preference to the document and keep the pre-paint cache
 * current. Returns { preference, dark }.
 */
export function applyPreference(preference) {
    const normalized = normalizePreference(preference) || 'system'
    const dark = resolveDark(normalized)
    applyDark(dark)
    writeCache(dark ? 'dark' : 'light')
    return { preference: normalized, dark }
}

let systemWatcher = null

function stopSystemWatcher() {
    if (!systemWatcher) return
    const { media, onChange } = systemWatcher
    systemWatcher = null
    if (media.addEventListener) {
        media.removeEventListener('change', onChange)
    } else if (media.removeListener) {
        media.removeListener(onChange)
    }
}

/**
 * While the stored preference is 'system', follow OS changes live. An
 * explicit light/dark choice stops deferring — the OS must never fight a
 * saved choice.
 */
export function watchSystemPreference(preference) {
    stopSystemWatcher()
    if (normalizePreference(preference) !== 'system') return
    let media
    try {
        media = window.matchMedia('(prefers-color-scheme: dark)')
    } catch (e) {
        return
    }
    const onChange = (event) => {
        // still on 'system'? (setPreference updates this before re-watching)
        if (normalizePreference(currentPreference) === 'system') {
            applyDark(Boolean(event.matches))
            writeCache(event.matches ? 'dark' : 'light')
        }
    }
    if (media.addEventListener) {
        media.addEventListener('change', onChange)
    } else if (media.addListener) {
        media.addListener(onChange)
    }
    systemWatcher = { media, onChange }
}

/**
 * Entry point after the assets bootstrap payload has landed
 * (root store afterGetAssets): applies the server-stored preference and
 * arms the system watcher when the preference is 'system'.
 */
export function initDarkMode(assets) {
    const preference =
        (assets && assets.theme && normalizePreference(assets.theme.dark_mode)) || 'system'
    applyPreference(preference)
    watchSystemPreference(preference)
    return preference
}

// The live preference for the running app (kept in sync by the root store
// when the user toggles — the OS watcher consults it).
export let currentPreference = 'system'

export function setCurrentPreference(preference) {
    currentPreference = normalizePreference(preference) || 'system'
}
