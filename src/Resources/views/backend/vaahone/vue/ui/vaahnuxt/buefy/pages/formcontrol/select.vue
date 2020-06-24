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

            <SectionTitle title="Buefy - Select"
                          link="https://buefy.org/documentation/select/">
            </SectionTitle>


            <SectionCode name="Select" :code="SelectCode">
              <Select></Select>
            </SectionCode>


            <SectionCode name="Multiple" :code="MultipleCode">
              <Multiple></Multiple>
            </SectionCode>


            <SectionCode name="Icons" :code="IconsCode">
              <Icons></Icons>
            </SectionCode>


            <SectionCode name="Sizes" :code="SizesCode">
              <Sizes></Sizes>
            </SectionCode>


          </div>

      </div>
    </section>

  </div>




  <Footer></Footer>


  </div>

</template>

<script src="./selectjs.js"></script>
