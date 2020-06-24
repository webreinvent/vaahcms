 <template>
   <div>

     <TopMenu></TopMenu>
     <BlockTopMenu></BlockTopMenu>
     <PageHeader></PageHeader>

     <div class="main-content">


      <SectionCode name="SectionHPLImageLeft UI Block" :code="SampleCode">
        <Sample :content="c.SectionHPLImageLeft"></Sample>
      </SectionCode>



      <SectionCode name="SectionHPLImageRight UI Block" :code="SectionHPLImageRightCode">
        <SectionHPLImageRight :content="c.SectionHPLImageRight"></SectionHPLImageRight>
      </SectionCode>



      <SectionCode name="SectionHPImageSmallLeft UI Block" :code="SectionHPImageSmallLeftCode">
        <SectionHPImageSmallLeft :content="c.SectionHPImageSmallLeft"></SectionHPImageSmallLeft>
      </SectionCode>



      <SectionCode name="SectionHPListImageRight UI Block" :code="SectionHPListImageRightCode">
        <SectionHPListImageRight :content="c.SectionHPListImageRight"></SectionHPListImageRight>
      </SectionCode>



      <SectionCode name="ServiceLoopFour UI Block" :code="ServiceLoopFourCode">
        <ServiceLoopFour :content="c.ServiceLoopFour"></ServiceLoopFour>
      </SectionCode>



      <SectionCode name="ServicesBigImageWithBox UI Block" :code="ServicesBigImageWithBoxCode">
        <ServicesBigImageWithBox :content="c.ServicesBigImageWithBox"></ServicesBigImageWithBox>
      </SectionCode>



      <SectionCode name="ServicesLoopEight UI Block" :code="ServicesLoopEightCode">
        <ServicesLoopEight :content="c.ServicesLoopEight"></ServicesLoopEight>
      </SectionCode>



      <SectionCode name="ServicesLoopEightLeftImage UI Block" :code="ServicesLoopEightLeftImageCode">
        <ServicesLoopEightLeftImage :content="c.ServicesLoopEightLeftImage"></ServicesLoopEightLeftImage>
      </SectionCode>



      <SectionCode name="ServicesLoopNine UI Block" :code="ServicesLoopNineCode">
        <ServicesLoopNine :content="c.ServicesLoopNine"></ServicesLoopNine>
      </SectionCode>



      <SectionCode name="ServicesLoopTen UI Block" :code="ServicesLoopTenCode">
        <ServicesLoopTen :content="c.ServicesLoopTen"></ServicesLoopTen>
      </SectionCode>



      <SectionCode name="ServicesLoopSeven UI Block" :code="ServicesLoopSevenCode">
        <ServicesLoopSeven :content="c.ServicesLoopSeven"></ServicesLoopSeven>
      </SectionCode>



      <SectionCode name="ServicesLoopOnlyData UI Block" :code="ServicesLoopOnlyDataCode">
        <ServicesLoopOnlyData :content="c.ServicesLoopOnlyData"></ServicesLoopOnlyData>
      </SectionCode>



      <SectionCode name="ServicesLoopThree UI Block" :code="ServicesLoopThreeCode">
        <ServicesLoopThree :content="c.ServicesLoopThree"></ServicesLoopThree>
      </SectionCode>



      <SectionCode name="ServicesLoopThreeOnlyPList UI Block" :code="ServicesLoopThreeOnlyPListCode">
        <ServicesLoopThreeOnlyPList :content="c.ServicesLoopThreeOnlyPList"></ServicesLoopThreeOnlyPList>
      </SectionCode>


     </div>

     <Footer></Footer>

   </div>

</template>

<script>

  import globalComponents from "../../helpers/globalComponents";
  import content from '../../../vaahnuxt/content/content.json'

  import BlockTopMenu from "../../../vaahnuxt/blocks/partials/BlockTopMenu";


  import Sample from "../../../vaahnuxt/blocks/components/Sample";
  import SampleCode from "!raw-loader!../../../vaahnuxt/blocks/components/Sample";

  import SectionHPLImageRight from "../../../vaahnuxt/blocks/components/SectionHPLImageRight";
  import SectionHPLImageRightCode from "!raw-loader!../../../vaahnuxt/blocks/components/SectionHPLImageRight";

  import SectionHPImageSmallLeft from "../../../vaahnuxt/blocks/components/SectionHPImageSmallLeft";
  import SectionHPImageSmallLeftCode from "!raw-loader!../../../vaahnuxt/blocks/components/SectionHPImageSmallLeft";

  import SectionHPListImageRight from "../../../vaahnuxt/blocks/components/SectionHPListImageRight";
  import SectionHPListImageRightCode from "!raw-loader!../../../vaahnuxt/blocks/components/SectionHPListImageRight";

  import ServiceLoopFour from "../../../vaahnuxt/blocks/components/ServiceLoopFour";
  import ServiceLoopFourCode from "!raw-loader!../../../vaahnuxt/blocks/components/ServiceLoopFour";

  import ServicesBigImageWithBox from "../../../vaahnuxt/blocks/components/ServicesBigImageWithBox";
  import ServicesBigImageWithBoxCode from "!raw-loader!../../../vaahnuxt/blocks/components/ServicesBigImageWithBox";

  import ServicesLoopEight from "../../../vaahnuxt/blocks/components/ServicesLoopEight";
  import ServicesLoopEightCode from "!raw-loader!../../../vaahnuxt/blocks/components/ServicesLoopEight";

  import ServicesLoopEightLeftImage from "../../../vaahnuxt/blocks/components/ServicesLoopEightLeftImage";
  import ServicesLoopEightLeftImageCode from "!raw-loader!../../../vaahnuxt/blocks/components/ServicesLoopEightLeftImage";

  import ServicesLoopNine from "../../../vaahnuxt/blocks/components/ServicesLoopNine";
  import ServicesLoopNineCode from "!raw-loader!../../../vaahnuxt/blocks/components/ServicesLoopNine";

  import ServicesLoopTen from "../../../vaahnuxt/blocks/components/ServicesLoopTen";
  import ServicesLoopTenCode from "!raw-loader!../../../vaahnuxt/blocks/components/ServicesLoopTen";

  import ServicesLoopSeven from "../../../vaahnuxt/blocks/components/ServicesLoopSeven";
  import ServicesLoopSevenCode from "!raw-loader!../../../vaahnuxt/blocks/components/ServicesLoopSeven";

  import ServicesLoopOnlyData from "../../../vaahnuxt/blocks/components/ServicesLoopOnlyData";
  import ServicesLoopOnlyDataCode from "!raw-loader!../../../vaahnuxt/blocks/components/ServicesLoopOnlyData";

  import ServicesLoopThree from "../../../vaahnuxt/blocks/components/ServicesLoopThree";
  import ServicesLoopThreeCode from "!raw-loader!../../../vaahnuxt/blocks/components/ServicesLoopThree";

  import ServicesLoopThreeOnlyPList from "../../../vaahnuxt/blocks/components/ServicesLoopThreeOnlyPList";
  import ServicesLoopThreeOnlyPListCode from "!raw-loader!../../../vaahnuxt/blocks/components/ServicesLoopThreeOnlyPList";



  export default {
    layout: 'ui',
    head () {
      return {
        title: 'VaahNuxt UI components- Blocks',
      }
    },
    computed: {
      SampleCode() {
        return SampleCode
      },
      SectionHPLImageRightCode() {
        return SectionHPLImageRightCode
      },
      SectionHPImageSmallLeftCode() {
        return SectionHPImageSmallLeftCode
      },
      SectionHPListImageRightCode() {
        return SectionHPListImageRightCode
      },
      ServiceLoopFourCode() {
        return ServiceLoopFourCode
      },
      ServicesBigImageWithBoxCode() {
        return ServicesBigImageWithBoxCode
      },
      ServicesLoopEightCode() {
        return ServicesLoopEightCode
      },
      ServicesLoopEightLeftImageCode() {
        return ServicesLoopEightLeftImageCode
      },
      ServicesLoopNineCode() {
        return ServicesLoopNineCode
      },
      ServicesLoopTenCode() {
        return ServicesLoopTenCode
      },
      ServicesLoopSevenCode() {
        return ServicesLoopSevenCode
      },
      ServicesLoopOnlyDataCode() {
        return ServicesLoopOnlyDataCode
      },
      ServicesLoopThreeCode() {
        return ServicesLoopThreeCode
      },
      ServicesLoopThreeOnlyPListCode() {
        return ServicesLoopThreeOnlyPListCode
      }
    },
    components: {
      ...globalComponents,
      BlockTopMenu,
      SectionHPLImageRight,
      SectionHPImageSmallLeft,
      ServicesBigImageWithBox,
      SectionHPListImageRight,
      ServiceLoopFour,
      Sample,
      ServicesLoopEight,
      ServicesLoopEightLeftImage,
      ServicesLoopNine,
      ServicesLoopTen,
      ServicesLoopSeven,
      ServicesLoopOnlyData,
      ServicesLoopThree,
      ServicesLoopThreeOnlyPList,
    },
    data(){
      let obj = {
        c: content
      };
      return obj;
    },
    mounted() {


    },
    methods:{

    },

  }
</script>
