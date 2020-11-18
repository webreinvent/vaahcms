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

          <SectionTitle title="Buefy - Field"
                        link="https://buefy.org/documentation/field/">
          </SectionTitle>


          <SectionCode name="Field" :code="FieldCode">
            <Field></Field>
          </SectionCode>


          <SectionCode name="Label Position" :code="LabelPositionCode">
            <LabelPosition></LabelPosition>
          </SectionCode>


          <SectionCode name="Object Syntax" :code="ObjectSyntaxCode">
            <ObjectSyntax></ObjectSyntax>
          </SectionCode>


          <SectionCode name="Addons" :code="AddonsCode">
            <Addons></Addons>
          </SectionCode>


          <SectionCode name="Groups" :code="GroupsCode">
            <Groups></Groups>
          </SectionCode>


          <SectionCode name="Nested Groups" :code="NestedGroupsCode">
            <NestedGroups></NestedGroups>
          </SectionCode>


          <SectionCode name="Responsive Groups" :code="ResponsiveGroupsCode">
            <ResponsiveGroups></ResponsiveGroups>
          </SectionCode>


          <SectionCode name="Positions" :code="PositionsCode">
            <Positions></Positions>
          </SectionCode>


          <SectionCode name="Combining Addons And Groups" :code="CombiningAddonsAndGroupsCode">
            <CombiningAddonsAndGroups></CombiningAddonsAndGroups>
          </SectionCode>


          <SectionCode name="Horizontal" :code="HorizontalCode">
            <Horizontal></Horizontal>
          </SectionCode>


          <SectionCode name="Label Classes" :code="LabelClassesCode">
            <LabelClasses></LabelClasses>
          </SectionCode>


          <SectionCode name="Label Slot" :code="LabelSlotCode">
            <LabelSlot></LabelSlot>
          </SectionCode>


        </div>

      </div>
    </section>

  </div>




  <Footer></Footer>


  </div>

</template>

<script src="./fieldjs.js"></script>
