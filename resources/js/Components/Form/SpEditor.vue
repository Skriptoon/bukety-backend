<script setup>
import Editor from '@tinymce/tinymce-vue'

defineProps({
    modelValue: Object,
    name: String,
    label: String,
})
</script>

<template>
    <label for="name">{{ label }}</label>
    <Editor
        v-model="modelValue[name]"
        :id="name"
        :init="{
        height: 500,
        menubar: false,
        plugins: [
          'advlist autolink lists link image charmap print preview anchor',
          'searchreplace visualblocks code fullscreen',
          'insertdatetime media table paste code help wordcount'
        ],
        toolbar:
          'undo redo | formatselect | bold italic backcolor | \
          alignleft aligncenter alignright alignjustify | \
          bullist numlist outdent indent | removeformat | help'
      }"
        api-key="2i85nyo5tx6d5bg7m49fxo96at2okw0zn6i6pflg97j21nre"
    />
</template>

<style scoped>

</style>
