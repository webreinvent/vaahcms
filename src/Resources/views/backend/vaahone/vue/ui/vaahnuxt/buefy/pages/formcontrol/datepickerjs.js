import globalComponents from "./../../../helpers/globalComponents";
import SideMenu from "../../partials/SideMenu";

import Datepicker from './../../../../vaahnuxt/buefy/components/FormControl/Datepicker/Datepicker'
import DatepickerCode from "!raw-loader!./../../../buefy/components/FormControl/Datepicker/Datepicker";

import Editable from './../../../../vaahnuxt/buefy/components/FormControl/Datepicker/Editable'
import EditableCode from "!raw-loader!./../../../buefy/components/FormControl/Datepicker/Editable";

import Range from './../../../../vaahnuxt/buefy/components/FormControl/Datepicker/Range'
import RangeCode from "!raw-loader!./../../../buefy/components/FormControl/Datepicker/Range";

import Footer from './../../../../vaahnuxt/buefy/components/FormControl/Datepicker/Footer'
import FooterCode from "!raw-loader!./../../../buefy/components/FormControl/Datepicker/Footer";

import Header from './../../../../vaahnuxt/buefy/components/FormControl/Datepicker/Header'
import HeaderCode from "!raw-loader!./../../../buefy/components/FormControl/Datepicker/Header";

import MonthPicker from './../../../../vaahnuxt/buefy/components/FormControl/Datepicker/MonthPicker'
import MonthPickerCode from "!raw-loader!./../../../buefy/components/FormControl/Datepicker/MonthPicker";

import ProgrammaticallyOpening from './../../../../vaahnuxt/buefy/components/FormControl/Datepicker/ProgrammaticallyOpening'
import ProgrammaticallyOpeningCode from "!raw-loader!./../../../buefy/components/FormControl/Datepicker/ProgrammaticallyOpening";

import Inline from './../../../../vaahnuxt/buefy/components/FormControl/Datepicker/Inline'
import InlineCode from "!raw-loader!./../../../buefy/components/FormControl/Datepicker/Inline";

import Events from './../../../../vaahnuxt/buefy/components/FormControl/Datepicker/Events'
import EventsCode from "!raw-loader!./../../../buefy/components/FormControl/Datepicker/Events";

import SelectARangeOfDates from './../../../../vaahnuxt/buefy/components/FormControl/Datepicker/SelectARangeOfDates'
import SelectARangeOfDatesCode from "!raw-loader!./../../../buefy/components/FormControl/Datepicker/SelectARangeOfDates";

import SelectMultipleDates from './../../../../vaahnuxt/buefy/components/FormControl/Datepicker/SelectMultipleDates'
import SelectMultipleDatesCode from "!raw-loader!./../../../buefy/components/FormControl/Datepicker/SelectMultipleDates";

export default {
  layout: 'ui',
  head () {
    return {
      title: 'Buefy UI Block',
    }
  },
  computed: {
    DatepickerCode() {return DatepickerCode},
    EditableCode() {return EditableCode},
    RangeCode() {return RangeCode},
    FooterCode() {return FooterCode},
    HeaderCode() {return HeaderCode},
    MonthPickerCode() {return MonthPickerCode},
    ProgrammaticallyOpeningCode() {return ProgrammaticallyOpeningCode},
    InlineCode() {return InlineCode},
    EventsCode() {return EventsCode},
    SelectARangeOfDatesCode() {return SelectARangeOfDatesCode},
    SelectMultipleDatesCode() {return SelectMultipleDatesCode},
  },
  components: {
    ...globalComponents,
    SideMenu,
    Datepicker,
    Editable,
    Range,
    Footer,
    Header,
    MonthPicker,
    ProgrammaticallyOpening,
    Inline,
    Events,
    SelectARangeOfDates,
    SelectMultipleDates,

  },
  methods:{

  },

}
