import globalComponents from "./../../../helpers/globalComponents";
import SideMenu from "../../partials/SideMenu";

import DateTimePicker from './../../../../vaahnuxt/buefy/components/FormControl/Datetimepicker/DateTimePicker'
import DateTimePickerCode from "!raw-loader!./../../../buefy/components/FormControl/Datetimepicker/DateTimePicker";

import Editable from './../../../../vaahnuxt/buefy/components/FormControl/Datetimepicker/DateTimePicker'
import EditableCode from "!raw-loader!./../../../buefy/components/FormControl/Datetimepicker/DateTimePicker";

import Range from './../../../../vaahnuxt/buefy/components/FormControl/Datetimepicker/Range'
import RangeCode from "!raw-loader!./../../../buefy/components/FormControl/Datetimepicker/Range";

import Footer from './../../../../vaahnuxt/buefy/components/FormControl/Datetimepicker/Footer'
import FooterCode from "!raw-loader!./../../../buefy/components/FormControl/Datetimepicker/Footer";

import Inline from './../../../../vaahnuxt/buefy/components/FormControl/Datetimepicker/Inline'
import InlineCode from "!raw-loader!./../../../buefy/components/FormControl/Datetimepicker/Inline";

export default {
  layout: 'ui',
  head () {
    return {
      title: 'Buefy UI Block',
    }
  },
  computed: {
    DateTimePickerCode() {return DateTimePickerCode},
    EditableCode() {return EditableCode},
    RangeCode() {return RangeCode},
    FooterCode() {return FooterCode},
    InlineCode() {return InlineCode},
  },
  components: {
    ...globalComponents,
    SideMenu,
    DateTimePicker,
    Editable,
    Range,
    Footer,
    Inline

  },
  methods:{

  },

}
