<template>
	<div class='container'>
        <slot></slot>
        <menu-footer/>
    </div>
</template>
<script>
import MenuFooter from '@/components/MenuFooter.vue';
export default {
	components: {
        MenuFooter,
	},
	name: "Template",
	mounted(){
        const _this = this;
        
        if (!Object.values(this.$page.props.messages).every(element => element === null)) {
            let to_toast = Object.entries(this.$page.props.messages).find(([key, value]) => value !== null);
            _this.$toast.open({
                message: to_toast[1],
                type: to_toast[0],
            });
        }
	},
};
</script>