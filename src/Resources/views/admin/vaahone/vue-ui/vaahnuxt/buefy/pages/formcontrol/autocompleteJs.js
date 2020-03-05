import globalComponents from "./../../../helpers/globalComponents";
import SideMenu from "./../../partials/SideMenu";

import AutoComplete from './../../components/FormControl/AutoComplete/AutoComplete'
import AutoCompleteCode from "!raw-loader!./../../components/FormControl/AutoComplete/AutoComplete";

import ObjectArray from './../../components/FormControl/AutoComplete/ObjectArray'
import ObjectArrayCode from "!raw-loader!./../../components/FormControl/AutoComplete/ObjectArray";

import Header from './../../components/FormControl/AutoComplete/Header'
import HeaderCode from "!raw-loader!./../../components/FormControl/AutoComplete/Header";

import Footer from './../../components/FormControl/AutoComplete/Footer'
import FooterCode from "!raw-loader!./../../components/FormControl/AutoComplete/Footer";



import AsyncWithCustomTemplate from './../../components/FormControl/AutoComplete/AsyncWithCustomTemplate'
import AsyncWithCustomTemplateCode from "!raw-loader!./../../components/FormControl/AutoComplete/AsyncWithCustomTemplate";

import AsyncWithInfiniteScroll from './../../components/FormControl/AutoComplete/AsyncWithInfiniteScroll'
import AsyncWithInfiniteScrollCode from "!raw-loader!./../../components/FormControl/AutoComplete/AsyncWithInfiniteScroll";

export default {
  layout: 'ui',
  head () {
    return {
      title: 'Buefy UI Block',
    }
  },
  computed: {
    AutoCompleteCode() {return AutoCompleteCode},
    ObjectArrayCode() {return ObjectArrayCode},
    HeaderCode() {return HeaderCode},
    FooterCode() {return FooterCode},
    AsyncWithCustomTemplateCode() {return AsyncWithCustomTemplateCode},
    AsyncWithInfiniteScrollCode() {return AsyncWithInfiniteScrollCode},
  },
  components: {
    ...globalComponents,
    SideMenu,
    AutoComplete,
    ObjectArray,
    Header,
    Footer,
    AsyncWithCustomTemplate,
    AsyncWithInfiniteScroll,

  },
  methods:{

  },

}
