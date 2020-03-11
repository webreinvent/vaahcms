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

            <SectionTitle title="Buefy - Steps"
                          link="https://buefy.org/documentation/steps">
            </SectionTitle>


            <SectionCode name="Steps" :code="StepsCode">
              <Steps></Steps>
            </SectionCode>


            <SectionCode name="Dynamic" :code="DynamicCode">
              <Dynamic></Dynamic>
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


          </div>

      </div>
    </section>

  </div>




  <Footer></Footer>


  </div>

</template>

<script src="./stepsjs.js"></script>
