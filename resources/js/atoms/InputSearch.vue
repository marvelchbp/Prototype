<script>
export default {
  props: ['modelValue'],
  emits: ['update:modelValue']
}
</script>

<template>
  <input
    type="text"
    placeholder="Cari Disini.."
    class="form-control lbl-text"
    id="InputSearch"
    :value="modelValue"
    @input="$emit('update:modelValue', $event.target.value)"
  />
</template>