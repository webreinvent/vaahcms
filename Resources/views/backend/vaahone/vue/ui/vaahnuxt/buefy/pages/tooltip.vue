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

          <SectionTitle title="Buefy - Tooltip"
                        link="https://buefy.org/documentation/tooltip">
          </SectionTitle>


          <SectionCode name="Tooltip" :code="ToolTipCode">
            <ToolTip></ToolTip>
          </SectionCode>



          <SectionCode name="Styles" :code="StylesCode">
            <Styles></Styles>
          </SectionCode>



          <SectionCode name="Multilined" :code="MultilinedCode">
            <Multilined></Multilined>
          </SectionCode>



          <SectionCode name="Toggle" :code="ToggleCode">
            <Toggle></Toggle>
          </SectionCode>


        </div>

      </div>
    </section>

  </div>




  <Footer></Footer>


  </div>

</template>

<script src="./tooltipjs.js"></script>
