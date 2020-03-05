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

            <SectionTitle title="Buefy - Dropdown"
                          link="https://buefy.org/documentation/dropdown">
            </SectionTitle>


            <SectionCode name="Dropdown" :code="DropdownCode">
              <Dropdown></Dropdown>
            </SectionCode>


            <SectionCode name="Content And Position" :code="ContentAndPositionCode">
              <ContentAndPosition></ContentAndPosition>
            </SectionCode>


            <SectionCode name="Links Within" :code="LinksWithinCode">
              <LinksWithin></LinksWithin>
            </SectionCode>


            <SectionCode name="Customizing With V-Model" :code="CustomizingWithVModelCode">
              <CustomizingWithVModel></CustomizingWithVModel>
            </SectionCode>


            <SectionCode name="Multiple" :code="MultipleCode">
              <Multiple></Multiple>
            </SectionCode>

          </div>

        </div>
      </section>

    </div>




    <Footer></Footer>


  </div>



</template>

<script src="./dropdownjs.js"></script>
