import globalComponents from "./../../../helpers/globalComponents";
import SideMenu from "../../partials/SideMenu";

import TimePicker from './../../../../vaahnuxt/buefy/components/FormControl/Timepicker/TimePicker'
import TimePickerCode from "!raw-loader!./../../../buefy/components/FormControl/Timepicker/TimePicker";

import Editable from './../../../../vaahnuxt/buefy/components/FormControl/Timepicker/Editable'
import EditableCode from "!raw-loader!./../../../buefy/components/FormControl/Timepicker/Editable";

import Range from './../../../../vaahnuxt/buefy/components/FormControl/Timepicker/Range'
import RangeCode from "!raw-loader!./../../../buefy/components/FormControl/Timepicker/Range";

import Footer from './../../../../vaahnuxt/buefy/components/FormControl/Timepicker/Footer'
import FooterCode from "!raw-loader!./../../../buefy/components/FormControl/Timepicker/Footer";

import Inline from './../../../../vaahnuxt/buefy/components/FormControl/Timepicker/Inline'
import InlineCode from "!raw-loader!./../../../buefy/components/FormControl/Timepicker/Inline";

export default {
  layout: 'ui',
  head () {
    return {
      title: 'Buefy UI Block',
    }
  },
  computed: {
    TimePickerCode() {return TimePickerCode},
    EditableCode() {return EditableCode},
    RangeCode() {return RangeCode},
    FooterCode() {return FooterCode},
    InlineCode() {return InlineCode},
  },
  components: {
    ...globalComponents,
    SideMenu,
    TimePicker,
    Editable,
    Range,
    Footer,
    Inline,

  },
  methods:{

  },

}
