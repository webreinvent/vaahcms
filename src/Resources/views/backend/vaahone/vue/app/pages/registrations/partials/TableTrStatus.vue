<script src="./TableTrStatusJs.js"></script>
<template>

    <tr>
        <th align="right">{{$vaah.toLabel(label)}}</th>
        <td>

            <b-field grouped>
                <div class="control">
                    <b-taglist attached>
                        <b-tag>{{value}}</b-tag>
                        <b-tag>
                            <b-dropdown aria-role="list" position="is-bottom-left">

                                <button class="button" slot="trigger">
                                    <b-icon icon="caret-down"></b-icon>
                                </button>

                                <b-dropdown-item aria-role="listitem"
                                                 v-for="status in page.assets.registration_statuses"
                                                 @click="changeStatus(status.slug)"
                                                 :key="status.slug">
                                    {{status.name}}
                                </b-dropdown-item>

                            </b-dropdown>
                        </b-tag>
                        <b-tag type="is-info">
                            <b-button @click="sendVerificationMail">Resend Verification Email</b-button>
                        </b-tag>

                    </b-taglist>



                </div>

            </b-field>

        </td>
        <td width="20"></td>
    </tr>

</template>
