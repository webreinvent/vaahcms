<template>
  <div>
    <div class="control">
      <textarea class="textarea" placeholder="Normal textarea"></textarea>
    </div>

    <div class="control">
      <textarea class="textarea is-hovered" placeholder="Hovered textarea"></textarea>
    </div>

    <div class="control">
      <textarea class="textarea is-focused" placeholder="Focused textarea"></textarea>
    </div>

    <div class="control is-loading">
      <textarea class="textarea" placeholder="Loading textarea"></textarea>
    </div>
    <div class="field">
      <div class="control is-small is-loading">
        <textarea class="textarea is-small" placeholder="Small loading textarea"></textarea>
      </div>
    </div>
    <div class="field">
      <div class="control is-loading">
        <textarea class="textarea" placeholder="Normal loading textarea"></textarea>
      </div>
    </div>
    <div class="field">
      <div class="control is-medium is-loading">
        <textarea class="textarea is-medium" placeholder="Medium loading textarea"></textarea>
      </div>
    </div>
    <div class="field">
      <div class="control is-large is-loading">
        <textarea class="textarea is-large" placeholder="Large loading textarea"></textarea>
      </div>
    </div>

    <div class="control">
      <textarea class="textarea" placeholder="Disabled textarea" disabled></textarea>
    </div>

    <div class="control">
      <textarea class="textarea" readonly>This content is readonly</textarea>
    </div>

    <div class="control">
      <textarea class="textarea has-fixed-size" placeholder="Fixed size textarea"></textarea>
    </div>
  </div>
</template>
