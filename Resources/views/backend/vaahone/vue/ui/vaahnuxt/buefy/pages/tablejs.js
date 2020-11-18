import globalComponents from "../../helpers/globalComponents";
import SideMenu from "../partials/SideMenu";

import Table from '../../../vaahnuxt/buefy/components/Table/Table'
import TableCode from "!raw-loader!../../buefy/components/Table/Table";

import SandboxWithCustomTemplate from '../../../vaahnuxt/buefy/components/Table/SandboxWithCustomTemplate'
import SandboxWithCustomTemplateCode from "!raw-loader!../../buefy/components/Table/SandboxWithCustomTemplate";

import Selection from '../../../vaahnuxt/buefy/components/Table/Selection'
import SelectionCode from "!raw-loader!../../buefy/components/Table/Selection";

import Checkable from '../../../vaahnuxt/buefy/components/Table/Checkable'
import CheckableCode from "!raw-loader!../../buefy/components/Table/Checkable";

import Searchable from '../../../vaahnuxt/buefy/components/Table/Searchable'
import SearchableCode from "!raw-loader!../../buefy/components/Table/Searchable";

import PaginationAndSorting from '../../../vaahnuxt/buefy/components/Table/PaginationAndSorting'
import PaginationAndSortingCode from "!raw-loader!../../buefy/components/Table/PaginationAndSorting";

import DetailedRows from '../../../vaahnuxt/buefy/components/Table/DetailedRows'
import DetailedRowsCode from "!raw-loader!../../buefy/components/Table/DetailedRows";

import CustomDetailedRows from '../../../vaahnuxt/buefy/components/Table/CustomDetailedRows'
import CustomDetailedRowsCode from "!raw-loader!../../buefy/components/Table/CustomDetailedRows";

import RowStatus from '../../../vaahnuxt/buefy/components/Table/RowStatus'
import RowStatusCode from "!raw-loader!../../buefy/components/Table/RowStatus";

import CustomHeaders from '../../../vaahnuxt/buefy/components/Table/CustomHeaders'
import CustomHeadersCode from "!raw-loader!../../buefy/components/Table/CustomHeaders";

import Subheadings from '../../../vaahnuxt/buefy/components/Table/Subheadings'
import SubheadingsCode from "!raw-loader!../../buefy/components/Table/Subheadings";

import ToggleColumns from '../../../vaahnuxt/buefy/components/Table/ToggleColumns'
import ToggleColumnsCode from "!raw-loader!../../buefy/components/Table/ToggleColumns";

import Footer from '../../../vaahnuxt/buefy/components/Table/Footer'
import FooterCode from "!raw-loader!../../buefy/components/Table/Footer";

import AsyncData from '../../../vaahnuxt/buefy/components/Table/AsyncData'
import AsyncDataCode from "!raw-loader!../../buefy/components/Table/AsyncData";

import DraggableRows from '../../../vaahnuxt/buefy/components/Table/DraggableRows'
import DraggableRowsCode from "!raw-loader!../../buefy/components/Table/DraggableRows";

export default {
  layout: 'ui',
  head () {
    return {
      title: 'Buefy UI Block',
    }
  },
  computed: {
    TableCode() {return TableCode},
    SandboxWithCustomTemplateCode() {return SandboxWithCustomTemplateCode},
    SelectionCode() {return SelectionCode},
    CheckableCode() {return CheckableCode},
    SearchableCode() {return SearchableCode},
    PaginationAndSortingCode() {return PaginationAndSortingCode},
    DetailedRowsCode() {return DetailedRowsCode},
    CustomDetailedRowsCode() {return CustomDetailedRowsCode},
    RowStatusCode() {return RowStatusCode},
    CustomHeadersCode() {return CustomHeadersCode},
    SubheadingsCode() {return SubheadingsCode},
    ToggleColumnsCode() {return ToggleColumnsCode},
    FooterCode() {return FooterCode},
    AsyncDataCode() {return AsyncDataCode},
    DraggableRowsCode() {return DraggableRowsCode},

  },
  components: {
    ...globalComponents,
    SideMenu,
    Table,
    SandboxWithCustomTemplate,
    Selection,
    Checkable,
    Searchable,
    PaginationAndSorting,
    DetailedRows,
    CustomDetailedRows,
    RowStatus,
    CustomHeaders,
    Subheadings,
    ToggleColumns,
    Footer,
    AsyncData,
    DraggableRows,

  },
  methods:{

  },

}
