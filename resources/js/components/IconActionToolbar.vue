<template>

    <div :class="{ 'icon-action-toolbar-wrapper': standalone && isDetailView }">

        <div v-if="actions.length > 0"
             :class="{ 'rounded': standalone, 'rounded bg-gray-700/5 dark:bg-gray-950': !standalone }"
             class="flex dark:focus:ring-gray-600 justify-evenly">

            <div v-for="{ iconActionToolbar, destructive, uriKey, name } of actions">

                <button
                    v-tooltip="name"
                    v-if="iconActionToolbar"
                    :data-action-id="uriKey"
                    type="button"
                    @click.stop="() => $emit('click', uriKey)"
                    :class="{
                        'dark:hover:[&:not(:disabled)]:text-primary-500 px-2': parentType === 'ActionSelector',
                        'w-auto': !isDetailView && !standalone,
                        'px-3 w-auto': !isDetailView && parentType === 'LoadingView.vue',
                        'hover:[&:not(:disabled)]:text-red-400 dark:hover:[&:not(:disabled)]:text-red-400 min-w-9': destructive && !isDetailView,
                        'hover:[&:not(:disabled)]:text-primary-500 dark:hover:[&:not(:disabled)]:text-primary-500 min-w-9': !destructive && !isDetailView,
                        'rounded hover:bg-gray-200 dark:hover:bg-gray-800 focus:outline-none focus:ring px-3 hover:text-gray-500': standalone && isDetailView,
                    }"
                    class="inline-flex items-center justify-center toolbar-button h-9 dark:text-gray-400 text-gray-500 disabled:opacity-50 disabled:pointer-events-none">

                    <Icon v-if="typeof iconActionToolbar.icon !== 'string'" name="cube-transparent"/>

                    <template v-else-if="iconActionToolbar.icon?.trim()?.startsWith('<svg')">
                        <div v-html="iconActionToolbar.icon"/>
                    </template>

                    <Icon v-else-if="iconActionToolbar.icon" :name="iconActionToolbar.icon"/>

                    <div class="ml-1 mr-1 whitespace-nowrap" v-if="iconActionToolbar.label">
                        {{ iconActionToolbar.label }}
                    </div>

                </button>

            </div>

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

    .icon-action-toolbar-wrapper {
        width: calc(100% - 48px);
        overflow-x: auto;
    }

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
