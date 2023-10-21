<template>

    <div v-if="actions.length > 0"
         :class="{ 'rounded': standalone, 'rounded-lg bg-gray-100 dark:bg-gray-700': !standalone }"
         class="flex dark:focus:ring-gray-600 justify-evenly">

        <div v-for="{ iconActionToolbar, destructive, uriKey, name } of actions">

            <button
                v-tooltip="name"
                v-if="iconActionToolbar"
                type="button"
                @click.stop="() => $emit('click', uriKey)"
                :class="{
                    'hover:text-red-500': destructive,
                    'hover:text-primary-500': !destructive
                }"
                class="toolbar-button px-2 disabled:opacity-50 disabled:pointer-events-none">

                <Icon v-if="typeof iconActionToolbar.icon !== 'string'" type="cube-transparent"/>

                <template v-else-if="iconActionToolbar.icon?.trim()?.startsWith('<svg')">
                    <div v-html="iconActionToolbar.icon"/>
                </template>

                <Icon v-else-if="iconActionToolbar.icon" :type="iconActionToolbar.icon"/>

                <div class="ml-1" v-if="iconActionToolbar.label">
                    {{ iconActionToolbar.label }}
                </div>

            </button>

        </div>

    </div>

</template>

<script>

    export default {
        emits: [ 'click' ],
        props: [ 'actions', 'standalone' ],
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
