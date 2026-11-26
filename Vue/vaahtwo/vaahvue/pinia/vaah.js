import {defineStore, acceptHMRUpdate} from 'pinia'
import axios from 'axios'
import qs from "qs";
import TimeAgo from 'javascript-time-ago'
import en from 'javascript-time-ago/locale/en'

TimeAgo.addDefaultLocale(en)

export const vaah = defineStore({
    id: 'vaah',
    state: () => ({
        toast: null,
        confirm: null,
        show_progress_bar: false,
    }),
    getters: {},
    actions: {
        ajax: async function (
            url,
            callback = null,
            options= {
                params: null,
                method: 'get',
                query: null,
                headers: null,
                show_success: true,
                callback_params: null,
            }
        ) {

            let self = this;
            let default_option = {
                params: null,
                method: 'get',
                query: null,
                headers: null,
                show_success: true,
                callback_params: null,
            }

            if(options)
            {
                for(let key in options)
                {
                    default_option[key] = options[key];
                }
            }

            let params = default_option.params;
            let method = default_option.method.toLowerCase();
            let query = default_option.query;
            let headers = default_option.headers;
            let show_success = default_option.show_success;
            let callback_params = default_option.callback_params;



            //To make axios request as ajax request
            axios.defaults.headers.common = {
                'X-Requested-With': 'XMLHttpRequest',
            };

            let q = {};

            q.params = query;

            if (headers) {
                q.headers = headers;
            }

            if (method === 'get') {
                params = {
                    params: query,
                };

                q = {};
                axios.interceptors.request.use(
                    function (config) {
                        config.paramsSerializer = function (params) {
                            return qs.stringify(params, {
                                arrayFormat: 'brackets',
                                encode: false,
                                skipNulls: true
                            })
                        }
                        return config;
                    },
                    function (error) {
                        return Promise.reject(error)
                    }
                );
            }

            if (method === 'delete') {
                params = {
                    data: params
                };
            }

            //Laravel 13: PreventRequestForgery verifies the request origin
            //(Sec-Fetch-Site) and falls back to CSRF token verification when
            //the header is absent (HTTP deployments, older browsers). Every
            //mutating request carries X-CSRF-TOKEN, read from the existing
            //`<meta name="csrf-token" id="_token">` in the admin head, in the
            //per-request config (never a global default, so GET requests
            //carry no CSRF header).
            const csrf_meta = document.querySelector('meta[name="csrf-token"]');
            const csrf_token = (csrf_meta && csrf_meta.content) ? csrf_meta.content : null;

            if(csrf_token && !['get', 'head', 'options'].includes(method))
            {
                if(method === 'delete')
                {
                    // axios.delete(url, config) — the config object here
                    // carries the header (the separate q config is not
                    // part of the existing delete call signature)
                    params.headers = {
                        'X-CSRF-TOKEN': csrf_token,
                    };
                }
                else
                {
                    q.headers = {
                        ...(q.headers || {}),
                        'X-CSRF-TOKEN': csrf_token,
                    };
                }
            }

            this.show_progress_bar = true;

            let ajax = await axios[method](url, params, q)
                .then(function (response) {
                    self.show_progress_bar = false;
                    if(show_success){
                        self.processResponse(response);
                    }
                    if(callback)
                    {
                        if(response.data && response.data.data)
                        {
                            callback(response.data.data, response,callback_params);
                        } else{
                            callback(false, response,callback_params);
                        }
                    }
                    return response;
                }).catch(function (error) {
                    self.show_progress_bar = false;
                    self.processError(error);
                    if(callback)
                    {
                        callback(false, error);
                    }
                    return error;
                });

            return ajax;
        },

        //----------------------------------------------------------
        processResponse: function(response)
        {


            if(response.data.errors || response.data.messages)
            {
                this.toast.removeAllGroups();
            }

            if(response.data.errors)
            {
                this.toastErrors(response.data.errors);
            }

            if(response.data.messages)
            {
                this.toastSuccess(response.data.messages);
            }
        },

        //----------------------------------------------------------
        processError: function(error)
        {
            //Laravel 13: PreventRequestForgery raises OriginMismatchException
            //-> HTTP 403 for a Sec-Fetch-Site origin mismatch, and
            //TokenMismatchException -> HTTP 419 for a missing or stale CSRF
            //token. F15: the two stay distinct — a 403 is an origin /
            //APP_URL mismatch (the operator's remedy is to fix APP_URL or
            //the proxy, not to retry), a 419 is the session-expired case.
            //Unrelated statuses (e.g. 500) fall through to the generic
            //error toast below.
            if(error.response
                && error.response.status
                && error.response.status === 403)
            {
                this.toastErrors(['Origin mismatch. The request origin does not match the application URL (APP_URL). Check APP_URL and your proxy configuration.']);
                return;
            }

            if(error.response
                && error.response.status
                && error.response.status === 419)
            {
                this.toastErrors(['Session Expired. Please sign in again.']);
                location.reload();
                return;
            }

            if(debug === 1)
            {
                this.toastErrors([error]);
            } else
            {
                this.toastErrors(['Something went wrong']);
            }
        },
        //----------------------------------------------------------
        getMessageAndDuration(messages)
        {
            let i = 1;
            let list_html = "";
            let duration = 3000;

            if(Object.keys(messages).length > 1)
            {
                for(let k in messages)
                {
                    list_html += i+") "+messages[k]+"<br/>";
                    i++;
                }
            } else
            {
                if(messages[0])
                {
                    list_html += messages[0];
                }
            }

            let chars = list_html.length
            let readable = 10; // readable character per second.

            duration = duration*(chars/readable);

            return {
                html: list_html,
                duration: duration
            };
        },
        //----------------------------------------------------------
        setToast: function (prime_toast)
        {
            this.toast = prime_toast;
        },
        //----------------------------------------------------------
        setConfirm: function (prime_confirm)
        {
            this.confirm = prime_confirm;
        },
        //----------------------------------------------------------
        toastSuccess(messages){

            let data = this.getMessageAndDuration(messages);
            if(data && data.html !== "")
            {
                this.toast.add({
                    severity: 'success',
                    detail: data.html,
                    life: data.duration
                });
            }
        },

        //----------------------------------------------------------
        toastErrors(messages){

            let data = this.getMessageAndDuration(messages);
            if(data && data.html !== "")
            {
                this.toast.add({
                    severity: 'error',
                    detail: data.html,
                    life: data.duration
                });
            }
        },
        //----------------------------------------------------------
        confirmDialog(heading, message, callbackOnAccept, callbackOnReject=null, acceptButtonClass='p-button-danger', icon='pi pi-info-circle')
        {
            // M3-T4 (F12): the single v3 -> v4 accept-button conversion point.
            // The removed v3 class-string prop is normalized here to the v4
            // accept button props object: p-button-danger maps to the v4
            // danger severity, density class strings to size. Callers keep
            // passing the legacy string — this method is the only place the
            // conversion happens.
            this.confirm.require({
                header: heading,
                message: message,
                icon: icon,
                acceptProps: this.toAcceptButtonProps(acceptButtonClass),
                accept: () => {
                    callbackOnAccept();
                },
                reject: () => {
                    if(callbackOnReject)
                    {
                        callbackOnReject();
                    }
                }
            });
        },
        //----------------------------------------------------------
        // M3-T4 (F12) — legacy accept-button class string -> v4 button props.
        toAcceptButtonProps(classString)
        {
            let cls = (classString && typeof classString === 'string')
                ? classString
                : 'p-button-danger';

            let props = {};
            if(cls.indexOf('p-button-danger') > -1)
            {
                props.severity = 'danger';
            }
            if(cls.indexOf('is-small') > -1 || cls.indexOf('p-button-sm') > -1)
            {
                props.size = 'small';
            }
            return props;
        },
        //----------------------------------------------------------
        confirmDialogDelete(callbackOnAccept)
        {
            this.confirmDialog('Delete Confirmation', 'Do you want to delete record(s)?', callbackOnAccept);
        },
        //----------------------------------------------------------
        clone: function (source)
        {
            return JSON.parse(JSON.stringify(source));
        },
        //----------------------------------------------------------
        ago: function (value) {
            if(!value)
            {
                return null;
            }

            const timeAgo = new TimeAgo('en-US')
            return timeAgo.format(new Date(value));
        },
        //----------------------------------------------------------
        cleanObject: function (obj)
        {
            Object.keys(obj).forEach(key => {
                if (obj[key] === null || obj[key] === 'null' || obj[key] === "") {
                    delete obj[key];
                }
            });

            return obj;
        },
        //----------------------------------------------------------
        copy: function (string)
        {
            if (!navigator.clipboard) {
                this.fallbackCopy(string);
                return;
            }

            let self = this;

            navigator.clipboard.writeText(string).then(function() {
                self.toastSuccess(['Copied']);
            }, function(err) {
                self.toastErrors(['Could not copied | '+err]);
            });

        },
        //----------------------------------------------------------
        fallbackCopy: function (string)
        {
            let textArea = document.createElement("textarea");
            textArea.value = string;

            // Avoid scrolling to bottom
            textArea.style.top = "0";
            textArea.style.left = "0";
            textArea.style.position = "fixed";

            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();

            let self = this;

            try {
                let successful = document.execCommand('copy');
                let msg = successful ? 'successful' : 'unsuccessful';
                self.toastSuccess(['Copied']);
            } catch (err) {
                self.toastErrors(['Could not copied | '+err]);
            }

            document.body.removeChild(textArea);
        },
        //----------------------------------------------------------
        toLabel: function(str)
        {
            if(typeof str === 'string' )
            {
                str = str.replace(/_/g, " ");
                str = str.replace(/-/g, " ");
                str = this.toUpperCaseWords(str);
                return str;
            }
        },
        //----------------------------------------------------------
        toUpperCaseWords: function(str)
        {
            if(str)
            {
                return str.charAt(0).toUpperCase() + str.slice(1);
            }
        },
        //----------------------------------------------------------
        removeInArrayByKey: function (array, element, key) {

            if(!Array.isArray(array))
            {
                return false;
            }

            array.map(function(item, index) {

                if(item[key] == element[key])
                {
                    array.splice(index, 1);
                }


            });

            return array;
        },
        //----------------------------------------------------------
        findInArrayByKey: function (array, key, value) {

            if(!Array.isArray(array))
            {
                return false;
            }

            let element = null;

            array.map(function(item, index) {

                if(item[key] == value)
                {
                    element = item;
                }

            });

            return element;
        },
        //----------------------------------------------------------
        updateArray: function(array, updatedElement) {
            const index = array.indexOf(updatedElement);
            array[index] = updatedElement;
            return array;
        },
        //----------------------------------------------------------
        hasPermission: function (permissions, slug) {

            if(!permissions)
            {
                return false;
            }

            if(permissions.length < 1)
            {
                return false;
            }

            return permissions.indexOf(slug) > -1 ? true : false;
        },
        //----------------------------------------------------------
        strToSlug(string) {
            // null/undefined guard: menu items (extended_views.sidebar_menu) can
            // carry a null label in some installs; an unguarded toString() aborts
            // the whole afterGetAssets() menu build and suppresses the top nav.
            if (string === null || string === undefined) {
                return '';
            }
            return string.toString().toLowerCase()
                .replace(/\s+/g, '-') // Replace spaces with -
                .replace(/&/g, '-and-') // Replace & with 'and'
                .replace(/--+/g, '-') // Replace multiple - with single -
                .replace(/a|á|à|ã|ả|ạ|ă|ắ|ằ|ẵ|ẳ|ặ|â|ấ|ầ|ẫ|ẩ|ậ/gi, 'a')  // Letter "a"
                .replace(/đ/gi, 'd') // Letter "d"
                .replace(/e|é|è|ẽ|ẻ|ẹ|ê|ế|ề|ễ|ể|ệ/gi, 'e') // Letter "e"
                .replace(/o|ó|ò|õ|ỏ|ọ|ô|ố|ồ|ỗ|ổ|ộ|ơ|ớ|ờ|ỡ|ở|ợ/gi, 'o') // Letter "o"
                .replace(/u|ú|ù|ũ|ủ|ụ|ư|ứ|ừ|ữ|ử|ự/gi, 'u') // Letter "u"
                .replace(/\s*$/g, '') // Trim the last whitespace
        },
        //----------------------------------------------------------
        existInArray: function(array, element) {
            const index = array.indexOf(element);

            if(index == -1)
            {
                return false;
            } else
            {
                return true;
            }
        },
        //----------------------------------------------------------
        validateEmail(value) {
            return /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(value);
        },
        //----------------------------------------------------------
        capitalising: function (str) {
            let capitalized = []
            str.split(' ').forEach(word => {
                capitalized.push(
                    word.charAt(0).toUpperCase() +
                    word.slice(1).toLowerCase()
                )
            })
            return capitalized.join(' ')
        },
        //----------------------------------------------------------
    }
})


// Pinia hot reload
if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(vaah, import.meta.hot))
}
