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

              <SectionTitle title="Buefy - Dialog"
                            link="https://buefy.org/documentation/dialog">
              </SectionTitle>


              <SectionCode name="Alert" :code="AlertCode">
                <Alert></Alert>
              </SectionCode>


              <SectionCode name="Confirm" :code="ConfirmCode">
                <Confirm></Confirm>
              </SectionCode>


              <SectionCode name="Prompt" :code="PromptCode">
                <Prompt></Prompt>
              </SectionCode>

            </div>

        </div>
      </section>

    </div>




    <Footer></Footer>


  </div>


</template>

<script src="./dialogjs.js"></script>
