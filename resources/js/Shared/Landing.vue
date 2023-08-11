<template>
    <div>
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
