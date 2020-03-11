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

            <SectionTitle title="Buefy - Progress"
                          link="https://buefy.org/documentation/progress">
            </SectionTitle>


            <SectionCode name="Progress" :code="ProgressCode">
              <Progress></Progress>
            </SectionCode>


            <SectionCode name="Types" :code="TypesCode">
              <Types></Types>
            </SectionCode>


            <SectionCode name="Sizes" :code="SizesCode">
              <Sizes></Sizes>
            </SectionCode>


            <SectionCode name="Values" :code="ValuesCode">
              <Values></Values>
            </SectionCode>


            <SectionCode name="Slot" :code="SlotProgressCode">
              <SlotProgress></SlotProgress>
            </SectionCode>


          </div>

      </div>
    </section>

  </div>




  <Footer></Footer>


  </div>


</template>

<script src="./progressjs.js"></script>
