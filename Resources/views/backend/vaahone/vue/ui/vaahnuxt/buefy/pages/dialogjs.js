import globalComponents from "../../helpers/globalComponents";
import SideMenu from "../partials/SideMenu";

import Alert from '../../../vaahnuxt/buefy/components/Dialog/Alert'
import AlertCode from "!raw-loader!../../buefy/components/Dialog/Alert";

import Confirm from '../../../vaahnuxt/buefy/components/Dialog/Confirm'
import ConfirmCode from "!raw-loader!../../buefy/components/Dialog/Confirm";

import Prompt from '../../../vaahnuxt/buefy/components/Dialog/Prompt'
import PromptCode from "!raw-loader!../../buefy/components/Dialog/Prompt";

export default {
  layout: 'ui',
  head () {
    return {
      title: 'Buefy UI Block',
    }
  },
  computed: {
    AlertCode() {return AlertCode},
    ConfirmCode() {return ConfirmCode},
    PromptCode() {return PromptCode},
  },
  components: {
    ...globalComponents,
    SideMenu,
    Alert,
    Confirm,
    Prompt,

  },
  methods:{

  },

}
