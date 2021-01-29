<template>
  <div>
    <div class="control">
      <input class="input" type="text" placeholder="Normal input">
      <div class="control">
        <input class="input is-hovered" type="text" placeholder="Hovered input">
      </div>
      <div class="control">
        <input class="input is-focused" type="text" placeholder="Focused input">
      </div>
      <div class="control is-loading">
        <input class="input" type="text" placeholder="Loading input">
      </div>
      <div class="field">
        <div class="control is-small is-loading">
          <input class="input is-small" type="text" placeholder="Small loading input">
        </div>
      </div>
      <div class="field">
        <div class="control is-loading">
          <input class="input" type="text" placeholder="Normal loading input">
        </div>
      </div>
      <div class="field">
        <div class="control is-medium is-loading">
          <input class="input is-medium" type="text" placeholder="Medium loading input">
        </div>
      </div>
      <div class="field">
        <div class="control is-large is-loading">
          <input class="input is-large" type="text" placeholder="Large loading input">
        </div>
      </div>
      <div class="control">
        <input class="input" type="text" placeholder="Disabled input" disabled>
      </div>
    </div>
  </div>
</template>
