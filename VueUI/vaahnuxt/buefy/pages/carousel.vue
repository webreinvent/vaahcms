<template>

  <div>

    <TopMenu></TopMenu>
    <PageHeader></PageHeader>
    <div class="container" >

      <section class="main-content columns">
        <aside class="column is-2 section">
          <SideMenu></SideMenu>
        </aside>

        <div class="container column is-10">

            <div class="main-content">

              <SectionTitle title="Buefy - Carousel"
                            link="https://buefy.org/documentation/carousel">
              </SectionTitle>


              <SectionCode name="Carousel" :code="CarouselCode">
                <Carousel></Carousel>
              </SectionCode>


              <SectionCode name="Custom" :code="CustomCode">
                <Custom></Custom>
              </SectionCode>


              <SectionCode name="Arrow" :code="ArrowCode">
                <Arrow></Arrow>
              </SectionCode>


              <SectionCode name="Progress" :code="ProgressCode">
                <Progress></Progress>
              </SectionCode>


              <SectionCode name="Indicator" :code="IndicatorCode">
                <Indicator></Indicator>
              </SectionCode>


              <SectionCode name="Custom Indicators" :code="CustomIndicatorsCode">
                <CustomIndicators></CustomIndicators>
              </SectionCode>


              <SectionCode name="Switch Like A Gallery" :code="SwitchLikeAGalleryCode">
                <SwitchLikeAGallery></SwitchLikeAGallery>
              </SectionCode>


              <SectionCode name="Carousel List" :code="CarouselListCode">
                <CarouselList></CarouselList>
              </SectionCode>


              <SectionCode name="Custom With Card" :code="CustomWithCardCode">
                <CustomWithCard></CustomWithCard>
              </SectionCode>


              <SectionCode name="Custom As An Indicators" :code="CustomAsAnIndicatorsCode">
                <CustomAsAnIndicators></CustomAsAnIndicators>
              </SectionCode>

            </div>

        </div>
      </section>

    </div>




    <Footer></Footer>


  </div>



</template>

<script src="./carouseljs.js"></script>
