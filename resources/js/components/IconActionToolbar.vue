<template>

    <div v-if="actions.length > 0"
         :class="{ 'rounded': standalone, 'rounded-lg bg-gray-700/5 dark:bg-gray-700': !standalone }"
         class="flex dark:focus:ring-gray-600 justify-evenly">

        <div v-for="{ iconActionToolbar, destructive, uriKey, name } of actions">

            <button
                v-tooltip="name"
                v-if="iconActionToolbar"
                type="button"
                @click.stop="() => $emit('click', uriKey)"
                :class="{
                    'dark:hover:text-primary-500': parentType === 'ActionSelector',
                    'h-9 w-auto': !isDetailView && !standalone,
                    'hover:text-red-500': destructive && !isDetailView,
                    'dark:hover:text-primary-500 hover:text-primary-500': !destructive && !isDetailView,
                    'rounded hover:bg-gray-200 dark:hover:bg-gray-800 focus:outline-none focus:ring px-3 hover:text-gray-500': standalone && isDetailView
                }"
                class="toolbar-button dark:text-gray-400 text-gray-500 px-2 disabled:opacity-50 disabled:pointer-events-none">

                <Icon v-if="typeof iconActionToolbar.icon !== 'string'" name="cube-transparent"/>

                <template v-else-if="iconActionToolbar.icon?.trim()?.startsWith('<svg')">
                    <div v-html="iconActionToolbar.icon"/>
                </template>

                <Icon v-else-if="iconActionToolbar.icon" :name="iconActionToolbar.icon"/>

                <div class="ml-1 whitespace-nowrap" v-if="iconActionToolbar.label">
                    {{ iconActionToolbar.label }}
                </div>

            </button>

        </div>

    </div>

</template>

<script>

    import { Icon, Button } from 'laravel-nova-ui'

    export default {
        components: { Icon, Button },
        emits: [ 'click' ],
        props: [ 'actions', 'standalone', 'parentType' ],
        computed: {
            isDetailView() {
                return Nova.$router.page.component === 'Nova.Detail'
                    && this.parentType === 'DetailActionDropdown.vue'
            },
        },
    }

</script>

<style lang="scss">

    div[dusk$="detail-component"] div.icon-action-toolbar {
        @apply mx-0;
    }

    table div.icon-action-toolbar .hover-element {

        &:hover {
            @apply bg-transparent #{!important};
        }

        button > div {
            @apply px-3;
        }

    }

</style>
