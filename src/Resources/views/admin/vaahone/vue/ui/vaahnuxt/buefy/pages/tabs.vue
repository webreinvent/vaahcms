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

          <SectionTitle title="Buefy - Tabs"
                        link="https://buefy.org/documentation/tabs">
          </SectionTitle>


          <SectionCode name="Tabs" :code="TabsCode">
            <Tabs></Tabs>
          </SectionCode>


          <SectionCode name="Dynamic" :code="DynamicCode">
            <Dynamic></Dynamic>
          </SectionCode>


          <SectionCode name="Position" :code="PositionCode">
            <Position></Position>
          </SectionCode>


          <SectionCode name="Icons" :code="IconsCode">
            <Icons></Icons>
          </SectionCode>


          <SectionCode name="Sizes" :code="SizesCode">
            <Sizes></Sizes>
          </SectionCode>


          <SectionCode name="Types" :code="TypesCode">
            <Types></Types>
          </SectionCode>


          <SectionCode name="Expanded" :code="ExpandedCode">
            <Expanded></Expanded>
          </SectionCode>


          <SectionCode name="Custom Headers" :code="CustomHeadersCode">
            <CustomHeaders></CustomHeaders>
          </SectionCode>


          <SectionCode name="Vertical" :code="VerticalCode">
            <Vertical></Vertical>
          </SectionCode>


        </div>

      </div>
    </section>

  </div>




  <Footer></Footer>


  </div>

</template>

<script src="./tabsjs.js"></script>
