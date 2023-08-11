<template>
    <div class="container pt-5">
        <slot></slot>
    </div>
</template>

<script>
	export default {
		data () {
			return {
				
			}
		},
		props: {
			title: String,
		},
		watch: {
			title: {
				immediate: true,
				handler(title) {
					document.title = title
				},
			},
		},
	}
</script>

<style>
@import '~vue-awesome-notifications/dist/styles/style.css';
</style>