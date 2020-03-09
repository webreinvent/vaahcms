

import Fuse from "fuse.js";

import VhCopy from "../../resuable/VhCopy";
import VhCodeCopy from "../../resuable/VhCodeCopy";

import CheatsheetContent from "./Cheatsheet-Content";
import CheatsheetContentCode from "!raw-loader!./Cheatsheet-Content";

import content from "../../content/cheatsheet";

import SectionCode from '../../resuable/SectionCode';
import SectionTitle from "../../resuable/SectionTitle";
import Table from "../../../pages/ui/bulma/elements/table";

import TemplateRow from '!raw-loader!../../content/html/TemplateRow.html'
import TemplateRowFullWidth from '!raw-loader!../../content/html/TemplateRowFullWidth.html'
import TemplateRowFullWidthFluid from '!raw-loader!../../content/html/TemplateRowFullWidthFluid.html'
import TemplateScreenSize from '!raw-loader!../../content/html/TemplateScreenSize.html'
import TemplateColumns from '!raw-loader!../../content/html/TemplateColumns.html'
import TemplateLevel from '!raw-loader!../../content/html/TemplateLevel.html'
import TemplateHero from '!raw-loader!../../content/html/TemplateHero.html'
import TemplateContent from '!raw-loader!../../content/html/TemplateContent.html'
import TemplateBlock from '!raw-loader!../../content/html/TemplateBlock.html'



export default {
  components:{
    VhCodeCopy,
    Table,
    CheatsheetContent,
    VhCopy,
    SectionTitle,
    SectionCode,
    TemplateRow,
    TemplateRowFullWidth,
    TemplateScreenSize,
    TemplateColumns,
    TemplateLevel,
    TemplateHero,
    TemplateContent,
    TemplateBlock,
  },
  data()
  {
    let obj = {
      content: content,
      contentCode: '<div class="columns">\n' +
        '    <div class="column"></div>\n' +
        '    <div class="column"></div>\n' +
        '    <div class="column"></div>\n' +
        '    <div class="column"></div>\n' +
        '    <div class="column"></div>\n' +
        '</div>',
      templates:{
        row: TemplateRow,
        row_full_hd: TemplateRowFullWidth,
        row_full_fluid: TemplateRowFullWidthFluid,
        screen_size: TemplateScreenSize,
        columns: TemplateColumns,
        level: TemplateLevel,
        hero: TemplateHero,
        block: TemplateBlock,
        content: TemplateContent,
      },

      //----autocomplete users
      q: null,
      isOpen: 0,
      list: content,
      list_filtered: content,
      data: [],
      isTyping: null,
      fuse_config: {
        shouldSort: true,
        threshold: 0.2,
        location: 0,
        distance: 100,
        maxPatternLength: 32,
        minMatchCharLength: 1,
        keys: ['list.class']
      }
      //----/autocomplete users


    };

    return obj;
  },


  mounted(){

  },
  computed: {
    CheatsheetContentCode() {
      return CheatsheetContentCode
    },
  },
  watch: {
    q: function (newValue, oldValue) {

      let timeout;
      let self = this;

      clearTimeout(timeout);

      // Make a new timeout set to go off in 1000ms (1 second)
      timeout = setTimeout(function () {
        self.getFilteredList(newValue);
      }, 600);

      //this.getFilteredList(newValue);
    },
  },
  methods: {
    getFilteredList(text) {

      let config = this.fuse_config;

      let list_filtered;

      if(text)
      {
        let fuse = new Fuse(this.list, config);
        list_filtered = fuse.search(text);
      } else
      {
        list_filtered = this.list;
      }


      this.list_filtered = list_filtered;

      console.log('--->this.list_filtered', this.list_filtered);

    }

  }
}
