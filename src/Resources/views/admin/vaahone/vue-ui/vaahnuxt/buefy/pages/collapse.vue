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

              <SectionTitle title="Buefy - Collapse"
                            link="https://buefy.org/documentation/collapse">
              </SectionTitle>


              <SectionCode name="Collapse" :code="CollapseCode">
                <Collapse></Collapse>
              </SectionCode>


              <SectionCode name="Panel" :code="PanelCode">
                <Panel></Panel>
              </SectionCode>


              <SectionCode name="Card" :code="CardCode">
                <Card></Card>
              </SectionCode>


              <SectionCode name="Position" :code="PositionCode">
                <Position></Position>
              </SectionCode>


              <SectionCode name="Accordion Effect" :code="AccordionEffectCode">
                <AccordionEffect></AccordionEffect>
              </SectionCode>

            </div>

        </div>
      </section>

    </div>




    <Footer></Footer>


  </div>


</template>

<script src="./collapsejs.js"></script>
