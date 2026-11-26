<script setup>
import {vaah} from '../../pinia/vaah.js'

const props = defineProps({
    label: {
        type: String,
        default: null
    },
    label_width: {
        type: String,
        default: '150px'
    },
    value:{
        default: null,
    },
    type: {
        type: String,
        default: 'text'
    },
    can_copy:{
        type: Boolean,
        default: false
    },
    /**
     * M6-T1 — the severity the "No" tag wears in the `yes-no` type.
     *
     * The severity is a prop so a screen can state what is true: a flag
     * whose *absence* is the problem (a deleted record) is `danger`, while
     * a flag that merely answers a question ("Is downloadable: No",
     * "Download requires login: No") is not a failure at all.
     *
     * M6-T5 resolved the default for every flag that is a *state*:
     * `is_active`, `is_migratable`, `is_default`, `is_update_available`,
     * `is_assets_published`, `is_sample_data_available`. Those are the
     * "not switched on yet" case, which
     * reference-ui-conformance.md §2 calls a **caution, not an error** —
     * so they wear `warn`. The `danger` red the shared renderer used to
     * paint on every "No" claimed a failure that had not happened (the
     * colour-is-a-signal rule).
     *
     * M6-T1 had shipped `danger` as the default on the parity argument
     * ("the long-standing behaviour"). Every call site in the app is a
     * state flag or an answer, so that argument does not apply to any of
     * them: there is no deleted-record or revoked-permission row that
     * reads through this component. The default is therefore `warn`, and
     * the peer screens all render the same flag the same way.
     */
    no_severity:{
        type: String,
        default: 'warn'
    }
})

//['label', 'value', 'type']

</script>
<template>
    <tr>
        <td :style="{width: label_width}"><b>{{vaah().toLabel(label)}}</b></td>
        <template v-if="can_copy">
            <td>{{value}}</td>
            <td style="width: 40px;">
                <Button aria-label="Copy" icon="pi pi-copy" @click="vaah().copy(value)" class=" p-button-text"></Button>
            </td>
        </template>
        <template v-else-if="type==='user'">
            <td colspan="2" >

                <template v-if="typeof value === 'object' && value !== null">
                    <Button size="small" @click="vaah().copy(value.id)" class="p-button-outlined p-button-secondary">
                        {{value.name}}
                    </Button>
                </template>

            </td>
        </template>
        <template v-else-if="type==='yes-no'">
            <td colspan="2">
                <!-- M6-T5 — these rows are *states* (`is_active`,
                     `is_migratable`, `is_default`, `is_update_available`,
                     `is_sample_data_available`), never a failed operation.
                     reference-ui-conformance.md §2: "not switched on yet"
                     is a caution, not an error — so the "No" badge wears
                     `warn`, the same tone the peer screens' inactive
                     buttons now wear. The destructive trash buttons keep
                     `danger`: a delete really is a failure waiting to
                     happen. -->
                <Tag value="Yes" v-if="value===1" severity="success"></Tag>
                <Tag v-else value="No" :severity="no_severity"></Tag>
            </td>
        </template>
        <template v-else-if="type==='tag'">
            <td colspan="2">
                <!-- UT-96 (M6-T4a Batch 20) — an empty value used to render an
                     *outlined button with no label*: a 16 × 9px, unnamed
                     control (SC 2.5.8 target size + SC 4.1.2 name). The item
                     views now fall back to the app's muted em dash, the same
                     empty marker the list tables use. -->
                <Button v-if="value !== null && value !== undefined && value !== ''" :label="value" outlined />
                <span v-else class="vaah-empty-value">—</span>
            </td>
        </template>
        <template v-else>
            <td  colspan="2">
            {{value}}
            </td>
        </template>

    </tr>
</template>
