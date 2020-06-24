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

            <SectionTitle title="Buefy - Notification"
                          link="https://buefy.org/documentation/notification">
            </SectionTitle>


            <SectionCode name="Notification" :code="NotificationCode">
              <Notification></Notification>
            </SectionCode>


            <SectionCode name="Types" :code="TypesCode">
              <Types></Types>
            </SectionCode>


            <SectionCode name="Icons" :code="IconsCode">
              <Icons></Icons>
            </SectionCode>


            <SectionCode name="Auto Close" :code="AutoCloseCode">
              <AutoClose></AutoClose>
            </SectionCode>


            <SectionCode name="Programmatically Opening" :code="ProgrammaticallyOpeningCode">
              <ProgrammaticallyOpening></ProgrammaticallyOpening>
            </SectionCode>


          </div>

      </div>
    </section>

  </div>




  <Footer></Footer>


  </div>

</template>

<script src="./notificationjs.js"></script>
