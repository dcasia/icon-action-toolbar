<template>

    <div v-if="actions.length > 0"
         :class="{ 'rounded': standalone, 'rounded-lg bg-gray-100 dark:bg-gray-700': !standalone }"
         class="flex ml-1 dark:focus:ring-gray-600 justify-evenly">

        <div v-for="{ iconActionToolbar, destructive, uriKey, name } of actions">

            <Dropdown
                v-if="iconActionToolbar"
                v-tooltip="name"
                :handle-internal-clicks="false"
                :class="{
                    'rounded hover:bg-gray-200 dark:hover:bg-gray-800': standalone,
                    'rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700': !standalone,
                    'hover:text-red-500': destructive,
                    'hover:text-primary-500': !destructive,
                }"
                class="flex h-9 hover-element"
                :trigger-override-function="() => $emit('click', uriKey)">

                <div class="space-x-2 flex justify-center items-center"
                     :class="{ 'px-3 h-9': standalone, 'px-2': !standalone }">

                    <Icon v-if="typeof iconActionToolbar.icon !== 'string'" type="cube-transparent"/>

                    <template v-else-if="iconActionToolbar.icon?.trim()?.startsWith('<svg')">
                        <div v-html="iconActionToolbar.icon"/>
                    </template>

                    <Icon v-else-if="iconActionToolbar.icon" :type="iconActionToolbar.icon"/>

                    <div v-if="iconActionToolbar.label">
                        {{ iconActionToolbar.label }}
                    </div>

                </div>

            </Dropdown>

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
