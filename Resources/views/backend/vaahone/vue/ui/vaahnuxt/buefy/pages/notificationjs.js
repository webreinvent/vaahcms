import globalComponents from "../../helpers/globalComponents";
import SideMenu from "../partials/SideMenu";

import Notification from '../../../vaahnuxt/buefy/components/Notification/Notification'
import NotificationCode from "!raw-loader!../../buefy/components/Notification/Notification";

import Types from '../../../vaahnuxt/buefy/components/Notification/Types'
import TypesCode from "!raw-loader!../../buefy/components/Notification/Types";

import Icons from '../../../vaahnuxt/buefy/components/Notification/Icons'
import IconsCode from "!raw-loader!../../buefy/components/Notification/Icons";

import AutoClose from '../../../vaahnuxt/buefy/components/Notification/AutoClose'
import AutoCloseCode from "!raw-loader!../../buefy/components/Notification/AutoClose";

import ProgrammaticallyOpening from '../../../vaahnuxt/buefy/components/Notification/ProgrammaticallyOpening'
import ProgrammaticallyOpeningCode from "!raw-loader!../../buefy/components/Notification/ProgrammaticallyOpening";

export default {
  layout: 'ui',
  head () {
    return {
      title: 'Buefy UI Block',
    }
  },
  computed: {
    NotificationCode() {return NotificationCode},
    TypesCode() {return TypesCode},
    IconsCode() {return IconsCode},
    AutoCloseCode() {return AutoCloseCode},
    ProgrammaticallyOpeningCode() {return ProgrammaticallyOpeningCode},
  },
  components: {
    ...globalComponents,
    SideMenu,
    Notification,
    Types,
    Icons,
    AutoClose,
    ProgrammaticallyOpening,

  },
  methods:{

  },

}
