import globalComponents from "../../helpers/globalComponents";
import SideMenu from "../partials/SideMenu";

import Carousel from '../../../vaahnuxt/buefy/components/Carousel/Carousel'
import CarouselCode from "!raw-loader!../../buefy/components/Carousel/Carousel";

import Custom from '../../../vaahnuxt/buefy/components/Carousel/Custom'
import CustomCode from "!raw-loader!../../buefy/components/Carousel/Custom";

import Arrow from '../../../vaahnuxt/buefy/components/Carousel/Arrow'
import ArrowCode from "!raw-loader!../../buefy/components/Carousel/Arrow";

import Progress from '../../../vaahnuxt/buefy/components/Carousel/Progress'
import ProgressCode from "!raw-loader!../../buefy/components/Carousel/Progress";

import Indicator from '../../../vaahnuxt/buefy/components/Carousel/Indicator'
import IndicatorCode from "!raw-loader!../../buefy/components/Carousel/Indicator";

import CustomIndicators from '../../../vaahnuxt/buefy/components/Carousel/CustomIndicators'
import CustomIndicatorsCode from "!raw-loader!../../buefy/components/Carousel/CustomIndicators";

import SwitchLikeAGallery from '../../../vaahnuxt/buefy/components/Carousel/SwitchLikeAGallery'
import SwitchLikeAGalleryCode from "!raw-loader!../../buefy/components/Carousel/SwitchLikeAGallery";

import CarouselList from '../../../vaahnuxt/buefy/components/Carousel/CarouselList'
import CarouselListCode from "!raw-loader!../../buefy/components/Carousel/CarouselList";

import CustomWithCard from '../../../vaahnuxt/buefy/components/Carousel/CustomWithCard'
import CustomWithCardCode from "!raw-loader!../../buefy/components/Carousel/CustomWithCard";

import CustomAsAnIndicators from '../../../vaahnuxt/buefy/components/Carousel/CustomAsAnIndicators'
import CustomAsAnIndicatorsCode from "!raw-loader!../../buefy/components/Carousel/CustomAsAnIndicators";

export default {
  computed: {
    CarouselCode() {return CarouselCode},
    CustomCode() {return CustomCode},
    ArrowCode() {return ArrowCode},
    ProgressCode() {return ProgressCode},
    IndicatorCode() {return IndicatorCode},
    CustomIndicatorsCode() {return CustomIndicatorsCode},
    SwitchLikeAGalleryCode() {return SwitchLikeAGalleryCode},
    CarouselListCode() {return CarouselListCode},
    CustomWithCardCode() {return CustomWithCardCode},
    CustomAsAnIndicatorsCode() {return CustomAsAnIndicatorsCode},
  },
  components: {
    ...globalComponents,
    SideMenu,
    Carousel,
    Custom,
    Arrow,
    Progress,
    Indicator,
    CustomIndicators,
    SwitchLikeAGallery,
    CarouselList,
    CustomWithCard,
    CustomAsAnIndicators,

  },
  methods:{

  },

}
